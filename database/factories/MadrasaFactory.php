<?php

namespace Database\Factories;

use App\Models\Madrasa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Madrasa>
 */
class MadrasaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Islamic Institute',
            'address' => fake()->address(),
            'email' => fake()->unique()->companyEmail(),
            'phone' => fake()->phoneNumber(),
            'academic_year' => '2025-2026',
        ];
    }
}
