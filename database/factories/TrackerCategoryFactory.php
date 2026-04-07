<?php

namespace Database\Factories;

use App\Models\TrackerCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TrackerCategory>
 */
class TrackerCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
