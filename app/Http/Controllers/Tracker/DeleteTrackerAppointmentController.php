<?php

namespace App\Http\Controllers\Tracker;

use App\Actions\DeleteTrackerAppointmentAction;
use App\Http\Controllers\Controller;
use App\Models\Tracker;
use App\Models\TrackerAppointment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DeleteTrackerAppointmentController extends Controller
{
    public function __invoke(Tracker $tracker, TrackerAppointment $appointment, DeleteTrackerAppointmentAction $deleteTrackerAppointmentAction)
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(403);
        }

        if ($tracker->user_id !== $user->id) {
            abort(403);
        }

        if ($appointment->tracker_id !== $tracker->id) {
            abort(404);
        }

        $deleteTrackerAppointmentAction($appointment);

        inertia()->flash([
            'toast' => [
                'type' => 'success',
                'message' => 'Appointment removed successfully!',
            ],
        ]);

        return redirect()->route('tracker.show', $tracker);
    }
}
