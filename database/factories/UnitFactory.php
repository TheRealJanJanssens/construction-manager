<?php

namespace Database\Factories;

use App\Models\UnitGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }

    public function belongsToGroup($uuid = false) {
        if (!$uuid) {
            $group = UnitGroup::inRandomOrder()->first();
            $uuid = $group->uuid;
        }

        return $this->state(function (array $attributes) use ($uuid) {
            return [
                'group_uuid' => $uuid,
            ];
        });
    }
}
