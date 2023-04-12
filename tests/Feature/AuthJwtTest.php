<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Env;
use Tests\TestCase;

class AuthJwtTest extends TestCase
{


    // public function testUserHadi()
    // {
    //     $this->post('/api/auth/register', [
    //         "name" => "Hadi",
    //         "email" => "hadi@gmail.com",
    //         "password" => "qwerty123",
    //         "password_confirmation" => "qwerty123"

    //     ])->assertStatus(201)->assertSeeText('User successfully registered')->assertJsonStructure(["message", "user"]);
    // }

    public function testRegisterSuccess()
    {
        $this->post('/api/auth/register', [
            // "name" => "Hadi",
            // "email" => "hadi@gmail.com",
            // "password" => "qwerty123",
            // "password_confirmation" => "qwerty123"
            "name" => fake("id")->name("male"),
            "email" => fake('id')->email(),
            "password" => "qwerty123",
            "password_confirmation" => "qwerty123"
        ])->assertStatus(201)->assertSeeText('User successfully registered')->assertJsonStructure(["message", "user"]);
    }

    public function testLoginSuccess()
    {
        $res = $this->post('/api/auth/login', [
            "email" => "andrian@gmail.com",
            "password" => "qwerty123"
        ]);
        // putenv("JWT_TEST_USER=" . $res["access_token"]);
        $res->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
            'user'
        ]);
    }

    public function testRegisterValidation()
    {
        $this->post('/api/auth/register', [
            "email" => "andjjaddwwdw"
        ])->assertStatus(400);
    }

    public function testLoginValidation()
    {
        $this->post('/api/auth/login', [
            "email" => "andjjaddwwdw"
        ])->assertStatus(422);
        $this->post('/api/auth/login', [
            "email" => "andrian@gmail.com",
        ])->assertStatus(422);
        $this->post('/api/auth/login', [
            "email" => fake()->email(),
            "password" => "qwerty123"
        ])->assertStatus(401);
    }

    // public function testUserProfile()
    // {
    //     $this->get('/api/auth/user-profile', [
    //         "Authorization" => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE2ODEzMDQzNjgsImV4cCI6MTY4MTMwNzk2OCwibmJmIjoxNjgxMzA0MzY4LCJqdGkiOiJyVmhWMGJEUk9ublltczl3Iiwic3ViIjoiMTEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.TZJk-jat8Z-a_zJgQtS4XYp3MpIgU9TG64yzFRXvpMA"
    //     ])->assertSeeText("Andrian")->assertJsonStructure([
    //         "id", "name", "email", "role"
    //     ]);
    // }
}
