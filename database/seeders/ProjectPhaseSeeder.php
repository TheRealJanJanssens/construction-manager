<?php

namespace Database\Seeders;

use App\Models\ProjectPhase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectPhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 90; $i++) {
            ProjectPhase::factory()->belongsToPhase()->belongsToProject()->create();
        }
    }
}
