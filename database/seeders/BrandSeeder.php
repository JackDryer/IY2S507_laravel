<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::factory()->create([
            'brand' => 'Apple'
        ]);
        Brand::factory()->create([
            'brand' => 'Microsoft'
        ]);
        Brand::factory()->create([
            'brand' => 'Intel'
        ]);
        Brand::factory()->create([
            'brand' => 'AMD'
        ]);
    }
}
