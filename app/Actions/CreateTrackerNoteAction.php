<?php

namespace App\Actions;

use App\Models\Tracker;
use App\Models\TrackerNote;

class CreateTrackerNoteAction
{
    public function __invoke(Tracker $tracker, string $content): TrackerNote
    {
        return $tracker->notes()->create([
            'content' => $content,
        ]);
    }
}
