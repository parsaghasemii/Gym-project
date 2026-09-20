<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppShellTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_renders_persian_rtl_content(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('dir="rtl"', false);
        $response->assertSee('lang="fa"', false);
        $response->assertSee('برنامه تمرین و تغذیه شخصی‌سازی‌شده', false);
        $response->assertSee('ثبت‌نام', false);
    }

    public function test_registration_creates_member_with_defaults(): void
    {
        $response = $this->post('/register', [
            'name' => 'عضو جدید',
            'email' => 'member@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => 'member@example.com',
            'role' => UserRole::Member->value,
            'onboarding_completed' => false,
        ]);
    }

    public function test_member_can_login_and_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->post('/login', [
            'email' => 'login@example.com',
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);

        $this->post('/logout')->assertRedirect('/');

        $this->assertGuest();
    }

    public function test_authenticated_member_sees_onboarding_placeholder(): void
    {
        $user = User::factory()->create([
            'onboarding_completed' => false,
        ]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('تکمیل onboarding', false);
    }

    public function test_authenticated_member_is_redirected_from_home_to_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/')
            ->assertRedirect(route('dashboard'));
    }

    public function test_admin_user_seeder_creates_admin_account(): void
    {
        config([
            'gym.admin_email' => 'admin@gym.local',
            'gym.admin_password' => 'secret-admin-pass',
            'gym.admin_name' => 'مدیر',
        ]);

        $this->seed(AdminUserSeeder::class);

        $admin = User::where('email', 'admin@gym.local')->first();

        $this->assertNotNull($admin);
        $this->assertTrue($admin->isAdmin());
        $this->assertTrue($admin->onboarding_completed);
    }
}
