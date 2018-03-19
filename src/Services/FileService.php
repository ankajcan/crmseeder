<?php
namespace Project\Services;

use Illuminate\Support\Facades\App;
use Intervention\Image\ImageManager;

class FileService {

    public static function createThumbnail($filePath, $options = [])
    {
        $dir = public_path("files/tmp/250x250");
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


}