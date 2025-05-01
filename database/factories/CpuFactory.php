<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brand;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cpu>
 */
class CpuFactory extends Factory
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
            "base_clock_speed_hz" => fake()->numberBetween(2,5)*1000*1000*1000,
            "cores" =>fake()->numberBetween(2,16),
            "brand_id"=>Brand::inRandomOrder()->first()->id
        ];
    }
}
