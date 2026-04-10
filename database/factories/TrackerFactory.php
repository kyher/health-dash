<?php

namespace Database\Factories;

use App\Models\Tracker;
use App\Models\TrackerCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tracker>
 */
class TrackerFactory extends Factory
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
            'category_id' => TrackerCategory::factory(),
            'user_id' => User::factory(),
            'next_appointment_at' => null,
        ];
    }
}
