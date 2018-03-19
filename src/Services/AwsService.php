<?php
namespace Project\Services;

use Aws\S3\Exception\S3Exception;
use Illuminate\Support\Facades\App;

class AwsService{

    public static function uploadToS3($key, $filePath)
    {
        $s3 = App::make('aws')->createClient('s3');

        try {
            $result = $s3->putObject(array(
                'Bucket' => env('AWS_S3_BUCKET'),
                'Key' => $key,
                'SourceFile' => $filePath,
                'ACL' => 'public-read'
            ));

            return  ["status" => true, "data" => $result];

        } catch (S3Exception $e) {

            return  ["status" => false, "message" => $e->getMessage()];
        }

    }

    public static function removeFromS3($key)
    {
        $s3 = App::make('aws')->createClient('s3');

        $s3->deleteObject(array(
            'Bucket' => env('AWS_S3_BUCKET'),
            'Key'    => $key
        ));
    }

}