<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\ApiController;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Project\Services\FileService;


class AccountController extends ApiController
{

    /*
    |--------------------------------------------------------------------------
    | AJAX
    |--------------------------------------------------------------------------
    */
    public function update(UserUpdateRequest $request)
    {

        $entity = User::find(Auth::id());

        $entity->update($request->all());

        return $this->respond(["message" => "Account updated successfully"]);
    }

    public function avatar_upload(Request $request)
    {
        $file = FileService::saveFileLocal($request->files->get('file'));

        $entity = User::find(Auth::id());

        // Upload to AWS
        $response = $entity->uploadAvatar($file);

        if(!$response["status"]) {
            return $this->setStatusCode(400)->respondWithError($response['message']);
        }

        $uploadedFile = $response['data'];

        return $this->respond(view('account/avatar', ['avatar' => $uploadedFile])->render());
    }

    /*
    |--------------------------------------------------------------------------
    | HTML
    |--------------------------------------------------------------------------
    */
    public function show(Request $request)
    {
        $entity = User::find(Auth::id());

        return view('account/show', ["entity" => $entity]);
    }

}
