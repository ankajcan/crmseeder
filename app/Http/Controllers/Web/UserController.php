<?php

namespace App\Http\Controllers\Web;

use App\Events\UserInvited;
use App\Http\Controllers\ApiController;
use App\Http\Requests\UserInviteRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Transformers\UserTransformer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends ApiController
{

    const MODEL_CLASS = User::class;
    const MODEL_NAME = "User";
    const MODEL_TEMPLATE_PATH = "user";

    public function __construct()
    {
        parent::__construct();
        $this->setTransformer(new UserTransformer());
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX
    |--------------------------------------------------------------------------
    */

    public function store(UserStoreRequest $request)
    {
        $model = self::MODEL_CLASS;

        $entity = $model::create($request->all());
        $entity->save();

        $entity->syncRoles($request->get('roles'));

        $entity->uploadAvatar($request->get('avatar'));

        return $this->respond(["message" => self::MODEL_NAME. " created successfully"]);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $model = self::MODEL_CLASS;

        $entity = $model::find($id);

        $entity->update($request->all());

        $entity->syncRoles($request->get('roles'));

        $entity->uploadAvatar($request->get('avatar'));

        return $this->respond(["message" => self::MODEL_NAME. " updated successfully"]);
    }

    public function delete(Request $request, $id)
    {
        $model = self::MODEL_CLASS;

        $model::find($id)->delete();

        return $this->respond(["message" => self::MODEL_NAME. "  deleted successfully"]);
    }

    public function invite(UserInviteRequest $request)
    {
        $model = self::MODEL_CLASS;

        $entity = $model::create(array_merge($request->all(),['invitation' => str_random(30), 'status' => User::STATUS_INVITED, 'password' => Hash::make(str_random(30))]));
        $entity->save();

        $entity->syncRoles($request->has('roles') ? $request->get('roles') : []);

        event(new UserInvited($entity));

        return $this->respond(["message" => self::MODEL_NAME. " invited successfully"]);
    }

    public function avatarUpload(Request $request)
    {
        $response = app(self::MODEL_CLASS)->saveAvatar($request->files->get('file'));

        if(!$response["status"]) {
            return $this->setStatusCode(400)->respondWithError($response['message']);
        }

        return $this->respond($response["data"]);
    }




    /*
    |--------------------------------------------------------------------------
    | HTML
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $model = self::MODEL_CLASS;

        $entities = $model::search($request);

        return view(self::MODEL_TEMPLATE_PATH.'/index', ["entities" => $entities]);
    }

    public function search(Request $request)
    {
        $model = self::MODEL_CLASS;

        $entities = $model::search($request);

        return $this->respond(view(self::MODEL_TEMPLATE_PATH.'/list', ["entities" => $entities])->render());
    }

    public function show(Request $request, $id)
    {
        $model = self::MODEL_CLASS;

        $entity = $id == "new" ? new $model() : $model::find($id);

        return view(self::MODEL_TEMPLATE_PATH.'/show', ["entity" => $entity]);
    }

    public function invitation(Request $request)
    {
        $model = self::MODEL_CLASS;

        $entity = new $model();

        return view(self::MODEL_TEMPLATE_PATH.'/invite', ["entity" => $entity]);
    }

}
