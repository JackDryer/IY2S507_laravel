<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductType::factory()->create(["name"=>"Desktop"]);
        ProductType::factory()->create(["name"=>"Laptop"]);
        ProductType::factory()->create(["name"=>"tablet"]);
        ProductType::factory()->create(["name"=>"Mobile Phone"]);

    }
}
