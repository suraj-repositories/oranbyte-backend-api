<?php

namespace Database\Seeders;

use App\Models\ProfessionalExperience;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionalExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('experience_technology')->truncate();
        DB::table('professional_experiences')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        ProfessionalExperience::insert([
            [
                'job_title' => 'Java Software Engineer',
                'company' => 'SV Infotech',
                'location' => 'Kanpur, India',
                'start_date' => '2023-08-01',
                'end_date' => "2024-06-01",
                'currently_working' => true,
                'description' => "Designed and maintained scalable, high-performance Java applications for multiple clients, ensuring clean architecture, code quality, and timely delivery.",
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'job_title' => 'Backend Developer',
                'company' => 'Smart Web Arts Pvt. Ltd.',
                'location' => 'Lucknow, India',
                'start_date' => '2024-06-15',
                'end_date' => null,
                'currently_working' => false,
                'description' => 'Worked on the development of a web-based application using PHP and Laravel, focusing on backend services and RESTful APIs.',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
