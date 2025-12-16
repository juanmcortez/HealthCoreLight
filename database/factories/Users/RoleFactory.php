<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace Database\Factories\Users;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => fake()->word(),
            'name' => fake()->word(),
            'level' => fake()->randomElement([100, 80, 60, 50, 40, 30, 10]),
            'is_active' => true,
            'description' => fake()->words(),
        ];
    }
}
