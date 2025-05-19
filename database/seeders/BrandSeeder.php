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
            'name' => 'Apple'
        ]);
        Brand::factory()->create([
            'name' => 'Microsoft'
        ]);
        Brand::factory()->create([
            'name' => 'Intel'
        ]);
        Brand::factory()->create([
            'name' => 'AMD'
        ]);
    }
}
