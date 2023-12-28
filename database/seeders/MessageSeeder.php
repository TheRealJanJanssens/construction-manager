<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 100; $i++) {
            $conversation = Conversation::inRandomOrder()->first();
            $user = $conversation->users()->inRandomOrder()->first();

            Message::factory()->create([
                'conversation_uuid' => $conversation->uuid,
                'user_uuid' => $user->uuid
            ]);
        }
    }
}
