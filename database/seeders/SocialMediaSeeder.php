<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('social_media')->delete();

        $socialMedia = [
            ['name' => 'github', 'uri' => 'https://github.com/ProjectsAndPrograms', 'icon' => 'ri:github-fill', 'color' => '#333', 'bg_color' => '#ffffff'],
            ['name' => 'facebook', 'uri' => 'https://facebook.com/', 'icon' => 'mdi:facebook', 'color' => '#1877F2', 'bg_color' => '#ffffff'],
            ['name' => 'twitter', 'uri' => 'https://twitter.com/', 'icon' => 'ri:twitter-fill', 'color' => '#1DA1F2', 'bg_color' => '#ffffff'],
            ['name' => 'instagram', 'uri' => 'https://instagram.com/', 'icon' => 'basil:instagram-solid', 'color' => '#E4405F', 'bg_color' => '#ffffff'],
            ['name' => 'linkedin', 'uri' => 'https://www.linkedin.com/in/shubham-kumar-277bba278', 'icon' => 'uil:linkedin', 'color' => '#0077B5', 'bg_color' => '#ffffff'],
            ['name' => 'youtube', 'uri' => 'https://youtube.com/', 'icon' => 'ri:youtube-fill', 'color' => '#FF0000', 'bg_color' => '#ffffff'],
        ];

        DB::table('social_media')->insert($socialMedia);

    }
}
