<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace App\Enums;

enum Gender: string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case OTHER = 'other';
    case PREFER_NOT_TO_SAY = 'prefer_not_to_say';

    // Label for display
    public function label(): string
    {
        return match ($this) {
            self::MALE => 'Male',
            self::FEMALE => 'Female',
            self::OTHER => 'Other',
            self::PREFER_NOT_TO_SAY => 'Prefer not to say',
        };
    }

    // Options for select dropdown
    public static function options(): array
    {
        return [
            self::MALE->value => 'Male',
            self::FEMALE->value => 'Female',
            self::OTHER->value => 'Other',
            self::PREFER_NOT_TO_SAY->value => 'Prefer not to say',
        ];
    }

    // Get all values as array
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
