<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => config('gym.admin_email')],
            [
                'name' => config('gym.admin_name'),
                'password' => Hash::make(config('gym.admin_password')),
                'role' => UserRole::Admin,
                'onboarding_completed' => true,
                'email_verified_at' => now(),
            ],
        );
    }
}
