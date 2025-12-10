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
     * @throws \Throwable
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:128',
            'middle_name' => 'nullable|string|max:128',
            'last_name' => 'required|string|max:128',
            //
            'date_of_birth' => 'nullable|date|before_or_equal:today',
            'gender' => [Rule::enum(Gender::class), 'nullable'],
            //
            'identification_type' => [Rule::enum(IdentificationType::class), 'nullable'],
            'identification_number' => 'nullable|string|max:24',
            //
            'ethnicity' => [Rule::enum(Ethnicity::class), 'nullable'],
            'preferred_language' => [Rule::enum(PreferredLanguage::class), 'nullable'],
        ]);

        DB::transaction(static function () use ($request, $validated) {
            // Get the user to update
            $user = $request->user();
            // Update or create demographic information
            $demographic = $user->demographics;
            // Proceed
            if ($demographic) {
                $demographic->update($validated);
            } else {
                $user->demographics()->create($validated);
            }
            // Mark profile as completed
            $user->update(['profile_completed' => true]);
        });

        return redirect()
            ->route('dashboard')
            ->with('success', 'Profile completed successfully!');
    }
}
