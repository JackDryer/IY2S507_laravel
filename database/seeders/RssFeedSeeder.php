<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RssFeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add your seeder logic here
        // For example, you can use the RssFeed model to create some initial data
        \App\Models\RssFeed::create([
            'name' => 'NCSC Feed',
            'url' => 'https://www.ncsc.gov.uk/api/1/services/v1/report-rss-feed.xml',
            'category' => 'Threat Intelligence',
        ]);
    }
}
