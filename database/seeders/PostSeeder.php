<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Posts without assets
        for ($i = 1; $i <= 20; $i++) {
            Post::factory()
                ->belongsToUser()
                ->belongsToProject()
                ->create();
        }

        //Posts with assets
        for ($i = 1; $i <= 20; $i++) {
            Post::factory()
                ->belongsToUser()
                ->belongsToProject()
                ->hasAssets(rand(1,2))
                ->create();
        }
    }
}
