<?php

namespace Database\Seeders;

use App\Models\AppConfig;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class AppConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $config = config('seeds.app_configs');
        // DB::table('app_configs')->delete();
        foreach ($config as $key => $value) {
            AppConfig::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
