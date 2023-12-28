<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $users = User::inRandomOrder()->take(2)->get()->map(function($user){
                return $user->uuid;
            })->toArray();

            $conversation = Conversation::factory()->create();
            $conversation->users()->sync($users);
        }
    }
}
