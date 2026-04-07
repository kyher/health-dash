<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrackerController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::post('/trackers', [TrackerController::class, 'store'])->name('tracker.store');
    Route::delete('/trackers/{tracker}', [TrackerController::class, 'destroy'])->name('tracker.destroy');
});

require __DIR__ . '/settings.php';
