<?php

namespace App\Enums;

enum FitnessLevel: string
{
    case Beginner = 'beginner';
    case Intermediate = 'intermediate';
    case Advanced = 'advanced';

    public function label(): string
    {
        return match ($this) {
            self::Beginner => 'مبتدی',
            self::Intermediate => 'متوسط',
            self::Advanced => 'پیشرفته',
        };
    }
}
