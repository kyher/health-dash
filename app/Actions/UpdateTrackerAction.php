<?php

namespace App\Actions;

use App\Models\Tracker;
use App\Models\TrackerCategory;

class UpdateTrackerAction
{
    public function __invoke(Tracker $tracker, TrackerCategory $category, string $name, ?string $nextAppointmentAt = null)
    {
        $tracker->update([
            'name' => $name,
            'category_id' => $category->id,
            'next_appointment_at' => $nextAppointmentAt,
        ]);

        return $tracker;
    }
}
