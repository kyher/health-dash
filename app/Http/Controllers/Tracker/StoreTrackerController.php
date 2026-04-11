<?php

namespace App\Http\Controllers\Tracker;

use App\Actions\CreateTrackerAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTrackerRequest;
use App\Models\TrackerCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StoreTrackerController extends Controller
{
    public function __invoke(StoreTrackerRequest $request, CreateTrackerAction $createTrackerAction)
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(403);
        }

        $category = TrackerCategory::findOrFail($request->category);

        $createTrackerAction($user, $category, $request->name, $request->next_appointment_at);

        inertia()->flash([
            'toast' => [
                'type' => 'success',
                'message' => 'Tracker added successfully!',
            ],
        ]);

        return redirect()->route('dashboard');
    }
}
