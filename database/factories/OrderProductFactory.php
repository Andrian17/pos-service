<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderProduct>
 */
class OrderProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "order_id" => fake()->numberBetween(1, 3),
            "product_id" => fake()->numberBetween(1, 20),
            "qty" => fake()->numberBetween(1, 3),
            "total_price" => fake()->numberBetween(10000, 10000000),
        ];
    }
}
