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
        return [
            "user_id" => fake()->numberBetween(1, 10),
            "payment_type_id" => 1,
            "name" => fake()->words(2, true),
            "total_price" => fake()->numberBetween(10000, 10000000),
            "total_paid" => fake()->numberBetween(10000, 1000000),
            "receipt_code" => "code",
        ];
    }
}
