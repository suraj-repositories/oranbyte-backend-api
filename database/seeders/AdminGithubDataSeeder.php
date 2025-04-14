<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class AdminGithubDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        Artisan::call("app:load-project-command");
        Artisan::call("app:load-project-urls");
        Artisan::call("app:load-stargazer-users");
    }
}
