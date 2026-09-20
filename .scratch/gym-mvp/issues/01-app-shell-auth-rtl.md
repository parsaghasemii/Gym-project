# 01: App shell — Laravel, auth, and Persian RTL landing

**What to build:** A visitor can open a Persian RTL landing page, register, log in, and log out. The application runs on Laravel with Breeze (Blade stack) and SQLite. New accounts are members by default; a seeded admin account exists for later admin work. Email verification is disabled so signup flows straight through without a confirmation step.

**Blocked by:** None (can start immediately)

**Status:** done

- [x] Laravel project boots with Breeze Blade stack and SQLite configured for local development
- [x] Landing page renders in Persian with RTL layout and Vazirmatn (or equivalent Persian web font)
- [x] Registration and login work without email verification blocking access
- [x] Users table includes `role` (`member` | `admin`) and `onboarding_completed` (boolean, default false)
- [x] A seeded admin account exists; credentials documented in README (not hard-coded secrets in repo)
- [x] Logged-out visitors see the landing page; authenticated members reach a placeholder or redirect toward onboarding (full onboarding arrives in ticket 03)
