# Gym MVP — Laravel App

Persian RTL web application for a single gym: member registration, four-step onboarding, rule-based program generation (training + nutrition), and admin catalog management.

## Requirements

- PHP 8.3+ with extensions: `mbstring`, `openssl`, `pdo_sqlite`, `sqlite3`, `xml`, `curl`
- Composer
- Node.js 20+ (or Node 18 with the pinned Vite 5 toolchain in `package.json`)
- SQLite (file database for local development)

Install the PHP SQLite extension on Ubuntu/Debian (recommended):

```bash
sudo apt install php8.3-sqlite3
```

If you cannot install system packages yet, this repo ships a local fallback under `.php-ext/` used by `./serve.sh` and `./scripts/php.sh`.

## Setup

```bash
cp .env.example .env
composer install
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm install
npm run build
./serve.sh
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000).

Use `./serve.sh` instead of `php artisan serve` when the system PHP SQLite extension is missing.

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
./scripts/php.sh vendor/bin/phpunit
```

Or, if system PHP has SQLite enabled:

```bash
php artisan test
```

## Features

- **Public:** Persian RTL landing page with FAQ chat widget
- **Auth:** Breeze register / login / logout (email verification disabled)
- **Onboarding:** Four-step wizard → automatic 4-week program generation
- **Member area:** Dashboard, program view, fitness profile edit, program regeneration from current profile
- **Admin:** CRUD for exercises and meals, read-only member list
- **Program engine:** Split selection (Full Body / Upper-Lower / PPL+focus), equipment & level filtering, muscle-focus prioritization, Mifflin-St Jeor nutrition

## Project docs

- Spec: [`docs/gym.md`](docs/gym.md)
