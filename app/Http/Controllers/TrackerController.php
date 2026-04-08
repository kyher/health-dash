<?php

namespace App\Http\Controllers;

use App\Actions\CreateTrackerAction;
use App\Http\Requests\StoreTrackerRequest;
use App\Http\Requests\UpdateTrackerRequest;
use App\Models\Tracker;
use App\Models\TrackerCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TrackerController extends Controller
{
    public function store(StoreTrackerRequest $request, CreateTrackerAction $createTrackerAction)
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(403);
        }

        $category = TrackerCategory::findOrFail($request->category);

        $createTrackerAction($user, $category, $request->name);

        return redirect()->route('dashboard')->with('success', 'Tracker added successfully!');
    }

    public function update(UpdateTrackerRequest $request, Tracker $tracker)
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(403);
        }

        if ($tracker->user_id !== $user->id) {
            abort(403);
        }

        $category = TrackerCategory::findOrFail($request->category);

        $tracker->update([
            'name' => $request->name,
            'category_id' => $category->id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Tracker updated successfully!');
    }

    public function destroy(Tracker $tracker)
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(403);
        }

        if ($tracker->user_id !== $user->id) {
            abort(403);
        }

        $tracker->delete();

        return redirect()->route('dashboard')->with('success', 'Tracker deleted successfully!');
    }
}
