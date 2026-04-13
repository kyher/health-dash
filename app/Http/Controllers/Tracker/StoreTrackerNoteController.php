<?php

namespace App\Http\Controllers\Tracker;

use App\Actions\CreateTrackerNoteAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTrackerNoteRequest;
use App\Models\Tracker;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StoreTrackerNoteController extends Controller
{
    public function __invoke(StoreTrackerNoteRequest $request, Tracker $tracker, CreateTrackerNoteAction $createTrackerNoteAction)
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(403);
        }

        if ($tracker->user_id !== $user->id) {
            abort(403);
        }

        $createTrackerNoteAction($tracker, $request->content);

        inertia()->flash([
            'toast' => [
                'type' => 'success',
                'message' => 'Note added successfully!',
            ],
        ]);

        return redirect()->route('tracker.show', $tracker);
    }
}
