<?php

namespace Tests\Feature;

use App\Enums\Equipment;
use App\Enums\FitnessLevel;
use App\Enums\Gender;
use App\Enums\Goal;
use App\Enums\ProgramStatus;
use App\Enums\SplitType;
use App\Models\MuscleGroup;
use App\Models\User;
use App\Models\UserProfile;
use App\Services\NutritionCalculator;
use App\Services\ProgramGenerator;
use Database\Seeders\ExerciseSeeder;
use Database\Seeders\MealSeeder;
use Database\Seeders\MuscleGroupSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramGeneratorTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            MuscleGroupSeeder::class,
            ExerciseSeeder::class,
            MealSeeder::class,
        ]);
    }

    public function test_generates_four_week_program_with_correct_day_count_and_split(): void
    {
        $user = $this->createMemberWithProfile(daysPerWeek: 4);
        $generator = app(ProgramGenerator::class);

        $program = $generator->generate($user);

        $this->assertEquals(SplitType::UpperLower, $program->split_type);
        $this->assertEquals(ProgramStatus::Active, $program->status);
        $this->assertCount(4, $program->days);
        $this->assertEquals(4, $program->starts_at->diffInWeeks($program->ends_at->addDay()));
        $this->assertNotNull($program->nutrition);
    }

    public function test_exercises_match_equipment_and_nutrition_in_expected_range(): void
    {
        $user = $this->createMemberWithProfile(daysPerWeek: 3, equipment: Equipment::Bodyweight);
        $expectedNutrition = app(NutritionCalculator::class)->calculate($user->profile);

        $program = app(ProgramGenerator::class)->generate($user);

        foreach ($program->days as $day) {
            $this->assertGreaterThanOrEqual(1, $day->exercises->count());

            foreach ($day->exercises as $dayExercise) {
                $this->assertTrue(
                    Equipment::Bodyweight->allows($dayExercise->exercise->equipment),
                );
            }

            $this->assertGreaterThanOrEqual(3, $day->meals->count());
        }

        $this->assertEquals($expectedNutrition['calories'], $program->nutrition->daily_calories);
        $this->assertEquals($expectedNutrition['protein'], $program->nutrition->protein);
    }

    public function test_regeneration_deactivates_previous_program(): void
    {
        $user = $this->createMemberWithProfile(daysPerWeek: 5);
        $generator = app(ProgramGenerator::class);

        $first = $generator->generate($user);
        $second = $generator->generate($user->fresh());

        $this->assertEquals(ProgramStatus::Inactive, $first->fresh()->status);
        $this->assertEquals(ProgramStatus::Active, $second->status);
        $this->assertEquals(SplitType::PplFocus, $second->split_type);
        $this->assertCount(5, $second->days);
    }

    public function test_prioritizes_selected_muscle_groups_in_exercise_selection(): void
    {
        $chestGroup = MuscleGroup::query()->where('slug', 'chest')->first();
        $legsGroup = MuscleGroup::query()->where('slug', 'legs')->first();

        $chestUser = $this->createMemberWithProfile(daysPerWeek: 3, focusSlugs: ['chest']);
        $legsUser = $this->createMemberWithProfile(daysPerWeek: 3, focusSlugs: ['legs']);

        $chestProgram = app(ProgramGenerator::class)->generate($chestUser);
        $legsProgram = app(ProgramGenerator::class)->generate($legsUser);

        $chestFocusCount = $this->countExercisesForMuscleGroup($chestProgram, $chestGroup->id);
        $legsFocusCount = $this->countExercisesForMuscleGroup($legsProgram, $legsGroup->id);
        $chestInLegsProgram = $this->countExercisesForMuscleGroup($legsProgram, $chestGroup->id);
        $legsInChestProgram = $this->countExercisesForMuscleGroup($chestProgram, $legsGroup->id);

        $this->assertGreaterThan($chestInLegsProgram, $chestFocusCount);
        $this->assertGreaterThan($legsInChestProgram, $legsFocusCount);
    }

    private function countExercisesForMuscleGroup($program, int $muscleGroupId): int
    {
        $count = 0;

        foreach ($program->days as $day) {
            foreach ($day->exercises as $dayExercise) {
                if ($dayExercise->exercise->muscle_group_id === $muscleGroupId) {
                    $count++;
                }
            }
        }

        return $count;
    }

    /**
     * @param  list<string>  $focusSlugs
     */
    private function createMemberWithProfile(int $daysPerWeek = 4, Equipment $equipment = Equipment::FullGym, array $focusSlugs = ['chest', 'back']): User
    {
        $user = User::factory()->create(['onboarding_completed' => true]);

        UserProfile::query()->create([
            'user_id' => $user->id,
            'age' => 28,
            'gender' => Gender::Male,
            'height' => 175,
            'weight' => 78,
            'fitness_level' => FitnessLevel::Intermediate,
            'goal' => Goal::MuscleGain,
            'days_per_week' => $daysPerWeek,
            'equipment' => $equipment,
        ]);

        $user->muscleFocus()->sync(
            MuscleGroup::query()->whereIn('slug', $focusSlugs)->pluck('id'),
        );

        return $user->fresh(['profile', 'muscleFocus']);
    }
}
