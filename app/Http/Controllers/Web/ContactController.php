<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\ApiController;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Transformers\AssetTransformer;
use App\Http\Transformers\UserTransformer;
use App\Models\User;
use Illuminate\Http\Request;


class ContactController extends ApiController
{
    private $entityClass = User::class;
    private $entityTransformer = UserTransformer::class;
    private $entityName = "User";

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
        $user = User::create($request->all());
        $user->save();

        $user->syncRoles($request->get('roles'));

        $user->uploadAvatar($request->get('avatar'));

        return $this->respond(["message" => "User created successfully"]);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);

        $user->update($request->all());

        $user->syncRoles($request->get('roles'));

        $user->uploadAvatar($request->get('avatar'));

        return $this->respond(["message" => "User updated successfully"]);
    }

    public function delete(Request $request, $id)
    {
        User::find($id)->delete();

        return $this->respond(["message" => "User deleted successfully"]);
    }

    /*
    |--------------------------------------------------------------------------
    | HTML
    |--------------------------------------------------------------------------
    */

    public function listEntity(Request $request)
    {
        $users = User::all();

        return view('user/users', ["users" => $users]);
    }

    public function singleEntity(Request $request, $id)
    {
        $user = $id == "new" ? new User() : User::find($id);

        return view('user/user', ["user" => $user]);
    }

}
