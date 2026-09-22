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

    public function test_onboarded_member_can_view_fitness_profile_read_only(): void
    {
        $user = User::factory()->onboarded()->create();
        $muscleGroups = MuscleGroup::query()->take(2)->get();

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
            'injuries' => 'زانو',
        ]);

        $user->muscleFocus()->sync($muscleGroups->pluck('id'));

        $response = $this->actingAs($user)
            ->get(route('fitness-profile.edit'))
            ->assertOk();

        $response->assertSee('اطلاعات ثبت‌شده در ساخت برنامه', false);
        $response->assertSee(Goal::WeightLoss->label(), false);
        $response->assertSee(Equipment::Home->label(), false);
        $response->assertSee('زانو', false);

        foreach ($muscleGroups as $group) {
            $response->assertSee($group->name, false);
        }

        $response->assertDontSee('ذخیره تغییرات', false);
        $response->assertDontSee('دریافت برنامه جدید', false);
        $response->assertDontSee('name="age"', false);
    }

    public function test_fitness_profile_update_route_is_not_available(): void
    {
        $user = User::factory()->onboarded()->create();

        $this->actingAs($user)
            ->patch('/fitness-profile')
            ->assertMethodNotAllowed();
    }
}
