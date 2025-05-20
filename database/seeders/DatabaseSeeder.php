<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class]);
        User::factory(40)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 't@t.t',
            'password' =>'$2y$12$G4uFlODw2Z8hlP/diwVI5OUQjEcOsqxTkgBERKZ7qMDKz7vYPsS72',
            "employee_num"=> "0001",
            "first_name"=> "jack",
            "last_name"=> "dryer",
            "device_limit"=> 3,
            "department_id"=> 1,
            "status"=> "active",
            "is_admin"=> 1,

        ]);
        $this->call([
            ColourSeeder::class,
            BrandSeeder::class,
            CpuSeeder::class,
            ProductTypeSeeder::class,
            DeviceSeeder::class,
            AssetSeeder::class,
            AssetRequestSeeder::class,
            RssFeedSeeder::class,
        ]);
    }
}
