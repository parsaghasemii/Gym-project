<?php

namespace App\Enums;

enum Goal: string
{
    case WeightLoss = 'weight_loss';
    case MuscleGain = 'muscle_gain';
    case GeneralFitness = 'general_fitness';

    public function label(): string
    {
        return match ($this) {
            self::WeightLoss => 'کاهش وزن',
            self::MuscleGain => 'عضله‌سازی',
            self::GeneralFitness => 'تناسب اندام',
        };
    }
}
