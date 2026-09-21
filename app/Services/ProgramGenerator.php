<?php

namespace App\Services;

use App\Enums\MealType;
use App\Enums\ProgramStatus;
use App\Enums\SplitType;
use App\Models\Exercise;
use App\Models\Meal;
use App\Models\Program;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProgramGenerator
{
    public function __construct(
        private NutritionCalculator $nutritionCalculator,
        private SplitSelector $splitSelector,
    ) {}

    public function generate(User $user): Program
    {
        $user->load(['profile', 'muscleFocus']);

        $profile = $user->profile;

        if ($profile === null || ! $profile->isComplete()) {
            throw new \InvalidArgumentException('User profile is incomplete.');
        }

        if ($user->muscleFocus->isEmpty()) {
            throw new \InvalidArgumentException('User must select at least one muscle focus.');
        }

        return DB::transaction(function () use ($user, $profile) {
            Program::query()
                ->where('user_id', $user->id)
                ->where('status', ProgramStatus::Active)
                ->update(['status' => ProgramStatus::Inactive]);

            $splitType = SplitType::forDaysPerWeek($profile->days_per_week);
            $nutrition = $this->nutritionCalculator->calculate($profile);
            $dayTemplates = $this->splitSelector->buildDays($profile->days_per_week, $user->muscleFocus);
            $exercises = $this->availableExercises($profile);
            $meals = Meal::query()->get();
            $focusIds = $user->muscleFocus->pluck('id')->all();

            $startsAt = now()->startOfDay();
            $endsAt = $startsAt->copy()->addWeeks(4)->subDay();

            $program = Program::query()->create([
                'user_id' => $user->id,
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'status' => ProgramStatus::Active,
                'split_type' => $splitType,
            ]);

            $program->nutrition()->create([
                'daily_calories' => $nutrition['calories'],
                'protein' => $nutrition['protein'],
                'carbs' => $nutrition['carbs'],
                'fat' => $nutrition['fat'],
            ]);

            foreach ($dayTemplates as $index => $template) {
                $programDay = $program->days()->create([
                    'day_number' => $index + 1,
                    'day_name' => $template['day_name'],
                    'focus_label' => $template['focus_label'],
                ]);

                $selectedExercises = $this->selectExercises(
                    $exercises,
                    $template['muscle_slugs'],
                    $focusIds,
                    $profile->fitness_level->value,
                );

                foreach ($selectedExercises as $sortOrder => $exercise) {
                    $programDay->exercises()->create([
                        'exercise_id' => $exercise->id,
                        'sets' => $exercise->default_sets,
                        'reps' => $exercise->default_reps,
                        'rest_seconds' => $exercise->rest_seconds,
                        'sort_order' => $sortOrder + 1,
                    ]);
                }

                $this->assignMeals($programDay, $meals, $nutrition);
            }

            return $program->load(['days.exercises.exercise', 'days.meals.meal', 'nutrition']);
        });
    }

    /**
     * @return Collection<int, Exercise>
     */
    private function availableExercises($profile): Collection
    {
        return Exercise::query()
            ->with('muscleGroup')
            ->get()
            ->filter(function (Exercise $exercise) use ($profile) {
                return $profile->equipment->allows($exercise->equipment)
                    && $exercise->difficulty->isAllowedFor($profile->fitness_level);
            })
            ->values();
    }

    /**
     * @param  Collection<int, Exercise>  $pool
     * @param  list<string>  $muscleSlugs
     * @param  list<int>  $focusIds
     * @return list<Exercise>
     */
    private function selectExercises(Collection $pool, array $muscleSlugs, array $focusIds, string $fitnessLevel): array
    {
        $targetCount = match ($fitnessLevel) {
            'beginner' => 4,
            'intermediate' => 5,
            default => 6,
        };

        $selected = [];
        $usedIds = [];

        foreach ($muscleSlugs as $slug) {
            if (count($selected) >= $targetCount) {
                break;
            }

            $candidates = $pool
                ->filter(fn (Exercise $e) => $e->muscleGroup->slug === $slug && ! in_array($e->id, $usedIds, true))
                ->sortByDesc(fn (Exercise $e) => in_array($e->muscle_group_id, $focusIds, true))
                ->values();

            if ($candidates->isEmpty()) {
                continue;
            }

            $exercise = $candidates->first();
            $selected[] = $exercise;
            $usedIds[] = $exercise->id;
        }

        if (count($selected) < $targetCount) {
            $remaining = $pool
                ->filter(fn (Exercise $e) => ! in_array($e->id, $usedIds, true))
                ->sortByDesc(fn (Exercise $e) => in_array($e->muscle_group_id, $focusIds, true))
                ->values();

            foreach ($remaining as $exercise) {
                if (count($selected) >= $targetCount) {
                    break;
                }

                $selected[] = $exercise;
                $usedIds[] = $exercise->id;
            }
        }

        return $selected;
    }

    /**
     * @param  array{calories: int, protein: int, carbs: int, fat: int}  $nutrition
     */
    private function assignMeals($programDay, Collection $meals, array $nutrition): void
    {
        $types = [MealType::Breakfast, MealType::Lunch, MealType::Dinner, MealType::Snack];
        $selected = [];
        $totals = ['calories' => 0, 'protein' => 0, 'carbs' => 0, 'fat' => 0];

        foreach ($types as $type) {
            $typeMeals = $meals->where('meal_type', $type)->shuffle();
            if ($typeMeals->isEmpty()) {
                continue;
            }

            $meal = $typeMeals->first();
            $selected[] = $meal;
            $totals['calories'] += $meal->calories;
            $totals['protein'] += $meal->protein;
            $totals['carbs'] += $meal->carbs;
            $totals['fat'] += $meal->fat;
        }

        $snacks = $meals->where('meal_type', MealType::Snack)->shuffle();
        while (count($selected) < 5 && $totals['calories'] < $nutrition['calories'] * 0.85 && $snacks->isNotEmpty()) {
            $snack = $snacks->shift();
            if ($snack && ! collect($selected)->contains('id', $snack->id)) {
                $selected[] = $snack;
                $totals['calories'] += $snack->calories;
            }
        }

        foreach ($selected as $sortOrder => $meal) {
            $programDay->meals()->create([
                'meal_id' => $meal->id,
                'sort_order' => $sortOrder + 1,
            ]);
        }
    }
}
