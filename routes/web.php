<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboards\DashboardController;

// All the following routes require registration and login
Route::middleware(['auth', 'verified'])->group(function () {
    // ---------------
    // Default landing
    Route::get('/', DashboardController::class)
        ->name('dashboard');
    // ---------------
});

