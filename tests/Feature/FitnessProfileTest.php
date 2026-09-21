<?php

namespace Tests\Feature;

use App\Enums\Equipment;
use App\Enums\FitnessLevel;
use App\Enums\Gender;
use App\Enums\Goal;
use App\Models\MuscleGroup;
use App\Models\User;
use App\Models\UserProfile;
use Database\Seeders\MuscleGroupSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FitnessProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MuscleGroupSeeder::class);
    }

    public function test_onboarded_member_can_update_fitness_profile(): void
    {
        $user = User::factory()->onboarded()->create();
        $muscleGroups = MuscleGroup::query()->take(2)->pluck('id')->all();

        UserProfile::query()->create([
            'user_id' => $user->id,
            'age' => 25,
            'gender' => Gender::Female,
            'height' => 165,
            'weight' => 60,
            'fitness_level' => FitnessLevel::Beginner,
            'goal' => Goal::WeightLoss,
            'days_per_week' => 3,
            'equipment' => Equipment::Home,
        ]);

        $this->actingAs($user)
            ->patch(route('fitness-profile.update'), [
                'age' => 26,
                'gender' => Gender::Female->value,
                'height' => 165,
                'weight' => 58,
                'fitness_level' => FitnessLevel::Intermediate->value,
                'goal' => Goal::GeneralFitness->value,
                'days_per_week' => 4,
                'equipment' => Equipment::FullGym->value,
                'injuries' => null,
                'muscle_groups' => $muscleGroups,
            ])
            ->assertRedirect(route('fitness-profile.edit'))
            ->assertSessionHas('status');

        $user->refresh();

        $this->assertEquals(58, $user->profile->weight);
        $this->assertEquals(4, $user->profile->days_per_week);
        $this->assertCount(2, $user->muscleFocus);
    }
}
