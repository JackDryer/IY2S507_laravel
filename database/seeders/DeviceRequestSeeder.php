<?php

namespace Database\Seeders;

use App\Models\DeviceRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeviceRequest::factory()->count(40)->create();
    }
}
