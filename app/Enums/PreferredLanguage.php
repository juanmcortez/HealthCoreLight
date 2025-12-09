<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace App\Enums;

enum PreferredLanguage: string
{
    case ENGLISH = 'en';
    case SPANISH = 'es';
    case FRENCH = 'fr';
    case GERMAN = 'de';
    case CHINESE = 'zh';
    case JAPANESE = 'ja';
    case ARABIC = 'ar';
    case HINDI = 'hi';
    case PORTUGUESE = 'pt';

    // Label for display
    public function label(): string
    {
        return match ($this) {
            self::ENGLISH => 'English',
            self::SPANISH => 'Spanish',
            self::FRENCH => 'French',
            self::GERMAN => 'German',
            self::CHINESE => 'Chinese',
            self::JAPANESE => 'Japanese',
            self::ARABIC => 'Arabic',
            self::HINDI => 'Hindi',
            self::PORTUGUESE => 'Portuguese',
        };
    }

    // Options for select dropdown
    public static function options(): array
    {
        return [
            self::ENGLISH->value => 'English',
            self::SPANISH->value => 'Spanish',
            self::FRENCH->value => 'French',
            self::GERMAN->value => 'German',
            self::CHINESE->value => 'Chinese',
            self::JAPANESE->value => 'Japanese',
            self::ARABIC->value => 'Arabic',
            self::HINDI->value => 'Hindi',
            self::PORTUGUESE->value => 'Portuguese',
        ];
    }

    // Get all values as array
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
