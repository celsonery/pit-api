<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cep' => fake()->numberBetween(10000000, 99999999),
            'address' => fake()->streetName(),
            'number' => fake()->numberBetween(100, 999),
            'complement' => fake()->sentence(),
            'neighborhood' => fake()->word(),
            'province' => fake()->word(),
            'reference' => fake()->sentence(),
            'main' => fake()->boolean,
            'nickname' => fake()->name(),
        ];
    }
}
