<?php

namespace Database\Factories;

use App\Models\Phase;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectPhase>
 */
class ProjectPhaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_date' => Carbon::now()->toDateTimeString(),
            'due_date' => Carbon::now()->addDays(rand(1,30))->addMonths(rand(1,4))->toDateTimeString(),
            'completed_date' => null,
        ];
    }

    public function belongsToProject($uuid = false) {
        if (!$uuid) {
            $group = Project::inRandomOrder()->first();
            $uuid = $group->uuid;
        }

        return $this->state(function (array $attributes) use ($uuid) {
            return [
                'project_uuid' => $uuid,
            ];
        });
    }

    public function belongsToPhase($uuid = false) {
        if (!$uuid) {
            $group = Phase::inRandomOrder()->first();
            $uuid = $group->uuid;
        }

        return $this->state(function (array $attributes) use ($uuid) {
            return [
                'phase_uuid' => $uuid,
            ];
        });
    }
}
