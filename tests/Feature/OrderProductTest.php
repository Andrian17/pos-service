<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderProductTest extends TestCase
{
    protected $token = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE2ODIxMzkzNDksImV4cCI6MTY4MjIyNTc0OSwibmJmIjoxNjgyMTM5MzQ5LCJqdGkiOiJXdjlZSG1FSm9maFQ2Ynh4Iiwic3ViIjoiOSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.4iyRTRDjLhcNbPUu6qN7VDbw8-Z2fekWMB9IWSJVHdI";
    public function testAllOrderProducts()
    {
        $res = $this->get('/api/order-product', ["Authorization" => $this->token]);
        $res->assertSee('success')->assertStatus(200)->assertJsonStructure(['message', 'data']);
    }

    public function testOrderProductsByID()
    {
        $res = $this->get('/api/order-product', ["Authorization" => $this->token]);
        $res->assertSee('success')->assertStatus(200);
    }
}
