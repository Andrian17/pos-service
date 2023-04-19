<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fake = fake()->image();
        $saveFile = Storage::putFile('/public/products', $fake, 'public');
        $fileName = explode("/", $saveFile)[2];
        return [
            "category_id" => fake()->numberBetween(1, 5),
            "SKU" => "sku-" . uniqid(),
            "name" => fake()->name(),
            "stock" => fake()->numberBetween(10, 20),
            "price" => fake()->numberBetween(10000, 100000),
            "image" => $fileName
        ];
    }
}
