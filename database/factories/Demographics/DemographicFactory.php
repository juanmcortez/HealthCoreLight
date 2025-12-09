<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace Database\Factories\Demographics;

use App\Enums\Gender;
use App\Enums\Ethnicity;
use Illuminate\Support\Str;
use App\Enums\PreferredLanguage;
use App\Enums\IdentificationType;
use App\Models\Demographics\Demographic;
use Illuminate\Database\Eloquent\Factories\Factory;

class DemographicFactory extends Factory
{
    protected $model = Demographic::class;

    public function definition(): array
    {
        $gender = fake()->randomElement([Gender::MALE->value, Gender::FEMALE->value]);
        return [
            'first_name' => Str::before(fake()->firstName($gender), ' '),
            'middle_name' => (fake()->boolean) ? Str::before(fake()->firstName($gender), ' ') : null,
            'last_name' => fake()->lastName(),
            //
            'date_of_birth' => fake()->dateTimeBetween('-80 years', '-6weeks')->format('Y-m-d'),
            'gender' => fake()->randomElement(Gender::cases()),
            //
            'identification_number' => fake()->randomNumber(9, true),
            'identification_type' => fake()->randomElement(IdentificationType::cases()),
            //
            'ethnicity' => fake()->randomElement(Ethnicity::cases()),
            'preferred_language' => fake()->randomElement(PreferredLanguage::cases()),
        ];
    }
}
