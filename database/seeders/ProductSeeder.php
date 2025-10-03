<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Product::create([
            'name' => 'Test Product',
            'bio' => 'This is a test product for demonstration purposes.',
            'price' => 1000.00,
            'min_quantity' => 10,
            'stock' => 0,
        ]);
    }
}
