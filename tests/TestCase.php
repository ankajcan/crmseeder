<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use \Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $token;

    public $headers;

    public $user;

    public function authenticateUser()
    {
        $user = factory(\App\Models\User::class)->create();

        factory(\Spatie\Permission\Models\Role::class)->create([
            'name' => 'Admin'
        ]);

        $user->assignRole('Admin');

        $this->token = JWTAuth::attempt(['email' => $user->email, 'password' => 'admin']);

        $this->headers = [
            'Authorization' => 'Bearer ' . $this->token
        ];

        $this->user = JWTAuth::toUser($this->token);
    }
}
