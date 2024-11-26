<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gtin>
 */
class GtinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'gtin' => fake()->numberBetween(10000000000000, 9999999999999),
            'price' => fake()->randomFloat(2, 10, 1000),
            'quantity' => fake()->randomNumber(1, 300),
        ];
    }
}
