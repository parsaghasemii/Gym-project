<?php

namespace App\Enums;

enum SplitType: string
{
    case FullBody = 'full_body';
    case UpperLower = 'upper_lower';
    case PplFocus = 'ppl_focus';

    public function label(): string
    {
        return match ($this) {
            self::FullBody => 'تمام بدن',
            self::UpperLower => 'بالا / پایین',
            self::PplFocus => 'Push / Pull / Legs + تمرکز',
        };
    }

    public static function forDaysPerWeek(int $days): self
    {
        return match ($days) {
            3 => self::FullBody,
            4 => self::UpperLower,
            5 => self::PplFocus,
            default => self::FullBody,
        };
    }
}
