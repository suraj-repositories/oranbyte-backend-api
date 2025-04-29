<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $skills = config('seeds.skills');
        foreach($skills as $skillname => $percenage){

            $technology = Technology::where('name', $skillname)->first();
            if(!$technology){
                $technology = new Technology();
                $technology->name = $skillname;
                $technology->save();
            }
            Skill::create([
                'technology_id' => $technology->id,
                'percentage' => $percenage
            ]);


        }

    }
}
