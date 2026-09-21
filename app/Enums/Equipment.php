<?php

namespace App\Enums;

enum Equipment: string
{
    case FullGym = 'full_gym';
    case Home = 'home';
    case Bodyweight = 'bodyweight';

    public function label(): string
    {
        return match ($this) {
            self::FullGym => 'باشگاه کامل',
            self::Home => 'خانه (دمبل/کش)',
            self::Bodyweight => 'فقط وزن بدن',
        };
    }

    public function allows(Equipment $exerciseEquipment): bool
    {
        return match ($this) {
            self::FullGym => true,
            self::Home => in_array($exerciseEquipment, [self::Home, self::Bodyweight], true),
            self::Bodyweight => $exerciseEquipment === self::Bodyweight,
        };
    }
}
