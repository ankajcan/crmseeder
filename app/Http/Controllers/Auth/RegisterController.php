<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\ApiController;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RegisterController extends ApiController
{
    public function register(UserRegistrationRequest $request)
    {
        $user = User::create(array_merge($request->all(),['username' => null, 'confirmation_code' => str_random(30)]));

        $user->assignRole(Role::from('roles') ->whereIn('name', ['user'])->first());
        $user->save();

        event(new UserRegistered($user));

        return $this->respond(["message" => "Account created successfully"]);
    }
}
