<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace Database\Factories\Demographics;

use App\Enums\EmailType;
use App\Models\Demographics\Email;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailFactory extends Factory
{
    protected $model = Email::class;

    public function definition(): array
    {
        return [
            'email_type' => fake()->randomElement(EmailType::cases()),
            'email' => fake()->safeEmail(),
            'is_primary' => false,
            'is_verified' => fake()->boolean(65),
            'verified_at' => fake()->optional(0.65)->dateTimeBetween('-6 Months', '-1 hour'),
        ];
    }

    /**
     * Indicate that the email is primary.
     */
    public function primary(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_primary' => true,
            'email_type' => EmailType::PRIMARY->value,
        ]);
    }

    /**
     * Indicate that the email is verified.
     */
    public function verified(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_verified' => true,
            'verified_at' => now(),
        ]);
    }

    /**
     * Indicate that the email is unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_verified' => false,
            'verified_at' => null,
        ]);
    }
}
