<?php

namespace App\Enums;

enum Difficulty: string
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

    public function isAllowedFor(FitnessLevel $level): bool
    {
        return match ($level) {
            FitnessLevel::Beginner => $this === self::Beginner,
            FitnessLevel::Intermediate => in_array($this, [self::Beginner, self::Intermediate], true),
            FitnessLevel::Advanced => true,
        };
    }
}
