<?php

namespace Database\Seeders;

use App\Models\ProfessionalExperience;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfessionalExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ProfessionalExperience::insert([
            [
                'job_title' => 'Software Engineer',
                'company' => 'Tech Solutions Inc.',
                'location' => 'New York, USA',
                'start_date' => '2020-05-01',
                'end_date' => null,
                'currently_working' => true,
                'description' => 'Developing web applications using Laravel and Vue.js.',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'job_title' => 'Backend Developer',
                'company' => 'Innovative Tech Ltd.',
                'location' => 'San Francisco, USA',
                'start_date' => '2018-03-15',
                'end_date' => '2020-04-30',
                'currently_working' => false,
                'description' => 'Built scalable APIs and optimized database queries.',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
