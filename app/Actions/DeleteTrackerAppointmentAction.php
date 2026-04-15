<?php

namespace App\Actions;

use App\Models\TrackerAppointment;

class DeleteTrackerAppointmentAction
{
    public function __invoke(TrackerAppointment $appointment): void
    {
        $appointment->delete();
    }
}
