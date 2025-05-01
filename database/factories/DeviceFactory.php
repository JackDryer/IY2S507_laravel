<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Cpu;
use App\Models\product_type;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name"=> fake()->regexify("[A-Z]{1,4}[0-4]{1,3}"),
            "ram_bytes" => fake()->numberBetween(2,16)*1000*1000*1000,
            "storage_bytes" => fake()->numberBetween(16,256)*1000*1000*1000,
            "cpu_id" => Cpu::inRandomOrder()->first()->id,
            "brand_id"=>Brand::inRandomOrder()->first()->id,
            "product_type_id" =>ProductType::inRandomOrder()->first()->id,
        ];
    }
}
