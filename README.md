# Gym MVP — Laravel App

Persian RTL web application for a single gym: member registration, onboarding (upcoming), and personalized training/nutrition programs.

## Requirements

- PHP 8.3+ with extensions: `mbstring`, `openssl`, `pdo_sqlite`, `sqlite3`, `xml`, `curl`
- Composer
- Node.js 20+ (or Node 18 with the pinned Vite 5 toolchain in `package.json`)
- SQLite (file database for local development)

Install the PHP SQLite extension on Ubuntu/Debian:

```bash
sudo apt install php8.3-sqlite3
```

## Setup

```bash
cp .env.example .env
composer install
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

Open [http://localhost:8000](http://localhost:8000).

## Admin account

Configure admin credentials in `.env` (never commit real passwords):

| Variable | Default |
|----------|---------|
| `ADMIN_EMAIL` | `admin@gym.local` |
| `ADMIN_PASSWORD` | `password` |
| `ADMIN_NAME` | `مدیر باشگاه` |

Run `php artisan db:seed` to create or update the admin user.

## Testing

```bash
php artisan test
```

## Ticket 01 scope

- Laravel + Breeze (Blade) + SQLite
- Persian RTL landing page with Vazirmatn font
- Register / login / logout without email verification
- `users.role` (`member` \| `admin`) and `users.onboarding_completed`
- Seeded admin account
- Member dashboard placeholder pointing to upcoming onboarding wizard

## Project docs

- Spec: `.scratch/gym-mvp/spec.md`
- Tickets: `.scratch/gym-mvp/issues/`
