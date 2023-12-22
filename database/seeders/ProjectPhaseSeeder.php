<?php

namespace Database\Seeders;

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
            \App\Models\ProjectPhase::factory()->belongsToPhase()->belongsToProject()->create();
        }
    }
}
