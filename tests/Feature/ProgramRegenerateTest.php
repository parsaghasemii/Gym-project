<?php

namespace Tests\Feature;

use App\Enums\Equipment;
use App\Enums\FitnessLevel;
use App\Enums\Gender;
use App\Enums\Goal;
use App\Enums\ProgramStatus;
use App\Models\MuscleGroup;
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

    public function test_regenerate_creates_new_program_from_current_profile(): void
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

        $this->actingAs($user)
            ->post(route('program.regenerate'))
            ->assertRedirect(route('program.show'))
            ->assertSessionHas('status');

        $user->refresh();

        $this->assertTrue($user->onboarding_completed);
        $this->assertEquals(ProgramStatus::Inactive, $program->fresh()->status);
        $this->assertNotNull($user->activeProgram);
        $this->assertNotEquals($program->id, $user->activeProgram->id);
    }

    public function test_regenerate_requires_complete_profile(): void
    {
        $user = User::factory()->onboarded()->create();

        $this->actingAs($user)
            ->post(route('program.regenerate'))
            ->assertRedirect(route('fitness-profile.edit'))
            ->assertSessionHas('error');
    }
}
