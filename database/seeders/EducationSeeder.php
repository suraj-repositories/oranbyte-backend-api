<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Education::truncate();
        Education::create([
            'degree' => 'Polytechnic Diploma',
            'institution' => 'Government Polytechnic Kanpur',
            'field_of_study' => 'Information Technology',
            'start_date' => '2021-07-15',
            'end_date' => '2024-06-30',
            'currently_studying' => false,
            'grade' => 8.1,
            'description' => 'Completed Polytechnic Diploma program with honors, showcasing strong academic and technical skills.',
            'user_id' => User::where('role', 'ADMIN')->value('id'),
        ]);
        Education::create([
            'degree' => 'Bachelor of Technology',
            'institution' => 'Abdul Kalam Technical University',
            'field_of_study' => 'Computer Science',
            'start_date' => '2024-07-01',
            'end_date' => '2027-06-30',
            'currently_studying' => true,
            'grade' => 7.5,
            'description' => 'Currently pursuing this degree and working towards successful completion.',
            'user_id' => User::where('role', 'ADMIN')->value('id'),
        ]);
    }
}
