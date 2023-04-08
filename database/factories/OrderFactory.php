<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $total_price = 22000;
        $total_paid = 50000;
        return [
            "uuid" => uniqid(),
            "user_id" => fake()->numberBetween(1, 10),
            "payment_type_id" => 1,
            "name" => fake()->words(2, true),
            "total_price" => $total_price,
            "total_paid" => $total_paid,
            "receipt_code" => "code",
            "return" => $total_paid - $total_price
        ];
    }
}
