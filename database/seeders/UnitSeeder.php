<?php

namespace Database\Seeders;

use App\Models\UnitGroup;
use App\Models\User;
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
            $users = User::inRandomOrder()->take(2)->get();
            $users->map(function($user){
                return $user->uuid;
            })->toArray();
            \App\Models\Unit::factory()
                ->hasMeta()
                ->hasAssets(2)
                ->belongsToGroup()
                ->create()
                ->users()
                ->attach($users);
            //->belongsToGroup($groups->random()->uuid)
        }

        //Units without a group
        for ($i = 1; $i <= 8; $i++) {
            $users = User::inRandomOrder()->take(2)->get();
            $users->map(function($user){
                return $user->uuid;
            })->toArray();
            \App\Models\Unit::factory()
                ->hasMeta()
                ->hasAssets(2)
                ->create()
                ->users()
                ->attach($users);
        }
    }
}
