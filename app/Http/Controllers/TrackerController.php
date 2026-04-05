<?php

namespace App\Http\Controllers;

use App\Actions\CreateTrackerAction;
use App\Http\Requests\StoreTrackerRequest;
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
}
