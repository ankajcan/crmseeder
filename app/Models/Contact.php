<?php

namespace App\Models;

use App\Events\ContactDeleted;
use App\Http\Requests\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Project\Services\AwsService;
use Project\Services\FileService;

class Contact extends Model
{
    use Notifiable;

    const TYPE_PERSON = 1;
    const TYPE_ORGANISATION = 2;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    public $guarded = ['id'];

    protected $fillable = ['type', 'title', 'name', 'first_name', 'last_name', 'email', 'phone', 'user_id', 'company_id'];

    protected $events = [
        'deleted' => ContactDeleted::class,
    ];

    public function address()
    {
        return $this->hasOne(Address::class, 'contact_id');
    }

    public function files()
    {
        return $this->hasMany(Asset::class, 'entity_id', 'id')->where(["entity_type" => self::class]);
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'entity_id', 'id')->where(["entity_type" => self::class]);
    }

    public function manageAddress($request)
    {
        $address = $request->get('address');

        if(isset($address['id'])) {
            $this->address->update($address);
        } else {
            Address::create(array_merge(['contact_id' => $this->id],$address));
        }
    }

    public function getFullNameAttribute($value)
    {
        if($this->type == self::TYPE_ORGANISATION) {
            return $this->name;
        } else {
            return $this->first_name . " ". $this->last_name;
        }
    }

    /**
     * Upload local file to Amazon S3
     * @param $filePath
     * @return mixed
     */
    public function uploadFile($filePath)
    {

        DB::beginTransaction();

        try {
            $filename = FileService::getFileNameFromPath($filePath);

            $key = 'contacts/'. $this->id . '/'.$filename;
            $result = AwsService::uploadToS3($key, $filePath);
            if (!$result["status"]) {
                DB::rollBack();
                return $result;
            }

            $newFile = new Asset([
                'name' => $filename,
                'path' => $key,
                'entity_id' => $this->id,
                'entity_type' => self::class,
                'type' => 0,
                'size' => filesize($filePath) ? filesize($filePath) : 0,
                'user_id' => Auth::id()
            ]);
            $newFile->save();

            // SAVE THUMB IF IMAGE
            if($newFile->file_type == "image") {
                $thumbPath = FileService::createThumbnail($filePath);
                $key = 'contacts/' . $this->id . '/thumb/' . $filename;
                AwsService::uploadToS3($key,$thumbPath);
                if (!$result["status"]) {
                    DB::rollBack();
                    return $result;
                }
            }


        } catch (\Exception $e) {
            DB::rollBack();
            return ["status" => false, "message" => $e->getMessage()];
        }

        DB::commit();

        return ["status" => true, "message" => "Successfully", "data" => $newFile];
    }

    /**
     * Save uploaded files when new entity created
     * @param $request
     * @return mixed
     */
    public function saveFiles($request)
    {
        if(!$request->has('files')) { return false; }

        $assetIDs = $request->get('files');

        foreach($assetIDs as $assetID) {

            $asset = Asset::find($assetID);
            if(!$asset) { continue; }

            $newKey = 'contacts/'. $this->id . '/'.$asset->name;
            $result = AwsService::copy($newKey,$asset->path);
            if (!$result["status"]) {
                return $result;
            }

            // COPY THUMB IF IMAGE
            if($asset->file_type == "image") {
                $key = 'contacts/'. $this->id . '/thumb/'.$asset->name;
                $result = AwsService::copy($key,$asset->thumb_path);
            }

            // REMOVE TMP
            AwsService::removeFromS3($asset->path);

            // UPDATE ASSET
            $asset->update(["entity_type" => self::class, "entity_id" => $this->id, "path" => $newKey]);
        }

        return ["status" => true, "message" => "Successfully"];

    }

    public static function search($request)
    {
        $query = (new Contact())->newQuery();
        $query->select('contacts.*');

        if($request->has('search')) {
            $search = $request->get('search');

            $query->where(function ($query) use ($search) {
                $query->where('contacts.first_name', 'LIKE', '%'.$search.'%');
                $query->orWhere('contacts.last_name', 'LIKE', '%'.$search.'%');
                $query->orWhere('contacts.email', 'LIKE', '%'.$search.'%');
                $query->orWhere('contacts.phone', 'LIKE', '%'.$search.'%');
            });
        }

        $query->orderBy('contacts.created_at', 'desc');

        $query->distinct();

        return $query->paginate();
    }

}
