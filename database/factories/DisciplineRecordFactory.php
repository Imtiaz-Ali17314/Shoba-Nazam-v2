<?php

namespace Database\Factories;

use App\Models\DisciplineRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DisciplineRecord>
 */
class DisciplineRecordFactory extends Factory
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
            'student_id' => \App\Models\Student::factory(),
            'incident_type_id' => \App\Models\IncidentType::factory(),
            'detail' => fake()->sentence(8),
            'date' => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
        ];
    }
}
