<?php

namespace Database\Factories;

use App\Models\RssFeed;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RssFeedItem>
 */
class RssFeedItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'link' => $this->faker->url(),
            'description' => $this->faker->paragraph(),
            'pub_date' => $this->faker->dateTime(),
            'feed_source_id' => RssFeed::inRandomOrder()->first()->id,
        ];
    }
}
