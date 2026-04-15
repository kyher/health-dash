<?php

namespace App\Actions;

use App\Models\Tracker;
use App\Models\TrackerAppointment;

class CreateTrackerAppointmentAction
{
    public function __invoke(Tracker $tracker, string $appointmentAt): TrackerAppointment
    {
        return $tracker->appointments()->create([
            'appointment_at' => $appointmentAt,
        ]);
    }
}
