<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Test',
            'surname' => 'User',
            'phone_number' => '0551234567',
            'email' => 'test@example.dz',
            'password' => bcrypt('password123'),
        ]);
    }
}
