<?php

namespace Tests\Feature;

use App\Enums\Equipment;
use App\Enums\FitnessLevel;
use App\Enums\Gender;
use App\Enums\Goal;
use App\Enums\ProgramStatus;
use App\Models\MuscleGroup;
use App\Models\Program;
use App\Models\User;
use App\Models\UserProfile;
use App\Services\ProgramGenerator;
use Database\Seeders\ExerciseSeeder;
use Database\Seeders\MealSeeder;
use Database\Seeders\MuscleGroupSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramRegenerateTest extends TestCase
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

    public function test_regenerate_deletes_programs_and_restarts_onboarding(): void
    {
        $user = User::factory()->onboarded()->create();

        UserProfile::query()->create([
            'user_id' => $user->id,
            'age' => 28,
            'gender' => Gender::Male,
            'height' => 175,
            'weight' => 78,
            'fitness_level' => FitnessLevel::Intermediate,
            'goal' => Goal::MuscleGain,
            'days_per_week' => 4,
            'equipment' => Equipment::FullGym,
        ]);

        $user->muscleFocus()->sync(
            MuscleGroup::query()->whereIn('slug', ['chest', 'back'])->pluck('id'),
        );

        $program = app(ProgramGenerator::class)->generate($user->fresh());
        $programId = $program->id;

        $this->actingAs($user)
            ->post(route('program.regenerate'))
            ->assertRedirect(route('onboarding.step1'))
            ->assertSessionHas('status');

        $user->refresh();

        $this->assertFalse($user->onboarding_completed);
        $this->assertNull(Program::query()->find($programId));
        $this->assertSame(0, $user->programs()->count());
        $this->assertNull($user->activeProgram);
    }

    public function test_regenerate_deletes_inactive_programs_too(): void
    {
        $user = $this->memberWithProgram();

        $inactiveProgram = Program::query()->create([
            'user_id' => $user->id,
            'starts_at' => now()->subMonths(2),
            'ends_at' => now()->subMonth(),
            'status' => ProgramStatus::Inactive,
            'split_type' => $user->activeProgram->split_type,
        ]);

        $this->actingAs($user)
            ->post(route('program.regenerate'))
            ->assertRedirect(route('onboarding.step1'));

        $this->assertSame(0, Program::query()->where('user_id', $user->id)->count());
        $this->assertDatabaseMissing('programs', ['id' => $inactiveProgram->id]);
    }

    private function memberWithProgram(): User
    {
        $user = User::factory()->onboarded()->create();

        UserProfile::query()->create([
            'user_id' => $user->id,
            'age' => 28,
            'gender' => Gender::Male,
            'height' => 175,
            'weight' => 78,
            'fitness_level' => FitnessLevel::Intermediate,
            'goal' => Goal::MuscleGain,
            'days_per_week' => 4,
            'equipment' => Equipment::FullGym,
        ]);

        $user->muscleFocus()->sync(
            MuscleGroup::query()->whereIn('slug', ['chest', 'back'])->pluck('id'),
        );

        app(ProgramGenerator::class)->generate($user->fresh());

        return $user->fresh();
    }
}
