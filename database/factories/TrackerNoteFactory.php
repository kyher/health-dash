<?php

namespace Database\Factories;

use App\Models\Tracker;
use App\Models\TrackerNote;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TrackerNote>
 */
class TrackerNoteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tracker_id' => Tracker::factory(),
            'content' => $this->faker->sentence(),
        ];
    }
}
