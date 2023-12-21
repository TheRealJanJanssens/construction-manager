<?php

namespace Database\Seeders;

use App\Models\UnitGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Units within a group
        for ($i = 1; $i <= 6; $i++) {
            \App\Models\Unit::factory()->hasMeta()->belongsToGroup()->create();
            //->belongsToGroup($groups->random()->uuid)
        }

        //Units without a group
        \App\Models\Unit::factory(8)->hasMeta()->create();
    }
}
