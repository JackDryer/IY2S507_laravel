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
        ProductType::factory()->create(["type"=>"Desktop"]);
        ProductType::factory()->create(["type"=>"Laptop"]);
        ProductType::factory()->create(["type"=>"tablet"]);
        ProductType::factory()->create(["type"=>"Mobile Phone"]);

    }
}
