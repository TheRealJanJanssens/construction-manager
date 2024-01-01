<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comments>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "content" => fake()->text(rand(50,250))
        ];
    }

    public function belongsToUser($uuid = false) {
        if (!$uuid) {
            $user = User::inRandomOrder()->first();
            $uuid = $user->uuid;
        }

        return $this->state(function (array $attributes) use ($uuid) {
            return [
                'user_uuid' => $uuid,
            ];
        });
    }

    public function belongsToPost($uuid = false) {
        if (!$uuid) {
            $post = Post::inRandomOrder()->first();
            $uuid = $post->uuid;
        }

        return $this->state(function (array $attributes) use ($uuid) {
            return [
                'post_uuid' => $uuid,
            ];
        });
    }
}
