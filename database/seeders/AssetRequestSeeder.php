<?php

namespace Database\Seeders;

use App\Models\AssetRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AssetRequest::factory()->count(40)->create();
    }
}
