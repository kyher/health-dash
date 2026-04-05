<?php

namespace App\Http\Controllers;

use App\Models\TrackerCategory;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return inertia('Dashboard', [
            'categories' => TrackerCategory::all(),
            'trackers' => Auth::user()->trackers->load('category'),
        ]);
    }
}
