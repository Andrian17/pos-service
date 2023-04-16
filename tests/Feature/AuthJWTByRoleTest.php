<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthJWTByRoleTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testWithoutToken()
    {
        $res = $this->get('/api/products');
        $res->assertRedirect('/api/get-login')->assertStatus(302);
    }

    public function testInvalidToken()
    {
        $res = $this->get('/api/products', [
            "Authorization" => "Bearer xxx-invalid-token-xxx"
        ]);
        $res->assertRedirect('/api/get-login')->assertStatus(302);
    }

    public function testValidTokenButNotAdmin()
    {
        $res = $this->get('/api/orders', [
            "Authorization" => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE2ODE2NTIxODgsImV4cCI6MTY4MTY1NTc4OCwibmJmIjoxNjgxNjUyMTg4LCJqdGkiOiJLRjhrcWl1MDJ3TWhQVUs2Iiwic3ViIjoiMTEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.QYYzI7UU5cBm349r0JntJziG7ab-jG9E1nlukyTfFx0",
        ]);
        $res->assertStatus(302);
    }

    public function testValidTokenAndIsAdmin()
    {
        $res = $this->get('/api/products', [
            "Authorization" => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE2ODE2NTcxMzQsImV4cCI6MTY4MTY2MDczNCwibmJmIjoxNjgxNjU3MTM0LCJqdGkiOiJ2Qm5NaXdlMmtuVDdPVzhuIiwic3ViIjoiMTIiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.bErg9C6_k1WJ1Wjeg_HXl8Vu6TnRX2qJHFgNBxwBYZs",
        ])->assertSee("");
        // $res->assertSee("List Order")->assertStatus(200);
    }
}
