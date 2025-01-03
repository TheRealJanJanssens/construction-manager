<?php

namespace Database\Seeders;

use App\Models\Project;
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
            Project::factory()->hasAssets(4)->create([
                'unit_uuid' => $unit->uuid
            ]);
        }
    }
}
