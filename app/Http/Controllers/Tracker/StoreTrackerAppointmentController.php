<?php

namespace App\Http\Controllers\Tracker;

use App\Actions\CreateTrackerAppointmentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTrackerAppointmentRequest;
use App\Models\Tracker;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StoreTrackerAppointmentController extends Controller
{
    public function __invoke(StoreTrackerAppointmentRequest $request, Tracker $tracker, CreateTrackerAppointmentAction $createTrackerAppointmentAction)
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(403);
        }

        if ($tracker->user_id !== $user->id) {
            abort(403);
        }

        $createTrackerAppointmentAction($tracker, $request->appointment_at);

        inertia()->flash([
            'toast' => [
                'type' => 'success',
                'message' => 'Appointment added successfully!',
            ],
        ]);

        return redirect()->route('tracker.show', $tracker);
    }
}
