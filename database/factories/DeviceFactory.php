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
            "name"=> fake()->unique()->regexify("[A-Z]{1,4}[0-4]{1,3}"),
            "ram_bytes" => pow(2,fake()->numberBetween(1,6))*1073741824,
            "storage_bytes" => pow(2,fake()->numberBetween(3,1))*1073741824,
            "cpu_id" => Cpu::inRandomOrder()->first()->id,
            "brand_id"=>Brand::inRandomOrder()->first()->id,
            "product_type_id" =>ProductType::inRandomOrder()->first()->id,
        ];
    }
}
