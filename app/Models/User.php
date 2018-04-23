<?php

namespace App\Models;

use App\Mail\UserResetPasswordMail;
use Aws\S3\Exception\S3Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Project\Services\FileService;
use Spatie\Permission\Traits\HasRoles;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Auth\Passwords\CanResetPassword as ResetPassword;
use Project\Services\AwsService;


class User extends Model implements AuthenticatableContract,AuthorizableContract,CanResetPasswordContract
{
    use Authenticatable, Authorizable, HasRoles, ResetPassword, Notifiable;

    const STATUS_ACTIVE = 1; // login
    const STATUS_INVITED = 2; // require to accept invitation
    const STATUS_REGISTERED = 3; // required confirmation
    const STATUS_DISABLED = 4; // disabled

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'first_name', 'last_name', 'email', 'password', 'facebook_id','confirmation', 'phone', 'invitation', 'status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function avatar()
    {
        return $this->hasOne(Asset::class, 'entity_id', 'id')->where(["entity_type"=>User::class, "type" => Asset::USER_TYPE_AVATAR]);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = $value ? $value : $this->first_name." ".$this->last_name;
    }

    public function getStatusTextAttribute()
    {
        $statuses = [
            self::STATUS_ACTIVE => "Active",
            self::STATUS_INVITED => "Invited",
            self::STATUS_REGISTERED => "Registered",
            self::STATUS_DISABLED => "Disabled",
        ];

        return isset($statuses[$this->status]) ? $statuses[$this->status] : '';
    }

    /*
    |--------------------------------------------------------------------------
    | DOMAIN METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        Mail::send(new UserResetPasswordMail($this,$token));
    }


    public static function search($request)
    {
        $query = (new User())->newQuery();
        $query->select('users.*');

        if($request->has('search')) {
            $search = $request->get('search');

            $query->where(function ($query) use ($search) {
                $query->where('users.first_name', 'LIKE', '%'.$search.'%');
                $query->orWhere('users.last_name', 'LIKE', '%'.$search.'%');
                $query->orWhere('users.email', 'LIKE', '%'.$search.'%');
                $query->orWhere('users.username', 'LIKE', '%'.$search.'%');
            });
        }

        $query->orderBy('users.created_at', 'desc');

        $query->distinct();

        return $query->paginate();
    }

    /**
     * Upload local file to Amazon S3
     * @param $filePath
     * @return mixed
     */
    public function uploadAvatar($filePath)
    {
        if($filePath == "") { return false; }

        // RESIZE IMAGE
        $filePath = FileService::resizeImage($filePath, ["size" => 250]);

        // UPLOAD TO S3
        $filename = FileService::getFileNameFromPath($filePath);
        $key = 'users/' . $this->id . '/' . $filename;

        $result = AwsService::uploadToS3($key,$filePath);
        if(!$result["status"]) {
            return  $result;
        }

        // REMOVE CURRENT AVATAR
        if($this->avatar) {
            AwsService::removeFromS3($this->avatar->path);
            $this->avatar->delete();
        }

        // CREATE NEW ENTITY
        $newFile = new Asset([
            'name' => $filename,
            'path' => $key,
            'entity_id' => $this->id,
            'entity_type' => User::class,
            'type' => Asset::USER_TYPE_AVATAR
        ]);

        $newFile->save();

        return  ["status" => true, "message" => "Successfully", "data" => $newFile];
    }

    /**
     * Save file on local
     * @param UploadedFile $file
     * @return array
     */
    public function saveAvatar(UploadedFile $file)
    {
        try {
            $dirPath = "files/users/tmp";
            $dir = public_path($dirPath);
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            $filename = $file->getClientOriginalName();
            $filePath = $dirPath.'/'.$filename;
            $file->move($dir,$filename);

            return  ["status" => true, "message" => "Successfully", "data" => $filePath];

        } catch (\Exception $e) {
            return  ["status" => false, "message" => $e->getMessage()];
        }

    }

}
