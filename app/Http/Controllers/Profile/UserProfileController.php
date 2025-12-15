<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace App\Http\Controllers\Profile;

use App\Enums\EmailType;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Profile\UserProfileRequest;
use App\Http\Requests\Profile\DeleteProfileRequest;

class UserProfileController extends Controller
{
    /**
     * Show the profile edit form.
     */
    public function edit(): View
    {
        $user = auth()->user();

        return view('pages.profile.edit', [
            'user' => $user,
            'demographics' => $user->demographics,
            'emails' => $user->demographics->emails,
            'primaryEmail' => $user->demographics->primary_email,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(UserProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        try {
            DB::transaction(static function () use ($user, $validated, $request) {
                // Get current primary email
                $currentPrimaryEmail = $user->demographics->primary_email;
                $newEmail = $validated['email'];

                // Remove email from validated data (handled separately)
                unset($validated['email']);

                // Update demographic information
                $user->demographics->update($validated);

                // Handle email change if different
                if ($currentPrimaryEmail && $newEmail !== $currentPrimaryEmail->email) {
                    // Create new email record (unverified)
                    $newEmailRecord = $user->demographics->emails()->create([
                        'email_type' => EmailType::PRIMARY->value,
                        'email' => $newEmail,
                        'is_primary' => false, // Will become primary after verification
                        'is_verified' => false,
                    ]);

                    // Send verification notification
                    $user->sendEmailVerificationNotification();

                    // Flash message about verification
                    session()->flash('warning',
                        'A verification email has been sent to '.$newEmail.'. Please verify your new email address. Your current email will remain active until verification is complete.');
                } elseif (!$currentPrimaryEmail && $newEmail) {
                    // No primary email exists, create one
                    $user->demographics->emails()->create([
                        'email_type' => EmailType::PRIMARY->value,
                        'email' => $newEmail,
                        'is_primary' => true,
                        'is_verified' => false,
                    ]);

                    // Send verification notification
                    $user->sendEmailVerificationNotification();

                    session()->flash('warning', 'A verification email has been sent to '.$newEmail.'. Please verify your email address.');
                }
            });

            // Success message if no email change
            if (!session()->has('warning')) {
                return redirect()
                    ->route('profile.edit')
                    ->with('success', 'Profile updated successfully!');
            }

            return redirect()->route('profile.edit');

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Profile update failed', [
                'user_id' => $user->uid,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'An error occurred while updating your profile. Please try again.');
        }
    }

    /**
     * Open the screen to edit the user password
     *
     * @return View
     */
    public function passwordEdit(): View
    {
        return view('pages.profile.password');
    }

    /**
     * Open the screen to delete the user account
     *
     * @return View
     */
    public function accountDelete(): View
    {
        return view('pages.profile.delete');
    }

    /**
     * Soft delete the user's account.
     *
     * @param  DeleteProfileRequest  $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function destroy(DeleteProfileRequest $request): RedirectResponse
    {
        $user = $request->user();

        try {
            DB::transaction(static function () use ($user) {
                // Soft delete all user emails
                $user->demographics->emails()->delete();

                // Soft delete demographics
                $user->demographics->delete();

                // Soft delete user
                $user->delete();
            });

            // Logout the user
            auth()->logout();

            // Invalidate session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with('success', 'Your account has been deleted successfully.');

        } catch (\Exception $e) {
            // Log the error
            \Log::error('Account deletion failed', [
                'user_id' => $user->uid,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', 'An error occurred while deleting your account. Please try again.');
        }
    }
}
