<?php

namespace Database\Factories;

use App\Models\Gtin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'gtin_id' => Gtin::factory(),
            'url' => fake()->imageUrl(),
            'cover' => fake()->boolean(),
        ];
    }
}
