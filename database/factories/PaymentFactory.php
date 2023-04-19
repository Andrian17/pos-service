<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fake = fake()->image();
        $saveFile = Storage::putFile('/public/payments', $fake, 'public');
        $fileName = explode("/", $saveFile)[2];
        return [
            "name" => fake()->company(),
            "type" => fake()->word(),
            "logo" => $fileName
        ];
    }
}
