<?php

namespace App\Http\Controllers\Web;

use App\Models\Asset;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Project\Services\AwsService;
use Project\Services\FileService;

class AssetController extends ApiController
{

    /*
    |--------------------------------------------------------------------------
    | AJAX
    |--------------------------------------------------------------------------
    */

    public function delete(Request $request, $id)
    {
        $file = Asset::find($id);

        AwsService::removeFromS3($file->path);

        $file->delete();

        return $this->respond(["message" => "File deleted successfully"]);
    }

    public function upload(Request $request)
    {

        $filePath = FileService::saveFileLocal($request->files->get('file'));

        // Upload to AWS
        $filename = FileService::getFileNameFromPath($filePath);

        $key = 'tmp/' . $filename;
        $result = AwsService::uploadToS3($key, $filePath);

        if (!$result["status"]) {
            return $this->setStatusCode(400)->respondWithError($result);
        }

        $newFile = new Asset([
            'name' => $filename,
            'path' => $key,
            'entity_id' => 0,
            'entity_type' => 0,
            'type' => 0,
            'featured' => 0
        ]);

        $newFile->save();

        return $this->respond(["data" => $newFile->url]);
    }

}
