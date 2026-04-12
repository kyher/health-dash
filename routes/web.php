<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Tracker\DeleteTrackerController;
use App\Http\Controllers\Tracker\ShowTrackerController;
use App\Http\Controllers\Tracker\StoreTrackerController;
use App\Http\Controllers\Tracker\UpdateTrackerController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::get('/trackers/{tracker}', ShowTrackerController::class)->name('tracker.show');
    Route::post('/trackers', StoreTrackerController::class)->name('tracker.store');
    Route::put('/trackers/{tracker}', UpdateTrackerController::class)->name('tracker.update');
    Route::delete('/trackers/{tracker}', DeleteTrackerController::class)->name('tracker.destroy');
});

require __DIR__.'/settings.php';
