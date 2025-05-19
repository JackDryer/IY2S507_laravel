<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::factory()->create([
            'name' => 'IT'
        ]);
        Department::factory()->create([
            'name' => 'HR'
        ]);
        Department::factory()->create([
            'name' => 'R&D'
        ]);
    }
}
