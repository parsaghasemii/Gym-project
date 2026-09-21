<?php

namespace App\Enums;

enum MealType: string
{
    case Breakfast = 'breakfast';
    case Lunch = 'lunch';
    case Dinner = 'dinner';
    case Snack = 'snack';

    public function label(): string
    {
        return match ($this) {
            self::Breakfast => 'صبحانه',
            self::Lunch => 'ناهار',
            self::Dinner => 'شام',
            self::Snack => 'میان‌وعده',
        };
    }
}
