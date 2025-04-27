<?php

namespace Database\Seeders;

use App\Models\ExperienceTechnology;
use App\Models\ProfessionalExperience;
use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExperienceTechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $experiences = ProfessionalExperience::all();

        foreach($experiences as $experience){
            $technologies = Technology::inRandomOrder()->take(rand(3,6))->get();

            foreach($technologies as $technology){
                ExperienceTechnology::create([
                    'professional_experience_id' => $experience->id,
                    'technology_id' => $technology->id
                ]);
            }

        }

    }
}
