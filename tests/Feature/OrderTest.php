<?php

namespace Tests\Feature;

use App\Http\Controllers\OrderController;
use App\Repositories\OrderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{

    public function testGetOrder()
    {
        $this->get('/api/orders')->assertJsonIsObject()->assertSeeText("uuid")->assertSee("order_products")->assertSee("List Order")->assertSee("payment")->collect();
    }

    public function testCreateOrder()
    {
        $payload = [
            "payment_type_id" => 1,
            "name" => "Ali",
            "total_paid" => 500000,
            "products" => [
                [
                    "product_id" => 1,
                    "qty" => 2
                ],
                [
                    "product_id" => 2,
                    "qty" => 1
                ]
            ]
        ];
        $this->post('/api/orders', $payload)->assertJsonStructure([
            "message",
            "order_uuid",
            "purchased_items",
            "total_price",
            "total_paid",
            "return"
        ])->assertSee("success");
    }

    public function testOrderStockUnavailable()
    {
        $payload = [
            "payment_type_id" => 1,
            "name" => "Ali",
            "total_paid" => 500000,
            "products" => [
                [
                    "product_id" => 1,
                    "qty" => 20000
                ],
                [
                    "product_id" => 2,
                    "qty" => 1300000
                ]
            ]
        ];
        $this->post('/api/orders', $payload)->assertJsonStructure([
            "message", "data" => ["stock", "request_stock", "less"],
        ])->assertSee("Stock unavailable");
    }

    public function testOrderLessPaid()
    {
        $payload = [
            "payment_type_id" => 1,
            "name" => "Ali",
            "total_paid" => 1000,
            "products" => [
                [
                    "product_id" => 1,
                    "qty" => 1
                ],
                [
                    "product_id" => 2,
                    "qty" => 1
                ]
            ]
        ];
        $this->post('/api/orders', $payload)->assertSee("Price greater than Paid!")->assertJsonStructure([
            "message", "data" => ["total_price", "total_paid", "less"]
        ]);
    }
}
