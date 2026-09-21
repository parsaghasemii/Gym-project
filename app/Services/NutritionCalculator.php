<?php

namespace App\Services;

use App\Enums\Gender;
use App\Enums\Goal;
use App\Models\UserProfile;

class NutritionCalculator
{
    /**
     * @return array{calories: int, protein: int, carbs: int, fat: int}
     */
    public function calculate(UserProfile $profile): array
    {
        $bmr = $this->bmr($profile);
        $tdee = (int) round($bmr * $this->activityMultiplier($profile->days_per_week));
        $calories = max(1200, $tdee + $this->calorieAdjustment($profile->goal));

        $protein = (int) round((float) $profile->weight * 1.8);
        $fat = (int) round($calories * 0.25 / 9);
        $proteinCalories = $protein * 4;
        $fatCalories = $fat * 9;
        $carbs = (int) max(0, round(($calories - $proteinCalories - $fatCalories) / 4));

        return [
            'calories' => $calories,
            'protein' => $protein,
            'carbs' => $carbs,
            'fat' => $fat,
        ];
    }

    private function bmr(UserProfile $profile): float
    {
        $weight = (float) $profile->weight;
        $height = (float) $profile->height;
        $age = (int) $profile->age;

        $base = (10 * $weight) + (6.25 * $height) - (5 * $age);

        return $profile->gender === Gender::Male
            ? $base + 5
            : $base - 161;
    }

    private function activityMultiplier(int $daysPerWeek): float
    {
        return match ($daysPerWeek) {
            3 => 1.375,
            4 => 1.55,
            5 => 1.725,
            default => 1.375,
        };
    }

    private function calorieAdjustment(Goal $goal): int
    {
        return match ($goal) {
            Goal::WeightLoss => -500,
            Goal::MuscleGain => 300,
            Goal::GeneralFitness => 0,
        };
    }
}
