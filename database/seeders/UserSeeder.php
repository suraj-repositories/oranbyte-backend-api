<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ADMIN
        User::firstOrCreate([
            'name' => 'Shubham kumar',
            'email' => 'suraj2002fake@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'ADMIN',
        ]);

        // USER
        User::firstOrCreate([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'USER',
        ]);
    }
}
