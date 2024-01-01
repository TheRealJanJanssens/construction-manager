<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
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

    public function belongsToProject($uuid = false) {
        if (!$uuid) {
            $project = Project::inRandomOrder()->first();
            $uuid = $project->uuid;
        }

        return $this->state(function (array $attributes) use ($uuid) {
            return [
                'project_uuid' => $uuid,
            ];
        });
    }
}
