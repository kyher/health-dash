<?php

namespace App\Actions;

use App\Models\TrackerCategory;
use App\Models\User;

class CreateTrackerAction
{
    public function __invoke(User $user, TrackerCategory $category, string $name)
    {
        $tracker = $user->trackers()->create([
            'name' => $name,
            'category_id' => $category->id,
        ]);

        return $tracker;
    }
}
