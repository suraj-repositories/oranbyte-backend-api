<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //
        $userId = DB::table('users')->value('id');


        DB::table('user_details')->insert([
            'user_id'       => $userId,
            'first_name'    => Str::random(6),
            'last_name'     => Str::random(8),
            'phone'         => '98' . rand(10000000, 99999999),
            'address'       => 'Street ' . rand(1, 100) . ', City, Country',
            'dob'           => now()->subYears(rand(18, 50))->toDateString(),
            'gender'        => ['Male', 'Female', 'Other'][rand(0, 2)],
            'bio'           => Str::random(50),
            'profile_image' => 'profile_' . $userId . '.jpg',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        $this->command->info('User details seeded successfully!');
    }
}
