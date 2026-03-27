<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        // Create 5 Madrasas
        $madrasas = \App\Models\Madrasa::factory(5)->create();

        // Create standard incident types
        $defaultTypes = ['Late Arrival', 'Absent', 'Discipline Conflict', 'Homework Missing', 'Excellent Performance'];

        foreach ($madrasas as $madrasa) {
            // Create incident types for each madrasa
            $incidentTypes = [];
            foreach ($defaultTypes as $type) {
                $incidentTypes[] = \App\Models\IncidentType::factory()->create([
                    'madrasa_id' => $madrasa->id,
                    'name' => $type
                ]);
            }

            // Create admin user for the madrasa
            \App\Models\User::factory()->create([
                'name' => 'Admin ' . $madrasa->id,
                'email' => "admin{$madrasa->id}@madrasa.com",
                'madrasa_id' => $madrasa->id,
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'is_active' => true,
            ])->assignRole('admin');

            // Create other users
            $users = \App\Models\User::factory(5)->create([
                'madrasa_id' => $madrasa->id
            ]);
            foreach ($users as $user) {
                $user->assignRole('nazim');
            }

            // Creating 200 students per madrasa
            $students = \App\Models\Student::factory(200)->create([
                'madrasa_id' => $madrasa->id
            ]);

            // Add records randomly
            foreach ($students as $student) {
                if (rand(1, 100) > 50) { // 50% hit rate of having records
                    for ($i = 0; $i < rand(1, 4); $i++) {
                        \App\Models\DisciplineRecord::factory()->create([
                            'madrasa_id' => $madrasa->id,
                            'student_id' => $student->id,
                            'incident_type_id' => $incidentTypes[array_rand($incidentTypes)]->id,
                        ]);
                    }
                }
            }
        }
    }
}
