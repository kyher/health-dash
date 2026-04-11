<?php

namespace App\Http\Controllers\Tracker;

use App\Actions\DeleteTrackerAction;
use App\Http\Controllers\Controller;
use App\Models\Tracker;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DeleteTrackerController extends Controller
{
    public function __invoke(Tracker $tracker, DeleteTrackerAction $deleteTrackerAction)
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(403);
        }

        if ($tracker->user_id !== $user->id) {
            abort(403);
        }

        $deleteTrackerAction($tracker);

        inertia()->flash([
            'toast' => [
                'type' => 'success',
                'message' => 'Tracker deleted successfully!',
            ],
        ]);

        return redirect()->route('dashboard');
    }
}
