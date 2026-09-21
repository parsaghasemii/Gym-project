<?php

namespace Tests\Feature;

use App\Models\MuscleGroup;
use App\Models\User;
use Database\Seeders\ExerciseSeeder;
use Database\Seeders\MealSeeder;
use Database\Seeders\MuscleGroupSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OnboardingTest extends TestCase
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

    public function test_member_completes_onboarding_and_gets_program(): void
    {
        $user = User::factory()->create(['onboarding_completed' => false]);
        $muscleIds = MuscleGroup::query()->limit(2)->pluck('id')->all();

        $this->actingAs($user)
            ->post(route('onboarding.step1.store'), ['age' => 25, 'gender' => 'male'])
            ->assertRedirect(route('onboarding.step2'));

        $this->post(route('onboarding.step2.store'), ['height' => 180, 'weight' => 80])
            ->assertRedirect(route('onboarding.step3'));

        $this->post(route('onboarding.step3.store'), [
            'fitness_level' => 'beginner',
            'goal' => 'weight_loss',
            'days_per_week' => 3,
            'equipment' => 'full_gym',
            'injuries' => null,
        ])->assertRedirect(route('onboarding.step4'));

        $this->post(route('onboarding.step4.store'), ['muscle_groups' => $muscleIds])
            ->assertRedirect(route('program.show'));

        $user->refresh();

        $this->assertTrue($user->onboarding_completed);
        $this->assertDatabaseHas('user_profiles', ['user_id' => $user->id, 'days_per_week' => 3]);
        $this->assertCount(2, $user->muscleFocus);
        $this->assertNotNull($user->activeProgram);
    }

    public function test_incomplete_member_is_redirected_from_dashboard(): void
    {
        $user = User::factory()->create(['onboarding_completed' => false]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertRedirect(route('onboarding.step1'));
    }
}
