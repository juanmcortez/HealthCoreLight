<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class DeleteProfileRequest extends FormRequest
{
    /**
     * Request rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'password' => 'required|current_password:web',
            'confirm_deletion' => 'required|accepted',
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
            'password.current_password' => 'The provided password is incorrect.',
            'confirm_deletion.accepted' => 'You must confirm account deletion.',
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
