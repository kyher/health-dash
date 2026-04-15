<?php

namespace App\Http\Controllers\Tracker;

use App\Actions\UpdateTrackerAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTrackerRequest;
use App\Models\Tracker;
use App\Models\TrackerCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UpdateTrackerController extends Controller
{
    public function __invoke(UpdateTrackerRequest $request, Tracker $tracker, UpdateTrackerAction $updateTrackerAction)
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(403);
        }

        if ($tracker->user_id !== $user->id) {
            abort(403);
        }

        $category = TrackerCategory::findOrFail($request->category);

        $updateTrackerAction($tracker, $category, $request->name);

        inertia()->flash([
            'toast' => [
                'type' => 'success',
                'message' => 'Tracker updated successfully!',
            ],
        ]);

        return redirect()->back();
    }
}
