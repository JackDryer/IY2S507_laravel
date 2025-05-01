<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Asset;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeviceRequest>
 */
class DeviceRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" => User::inRandomOrder()->first()->id,
            'asset_id' =>Asset::inRandomOrder()->first()->id,
            "status" => fake()->randomElement(["requested","approved","denied"])
        ];
    }
}
