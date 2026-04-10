<?php

namespace App\Actions;

use App\Models\TrackerCategory;
use App\Models\User;

class CreateTrackerAction
{
    public function __invoke(User $user, TrackerCategory $category, string $name, ?string $nextAppointmentAt = null)
    {
        $tracker = $user->trackers()->create([
            'name' => $name,
            'category_id' => $category->id,
            'next_appointment_at' => $nextAppointmentAt,
        ]);

        return $tracker;
    }
}
