<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Payment::factory(5)->create();
        Product::factory(20)->create();
        Category::factory(5)->create();
        Order::factory(3)->create()->each(function ($order) {
            for ($i = 1; $i <= 2; $i++) {
                OrderProduct::create([
                    "order_uuid" => $order->uuid,
                    "product_id" => fake()->numberBetween(1, 20),
                    "qty" => fake()->numberBetween(1, 3),
                    "total_price" => fake()->numberBetween(10000, 10000000),
                ]);
            }
        });
    }
}
