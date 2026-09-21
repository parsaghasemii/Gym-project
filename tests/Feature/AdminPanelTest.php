<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\MuscleGroup;
use App\Models\User;
use Database\Seeders\MuscleGroupSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MuscleGroupSeeder::class);
    }

    public function test_member_cannot_access_admin_routes(): void
    {
        $member = User::factory()->create();

        $this->actingAs($member)
            ->get(route('admin.exercises.index'))
            ->assertForbidden();
    }

    public function test_admin_can_create_exercise(): void
    {
        $admin = User::factory()->admin()->create();
        $muscleGroup = MuscleGroup::query()->first();

        $this->actingAs($admin)
            ->post(route('admin.exercises.store'), [
                'name' => 'تست حرکت',
                'muscle_group_id' => $muscleGroup->id,
                'equipment' => 'full_gym',
                'difficulty' => 'beginner',
                'default_sets' => 3,
                'default_reps' => '10',
                'rest_seconds' => 60,
            ])
            ->assertRedirect(route('admin.exercises.index'));

        $this->assertDatabaseHas('exercises', ['name' => 'تست حرکت']);
    }

    public function test_admin_sees_member_list(): void
    {
        $admin = User::factory()->admin()->create();
        User::factory()->create(['name' => 'عضو نمونه']);

        $this->actingAs($admin)
            ->get(route('admin.members.index'))
            ->assertOk()
            ->assertSee('عضو نمونه');
    }

    public function test_admin_can_create_meal(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.meals.store'), [
                'name' => 'صبحانه تست',
                'meal_type' => 'breakfast',
                'calories' => 400,
                'protein' => 25,
                'carbs' => 45,
                'fat' => 12,
                'description' => 'توضیح تست',
            ])
            ->assertRedirect(route('admin.meals.index'));

        $this->assertDatabaseHas('meals', ['name' => 'صبحانه تست']);
    }
}
