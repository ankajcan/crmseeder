<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /** @test */
    public function a_user_can_login()
    {
        $user = factory(\App\Models\User::class)->create();

        $response = $this->json('POST', 'api/v1/login', [
            'email' => $user->email,
            'password' => 'admin'
        ]);

        $response->assertStatus(200)->assertJsonFragment(['email' => $user->email]);
    }

    /** @test */
    public function it_should_not_allow_invalid_credentials()
    {
        factory(\App\Models\User::class)->create();

        $response = $this->post('api/v1/login', [
            'email' => 'wrong@email.com',
            'password' => 'password'
        ]);

        $response->assertStatus(401)->assertJsonFragment(['message' => 'Invalid credentials']);
    }

    /** @test */
    public function login_data_is_required()
    {
        factory(\App\Models\User::class)->create();

        $response = $this->json('POST', 'api/v1/login', []);

        $response->assertStatus(422)->assertJsonFragment(['message' => 'Validation failed']);
        $response->assertJsonFragment(["details" =>
            [
                "email" => ["The email field is required."],
                "password" => ["The password field is required."]
            ]
        ]);

    }
}
