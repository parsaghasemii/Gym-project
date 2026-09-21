<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Console\Command;

class PurgeNonAdminUsers extends Command
{
    protected $signature = 'users:purge-non-admins {--force : بدون تأیید اجرا شود}';

    protected $description = 'حذف تمام کاربران به جز ادمین';

    public function handle(): int
    {
        $count = User::query()->where('role', '!=', UserRole::Admin)->count();

        if ($count === 0) {
            $this->info('کاربر غیرادمینی برای حذف وجود ندارد.');

            return self::SUCCESS;
        }

        if (! $this->option('force') && ! $this->confirm("{$count} کاربر غیرادمین حذف شود؟")) {
            $this->warn('عملیات لغو شد.');

            return self::SUCCESS;
        }

        User::query()->where('role', '!=', UserRole::Admin)->delete();

        $this->info("{$count} کاربر حذف شد.");
        $this->table(
            ['ایمیل', 'نقش'],
            User::query()->get(['email', 'role'])->map(fn (User $user) => [
                $user->email,
                $user->role->value,
            ]),
        );

        return self::SUCCESS;
    }
}
