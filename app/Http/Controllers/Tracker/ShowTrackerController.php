<?php

namespace App\Http\Controllers\Tracker;

use App\Http\Controllers\Controller;
use App\Models\Tracker;
use App\Models\TrackerCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ShowTrackerController extends Controller
{
    public function __invoke(Tracker $tracker)
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(403);
        }

        if ($tracker->user_id !== $user->id) {
            abort(403);
        }

        return inertia('ShowTracker', [
            'tracker' => $tracker->load('category'),
            'categories' => TrackerCategory::all(),
        ]);
    }
}
