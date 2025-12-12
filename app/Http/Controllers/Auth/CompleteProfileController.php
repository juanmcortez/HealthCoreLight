<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace App\Http\Controllers\Auth;

use App\Enums\Gender;
use App\Enums\Ethnicity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\PreferredLanguage;
use App\Enums\IdentificationType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class CompleteProfileController extends Controller
{
    /**
     * Store the completed profile information.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request
        $validated = $request->validate([
            'first_name' => 'required|string|max:128',
            'middle_name' => 'nullable|string|max:128',
            'last_name' => 'required|string|max:128',
            //
            'date_of_birth' => 'required|date|before_or_equal:today',
            'gender' => ['required', Rule::enum(Gender::class)],
            //
            'identification_type' => ['nullable', Rule::enum(IdentificationType::class)],
            'identification_number' => 'required_with:identification_type|nullable|string|max:24',
            //
            'ethnicity' => ['nullable', Rule::enum(Ethnicity::class)],
            'preferred_language' => ['required', Rule::enum(PreferredLanguage::class)],
        ], [
            // Custom error messages
            'first_name.required' => 'Please enter your first name.',
            'last_name.required' => 'Please enter your last name.',
            'date_of_birth.required' => 'Please enter your date of birth.',
            'date_of_birth.before_or_equal' => 'Date of birth cannot be in the future.',
            'gender.required' => 'Please select your gender.',
            'gender.enum' => 'Please select a valid gender option.',
            'preferred_language.required' => 'Please select your preferred language.',
            'preferred_language.enum' => 'Please select a valid language option.',
            'identification_number.required_with' => 'Please enter your identification number when type is selected.',
            'identification_type.enum' => 'Please select a valid identification type.',
            'ethnicity.enum' => 'Please select a valid ethnicity option.',
        ]);

        try {
            DB::transaction(function () use ($request, $validated) {
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
