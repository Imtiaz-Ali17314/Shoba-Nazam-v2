<?php

namespace Database\Factories;

use App\Models\IncidentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<IncidentType>
 */
class IncidentTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'madrasa_id' => \App\Models\Madrasa::factory(),
            'name' => fake()->word(),
        ];
    }
}
