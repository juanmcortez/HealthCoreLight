<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace Database\Factories\Users;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->userName(),
            'password' => static::$password ??= Hash::make('5uper4dm!nCar3vis3'),
            'is_active' => true,
            'profile_completed' => false,
            'last_login_at' => (fake()->boolean()) ? fake()->dateTimeBetween('-2 weeks', '-1 hour') : null,
            'created_at' => fake()->dateTimeBetween('-2 years', '-1 Month'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the user's profile is completed.
     */
    public function completed(): static
    {
        return $this->state(fn(array $attributes) => [
            'profile_completed' => true,
        ]);
    }

    /**
     * Indicate that the user is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }
}
