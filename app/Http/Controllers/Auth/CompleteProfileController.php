<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\CompleteProfileRequest;

class CompleteProfileController extends Controller
{
    /**
     * Store the completed profile information.
     *
     * @param  CompleteProfileRequest  $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function store(CompleteProfileRequest $request): RedirectResponse
    {
        // Validate the incoming request
        $validated = $request->validated();

        try {
            DB::transaction(static function () use ($request, $validated) {
                // Get the authenticated user
                $user = $request->user();

                // Update or create demographic information
                $demographic = $user->demographics;

                if ($demographic && $demographic->exists) {
                    // Update existing demographic record
                    $demographic->update($validated);
                } else {
                    // Create new demographic record and link to user
                    $newDemographic = $user->demographics()->create($validated);
                    $user->update(['demographic_id' => $newDemographic->id]);
                }

                // Mark profile as completed
                $user->update(['profile_completed' => true]);
            });

            return redirect()
                ->route('dashboard')
                ->with('success', 'Profile completed successfully! Welcome to HealthCore Light.');

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Profile completion failed', [
                'user_id' => $request->user()->uid,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'An error occurred while completing your profile. Please try again.');
        }
    }
}
