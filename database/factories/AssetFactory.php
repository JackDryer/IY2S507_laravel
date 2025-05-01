<?php

namespace Database\Factories;

use App\Models\Colour;
use App\Models\Device;
use App\Models\DeviceRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset>
 */
class AssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => fake()->unique()->firstName() . "'s device",
            'serial_number' =>fake()->regexify("[A-Z0-9]{24}"),
            'colour_id' =>Colour::inRandomOrder()->first()->id,
            'device_id' =>Device::inRandomOrder()->first()->id,
        ];
    }
}
