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
        Education::create([
            'degree' => 'Bachelor of Science',
            'institution' => 'XYZ University',
            'field_of_study' => 'Computer Science',
            'start_date' => '2018-08-01',
            'end_date' => '2022-06-30',
            'currently_studying' => false,
            'grade' => 3.8,
            'description' => 'Completed with honors',
            'user_id' => User::where('role', 'ADMIN')->value('id'),
        ]);
    }
}
