<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace App\Enums;

enum EmailType: string
{
    case PRIMARY = 'primary';
    case SECONDARY = 'secondary';
    case WORK = 'work';
    case PERSONAL = 'personal';
    case OTHER = 'other';

    // Label for display
    public function label(): string
    {
        return match ($this) {
            self::PRIMARY => 'Primary',
            self::SECONDARY => 'Secondary',
            self::WORK => 'Work',
            self::PERSONAL => 'Personal',
            self::OTHER => 'Other',
        };
    }

    // Options for select dropdown
    public static function options(): array
    {
        return [
            self::PRIMARY->value => 'Primary',
            self::SECONDARY->value => 'Secondary',
            self::WORK->value => 'Work',
            self::PERSONAL->value => 'Personal',
            self::OTHER->value => 'Other',
        ];
    }

    // Get all values as array
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    // Get all cases except PRIMARY
    public static function nonPrimary(): array
    {
        return array_filter(self::cases(), static fn($case) => $case !== self::PRIMARY);
    }
}
