<?php

namespace App\Actions\Fortify;

use App\Enums\EmailType;
use App\Models\Users\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Demographics\Email;
use Illuminate\Support\Facades\Hash;
use App\Models\Demographics\Demographic;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Validate registration form data
        Validator::make($input, [
            'username' => [
                'required',
                'string',
                'min:5',
                'max:64',
                'alpha_dash',
                Rule::unique(User::class, 'username')
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:128',
                Rule::unique(Email::class, 'email'),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        // Store the user
        $user = User::create([
            'username' => Str::lower(Str::trim($input['username'])),
            'password' => Hash::make($input['password']),
            'demographic_id' => Demographic::factory()->create()->id,
        ]);

        // Store the email
        $user->demographics->emails()->create([
            'email_type' => EmailType::PRIMARY->value,
            'email' => Str::lower(Str::trim($input['email'])),
        ]);

        // Return the registered user
        return $user;
    }
}
