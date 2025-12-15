<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace App\Http\Requests\Profile;

use App\Enums\Gender;
use App\Enums\Ethnicity;
use Illuminate\Validation\Rule;
use App\Enums\PreferredLanguage;
use App\Enums\IdentificationType;
use Illuminate\Foundation\Http\FormRequest;

class UserProfileRequest extends FormRequest
{
    /**
     * Request rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
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
            //
            'email' => [
                'required',
                'email',
                'max:128',
                // Ignore soft-deleted emails in unique validation
                Rule::unique('emails', 'email')
                    ->whereNull('deleted_at')
                    ->ignore($this->user()?->demographics?->primary_email?->id),
            ],
        ];
    }

    /**
     * Custom error messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
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
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already in use.',
        ];
    }

    /**
     * Authorization
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
