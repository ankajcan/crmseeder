<?php
namespace Project\Services;

use App\Models\Asset;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;

class FileService {

    public static function createThumbnail($filePath, $options = [])
    {
        $dir = public_path("files/tmp/thumb");
        $filename = self::getFileNameFromPath($filePath);

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $manager = new ImageManager(array('driver' => 'gd'));
        $img = $manager->make($filePath)->fit(250);
        $img->save($dir."/".$filename);
        $thumbPath = $dir.'/'.$filename;

        return $thumbPath;
    }

    public static function getFileNameFromPath($filePath)
    {
        $filenameArr = explode("/",$filePath);
        return $filenameArr[count($filenameArr) - 1];
    }

    public static function saveFileLocal($uploadedFile)
    {
        $dirPath = "files/tmp";
        $dir = public_path($dirPath);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $filename = $uploadedFile->getClientOriginalName();
        $filePath = $dirPath.'/'.$filename;
        $uploadedFile->move($dir,$filename);

        return $filePath;
    }

    public static function saveRemoteFileLocal($url)
    {
        $dirPath = "files/tmp";
        $dir = public_path($dirPath);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $filename = sha1(uniqid(mt_rand(), true)).".jpg";
        $filePath = $dirPath.'/'.$filename;

        file_put_contents($filePath, fopen($url, 'r'));

        return $filePath;
    }

    public static function resizeImage($filePath, $options = [])
    {
        $size = isset($options['size']) ? $options['size'] : 960;

        $manager = new ImageManager(array('driver' => 'gd'));
        $img = $manager->make($filePath)->resize($size, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $img->save($filePath);

        return $filePath;
    }

    /**
     * Upload file to a new entity
     * @param $filePath
     * @return array
     */
    public static function uploadAsset($filePath) {

        DB::beginTransaction();

        try {
            $filename = FileService::getFileNameFromPath($filePath);

            $key = 'tmp/'.$filename;
            $result = AwsService::uploadToS3($key, $filePath);
            if (!$result["status"]) {
                DB::rollBack();
                return $result;
            }

            $newFile = new Asset([
                'name' => $filename,
                'path' => $key,
                'entity_id' => 0,
                'entity_type' => 0,
                'type' => 0,
                'size' => filesize($filePath) ? filesize($filePath) : 0,
                'user_id' => Auth::id()
            ]);
            $newFile->save();

            // SAVE THUMB IF IMAGE
            if($newFile->file_type == "image") {
                $thumbPath = FileService::createThumbnail($filePath);
                $key = 'tmp/thumb/' . $filename;
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


}