<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 8; $i++) {
            $unit = Unit::inRandomOrder()->first();
            \App\Models\Project::factory()->create([
                'unit_uuid' => $unit->uuid
            ]);
        }
    }
}
