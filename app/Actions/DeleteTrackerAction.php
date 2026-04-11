<?php

namespace App\Actions;

use App\Models\Tracker;

class DeleteTrackerAction
{
    public function __invoke(Tracker $tracker)
    {
        $tracker->delete();
    }
}
