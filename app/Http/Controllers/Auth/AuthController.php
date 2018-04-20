<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\ApiController;
use App\Http\Requests\InvitationAcceptRequest;
use App\Http\Requests\LoginFacebookRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AuthController extends ApiController
{
    /*
    |--------------------------------------------------------------------------
    | AJAX
    |--------------------------------------------------------------------------
    */
    public function login(LoginRequest $request)
    {
        $user = User::whereEmail($request->get('email'))->first();

        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        if (!Auth::attempt($credentials)) {
            return $this->setStatusCode(422)->respondWithError("Email or password are wrong");
        }

        if($user->status != User::STATUS_ACTIVE) {
            if($user->status == User::STATUS_REGISTERED) {
                return $this->setStatusCode(422)->respondWithError("Account is not confirmed");
            } else if($user->status == User::STATUS_INVITED) {
                return $this->setStatusCode(422)->respondWithError("Invitation not accepted");
            } else if($user->status == User::STATUS_DISABLED) {
                return $this->setStatusCode(422)->respondWithError("Account is disabled");
            } else {
                return $this->setStatusCode(422)->respondWithError("Account is not active");
            }
        }

        return $this->respond("Login successfully");
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }

    public function invitation_accept(InvitationAcceptRequest $request, $invitation)
    {
        $user = User::whereInvitation($invitation)->first();

        if(!$user) {
            throw new \Exception("User not found");
        }

        $user->status = User::STATUS_ACTIVE;
        $user->password = Hash::make($request->get('password'));
        $user->invitation = null;
        $user->save();

        return view('auth/invitation', ["entity" => $user]);
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW
    |--------------------------------------------------------------------------
    */

    public function confirmation($confirmation)
    {
        $user = User::whereConfirmation($confirmation)->first();

        if(!$user) {
            throw new \Exception("User not found");
        }

        $user->status = User::STATUS_ACTIVE;
        $user->confirmation = null;
        $user->save();

        return Redirect::route('login');
    }

    public function invitation($invitation)
    {
        $user = User::whereInvitation($invitation)->first();

        if(!$user) {
            throw new \Exception("User not found");
        }

        return view('auth/invitation', ["entity" => $user]);
    }


}
