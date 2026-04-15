<?php

namespace Database\Factories;

use App\Models\Tracker;
use App\Models\TrackerAppointment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TrackerAppointment>
 */
class TrackerAppointmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tracker_id' => Tracker::factory(),
            'appointment_at' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
