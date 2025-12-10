<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboards\DashboardController;
use App\Http\Controllers\Auth\CompleteProfileController;

// Profile completion routes (accessible without profile completion)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/complete-profile', static function () {
        // Redirect if already completed
        if (auth()->user()->profile_completed) {
            return redirect()->route('dashboard');
        }
        return view('auth.complete-profile');
    })->name('profile.complete');

    Route::post('/complete-profile', [CompleteProfileController::class, 'store'])
        ->name('profile.store');
});


// All the following routes require registration and login
Route::middleware(['auth', 'verified', 'profile.completed'])->group(function () {
    // ---------------
    // Default landing
    Route::get('/', DashboardController::class)
        ->name('dashboard');
    // ---------------
});

