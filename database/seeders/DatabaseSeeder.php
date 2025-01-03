<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            PhaseSeeder::class,
            UnitGroupSeeder::class,
            UnitSeeder::class,
            ProjectSeeder::class,
            ProjectPhaseSeeder::class,
            ConversationSeeder::class,
            MessageSeeder::class,
            PostSeeder::class,
            CommentsSeeder::class
        ]);
    }
}
