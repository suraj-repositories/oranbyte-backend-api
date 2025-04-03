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
        $socialMedia = [
            ['name' => 'github', 'uri' => 'https://github.com/ProjectsAndPrograms', 'icon' => 'solar:github-outline', 'color' => '#333', 'bg_color' => '#ffffff'],
            ['name' => 'facebook', 'uri' => 'https://facebook.com/', 'icon' => 'solar:facebook-outline', 'color' => '#1877F2', 'bg_color' => '#ffffff'],
            ['name' => 'twitter', 'uri' => 'https://twitter.com/', 'icon' => 'solar:twitter-outline', 'color' => '#1DA1F2', 'bg_color' => '#ffffff'],
            ['name' => 'instagram', 'uri' => 'https://instagram.com/', 'icon' => 'solar:instagram-outline', 'color' => '#E4405F', 'bg_color' => '#ffffff'],
            ['name' => 'linkedin', 'uri' => 'https://linkedin.com/', 'icon' => 'solar:linkedin-outline', 'color' => '#0077B5', 'bg_color' => '#ffffff'],
            ['name' => 'youtube', 'uri' => 'https://youtube.com/', 'icon' => 'solar:youtube-outline', 'color' => '#FF0000', 'bg_color' => '#ffffff'],
        ];

        DB::table('social_media')->insert($socialMedia);

    }
}
