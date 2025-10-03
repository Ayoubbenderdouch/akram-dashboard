<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User für Dashboard (nur erstellen wenn nicht existiert)
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@akram.dz'],
            [
                'name' => 'Admin',
                'surname' => 'Akram',
                'phone_number' => '0550000000',
                'password' => bcrypt('Admin@2025'),
            ]
        );

        // Test User für API (nur erstellen wenn nicht existiert)
        \App\Models\User::firstOrCreate(
            ['email' => 'test@example.dz'],
            [
                'name' => 'Test',
                'surname' => 'User',
                'phone_number' => '0551234567',
                'password' => bcrypt('password123'),
            ]
        );
    }
}
