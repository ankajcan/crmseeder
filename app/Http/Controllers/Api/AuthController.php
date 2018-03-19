<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends ApiController
{
    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        if ( ! $token = JWTAuth::attempt($credentials)) {
            return $this->setStatusCode(401)->respondWithError('Invalid credentials');
        }

        $user = JWTAuth::toUser($token);


        $user->permissionsList = $user->getAllPermissions()->pluck('name');
        $user->rolesList = $user->roles()->pluck('name');

        return response()->json(compact('token', 'user'));
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {

                return $this->setStatusCode(404)->respondWithError('User not found');
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return $this->setStatusCode($e->getStatusCode())->respondWithError('Token expired');

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return $this->setStatusCode($e->getStatusCode())->respondWithError('Token invalid');

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return $this->setStatusCode($e->getStatusCode())->respondWithError('Token missing');

        }

        $user->roles = $user->roles()->pluck('name');
        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }




}
