<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace App\Enums;

enum IdentificationType: string
{
    case SSN = 'ssn';
    case PASSPORT = 'passport';
    case DNI = 'dni';
    case DRIVER_LICENSE = 'driver_license';
    case NATIONAL_ID = 'national_id';
    case OTHER = 'other';

    // Label for display
    public function label(): string
    {
        return match ($this) {
            self::SSN => 'Social Security Number',
            self::PASSPORT => 'Passport',
            self::DNI => 'DNI (National Identity Document)',
            self::DRIVER_LICENSE => 'Driver’s License',
            self::NATIONAL_ID => 'National ID',
            self::OTHER => 'Other',
        };
    }

    // Options for select dropdown
    public static function options(): array
    {
        return [
            self::SSN->value => 'Social Security Number',
            self::PASSPORT->value => 'Passport',
            self::DNI->value => 'DNI (National Identity Document)',
            self::DRIVER_LICENSE->value => 'Driver’s License',
            self::NATIONAL_ID->value => 'National ID',
            self::OTHER->value => 'Other',
        ];
    }

    // Get all values as array
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
