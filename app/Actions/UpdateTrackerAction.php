<?php

namespace App\Actions;

use App\Models\Tracker;
use App\Models\TrackerCategory;

class UpdateTrackerAction
{
    public function __invoke(Tracker $tracker, TrackerCategory $category, string $name)
    {
        $tracker->update([
            'name' => $name,
            'category_id' => $category->id,
        ]);

        return $tracker;
    }
}
