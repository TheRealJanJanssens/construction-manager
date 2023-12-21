<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UnitMeta>
 */
class UnitMetaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->name(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'postal_code' => fake()->postcode(),
            'start_date' => Carbon::now()->toDateTimeString(),
            'due_date' => Carbon::now()->addMonths(8)->toDateTimeString(),
            'completed_date' => null,
            //'extra' => json
        ];
    }
}
