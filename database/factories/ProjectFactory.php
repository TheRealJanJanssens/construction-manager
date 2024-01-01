<?php

namespace Database\Factories;

use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
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
            'start_date' => Carbon::now()->toDateTimeString(),
            'due_date' => Carbon::now()->addMonths(8)->toDateTimeString(),
            'completed_date' => null,
        ];
    }

    public function belongsToUnit($uuid = false) {
        if (!$uuid) {
            $unit = Unit::inRandomOrder()->first();
            $uuid = $unit->uuid;
        }

        return $this->state(function (array $attributes) use ($uuid) {
            return [
                'unit_uuid' => $uuid,
            ];
        });
    }
}
