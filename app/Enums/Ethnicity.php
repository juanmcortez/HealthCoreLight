<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace App\Enums;

enum Ethnicity: string
{
    case ASIAN = 'asian';
    case BLACK = 'black';
    case WHITE = 'white';
    case HISPANIC = 'hispanic';
    case MIDDLE_EASTERN = 'middle_eastern';
    case NATIVE_AMERICAN = 'native_american';
    case PACIFIC_ISLANDER = 'pacific_islander';
    case MIXED = 'mixed';
    case OTHER = 'other';
    case PREFER_NOT_TO_SAY = 'prefer_not_to_say';

    // Label for display
    public function label(): string
    {
        return match ($this) {
            self::ASIAN => 'Asian',
            self::BLACK => 'Black / African Descent',
            self::WHITE => 'White',
            self::HISPANIC => 'Hispanic / Latino',
            self::MIDDLE_EASTERN => 'Middle Eastern',
            self::NATIVE_AMERICAN => 'Native American / Indigenous',
            self::PACIFIC_ISLANDER => 'Pacific Islander',
            self::MIXED => 'Mixed / Multiple Ethnicities',
            self::OTHER => 'Other',
            self::PREFER_NOT_TO_SAY => 'Prefer not to say',
        };
    }

    // Options for select dropdown
    public static function options(): array
    {
        return [
            self::ASIAN->value => 'Asian',
            self::BLACK->value => 'Black / African Descent',
            self::WHITE->value => 'White',
            self::HISPANIC->value => 'Hispanic / Latino',
            self::MIDDLE_EASTERN->value => 'Middle Eastern',
            self::NATIVE_AMERICAN->value => 'Native American / Indigenous',
            self::PACIFIC_ISLANDER->value => 'Pacific Islander',
            self::MIXED->value => 'Mixed / Multiple Ethnicities',
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
