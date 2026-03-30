<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
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
            'sname' => fake()->firstNameMale(),
            'fathername' => fake()->firstNameMale(),
            'code' => 'STD-' . fake()->unique()->numerify('#####'),
            'class' => fake()->randomElement(['Hifz', 'Darja Awal', 'Darja Duam', 'Darja Saum', 'Darja Rabia']),
        ];
    }
}
