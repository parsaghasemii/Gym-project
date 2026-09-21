# Spec: Gym MVP — Member Onboarding & Program Generation

Status: ready-for-agent

## Problem Statement

Members of a single gym need a way to sign up, share the information required to assess their fitness context, choose muscle-focus priorities, and receive a personalized weekly plan that covers both training and nutrition. Today the project contains no application code—only agent skills—so there is no way for members to register, complete onboarding, or view a generated program.

Members cannot reliably get a structured workout split aligned to how many days per week they train (3–5), nor daily nutrition guidance (calories and macros with meal suggestions) without manual coaching. The gym also lacks an admin surface to maintain the exercise and meal catalog that powers automated program generation.

## Solution

Build a Persian, RTL web application for one gym using Laravel, Laravel Breeze (Blade stack), and SQLite for local development. After registration and login (email verification disabled for v1), new members complete a four-step onboarding wizard collecting profile, body metrics, goals, training frequency, equipment access, optional injury notes, and 1–3 muscle-group priorities.

When onboarding completes, a rule-based **Program Generator** analyzes the member profile and produces a **Program** valid for four weeks: training days with exercises (sets, reps, rest) and daily nutrition targets (calories, protein, carbs, fat) plus suggested meals. Members view their program on a dashboard; they can edit profile data and request a new program. Admins manage exercises, meals, and users through a simple admin panel.

Program generation uses deterministic rules—no external AI APIs. Training split selection depends on days per week:

| Days/week | Split |
|-----------|-------|
| 3 | Full Body (emphasis on selected muscle groups) |
| 4 | Upper / Lower |
| 5 | Push / Pull / Legs plus two focus days |

Nutrition uses Mifflin-St Jeor BMR, activity-adjusted TDEE, goal-based calorie adjustment (−500 / +300 / ±0 kcal), and macro split (protein 1.8 g/kg, fat 25% of calories, remainder carbs).

## User Stories

1. As a visitor, I want to see a landing page in Persian, so that I understand what the gym platform offers before signing up.
2. As a visitor, I want to register with name, email, and password, so that I can create a member account without email verification blocking access.
3. As a member, I want to log in and log out securely, so that my program and profile remain private.
4. As a new member, I want to be guided through a four-step onboarding wizard after signup, so that I am not overwhelmed by one long form.
5. As a new member, I want to enter my age, gender, height, and weight in onboarding step 2, so that the system can calculate nutrition targets.
6. As a new member, I want to select my fitness level (beginner, intermediate, advanced), so that exercise difficulty matches my experience.
7. As a new member, I want to select my goal (weight loss, muscle gain, general fitness), so that calorie targets align with my intent.
8. As a new member, I want to choose how many days per week I train (3, 4, or 5), so that my workout split matches my schedule.
9. As a new member, I want to declare my equipment access (full gym, home with dumbbells/bands, or bodyweight only), so that assigned exercises are achievable.
10. As a new member, I want to optionally note injuries or limitations, so that the generator can avoid unsuitable movements where rules support it.
11. As a new member, I want to pick 1–3 muscle groups to prioritize (chest, back, legs, shoulders, arms, forearms, abs), so that my program reflects my focus areas.
12. As a new member, I want onboarding to validate each step before advancing, so that I fix errors immediately.
13. As a new member, I want a program generated automatically when onboarding completes, so that I see value without waiting for a coach.
14. As a member, I want to view my current four-week program on a dedicated program page, so that I know what to train and eat each day.
15. As a member, I want each training day to list exercises with sets, reps, and rest periods, so that I can execute sessions without guessing.
16. As a member, I want daily nutrition targets (calories and macros) displayed with suggested meals, so that I have practical eating guidance without full recipes in v1.
17. As a member, I want a dashboard summarizing my profile status and linking to my program, so that I have a home base after login.
18. As a member, I want to edit my profile information, so that changes in weight or goals can be reflected in future programs.
19. As a member, I want to request a new program after updating my profile, so that I am not stuck with an outdated plan for more than four weeks if my context changes.
20. As a member, I want the UI to be fully Persian with RTL layout and a readable Persian font, so that the experience feels native.
21. As a member, I want to be redirected to onboarding if I have not completed it, so that I cannot access an empty program state.
22. As an admin, I want to log in with an admin role, so that I can manage platform content.
23. As an admin, I want to create, read, update, and delete exercises, so that the exercise catalog stays current.
24. As an admin, I want each exercise tagged by muscle group, equipment type, and difficulty, so that the generator can filter appropriately.
25. As an admin, I want to create, read, update, and delete meal suggestions, so that nutrition recommendations stay varied.
26. As an admin, I want to view a list of members, so that I can monitor who has completed onboarding.
27. As a developer, I want seed data for muscle groups, exercises, and meals, so that program generation works out of the box in development.
28. As a developer, I want a seeded admin account, so that the admin panel is testable immediately after install.

## Implementation Decisions

### Stack and conventions

- **Framework:** Laravel with Laravel Breeze (Blade stack, not Livewire/Inertia).
- **Database:** SQLite for local development; schema designed for straightforward MySQL migration later.
- **UI:** Tailwind CSS (Breeze default), Vazirmatn font, RTL document direction, Persian copy throughout.
- **Auth:** Breeze session auth; email verification disabled in v1.
- **Authorization:** `role` column on `users` with values `member` (default) and `admin`; middleware gates admin routes.
- **Scope:** Single-gym MVP—not multi-tenant.

### Modules and responsibilities

- **Member Auth (Breeze):** Registration, login, logout, password reset (Breeze defaults except verification disabled).
- **Member Profile:** Stores extended attributes separate from core auth fields where appropriate; tracks `onboarding_completed` flag on user or profile.
- **Onboarding Wizard:** Four HTTP steps with server-side validation and session or persisted partial progress; on completion triggers program generation and sets onboarding complete.
- **Exercise Catalog:** Admin-managed exercises linked to muscle groups; includes default sets/reps/rest and metadata (equipment, difficulty).
- **Meal Catalog:** Admin-managed meals with macro breakdown and meal type (breakfast, lunch, dinner, snack).
- **Program Generator (core domain service):** Single entry point accepting a fully populated member profile and returning a persisted Program aggregate (training days + nutrition plan). Rule-based only—no external AI.
- **Nutrition Calculator:** Sub-service used by Program Generator; implements Mifflin-St Jeor, TDEE activity multiplier from training days, goal calorie adjustment, and macro distribution.
- **Split Selector:** Sub-service mapping days-per-week to split type (Full Body, Upper/Lower, PPL+focus).
- **Program Repository / Persistence:** Stores programs with nested program days, day exercises, program-level nutrition totals, and day meal assignments.
- **Member Views:** Landing, dashboard, program detail, profile edit; Blade templates with RTL layout.
- **Admin Panel:** CRUD for exercises, meals, and read-only or limited member list; separate layout or namespace under admin prefix.

### Data model (conceptual)

- **users:** auth fields + `role`, `onboarding_completed`
- **user_profiles:** age, gender, height, weight, fitness_level, goal, days_per_week, equipment, injuries (nullable)
- **muscle_groups:** name (Persian), slug
- **user_muscle_focus:** pivot user ↔ muscle_group (1–3 rows per user)
- **exercises:** name, muscle_group, equipment, difficulty, default sets/reps/rest
- **meals:** name, meal_type, calories, protein, carbs, fat, description
- **programs:** user, starts_at, ends_at (four-week window), status
- **program_days:** program, day_number, day_name, focus label
- **program_day_exercises:** program_day, exercise, sets, reps, rest_seconds, sort order
- **program_nutrition:** program, daily calories, protein, carbs, fat
- **program_day_meals:** program_day, meal, sort order

### Program generation rules

- Filter exercises by member equipment access and fitness level.
- Prioritize selected muscle groups when assigning volume within the chosen split.
- Assign 4–6 exercises per training day depending on split and level.
- Attach 3–5 meals per day sampling from catalog to approximate daily macro targets.
- Program validity: four weeks from generation date; member may explicitly regenerate (supersedes or archives prior active program—pick one consistent policy: deactivate previous active program).

### Routing structure (conceptual)

- Public landing `/`
- Breeze auth routes
- Onboarding prefix with four steps (authenticated, incomplete onboarding only)
- Member area: dashboard, program, profile (authenticated, onboarding complete)
- Admin prefix with CRUD (authenticated, admin role)

### Implementation phases

1. Laravel + Breeze + RTL/Persian shell + admin role seed
2. Migrations, models, factories, seeders (muscle groups, exercises, meals, admin user)
3. Onboarding wizard (four steps)
4. Program Generator service + Nutrition Calculator + Split Selector
5. Member dashboard and program Blade views
6. Admin CRUD panel
7. Profile edit and program regeneration

### Testing seam (primary)

**Single primary seam: Program Generator input → persisted Program output.**

Integration/feature tests should exercise the generator through its public interface: given a member profile fixture (complete onboarding data), assert the generated program contains:

- Correct number of training days matching `days_per_week`
- Split type consistent with the days-per-week table
- At least one exercise per training day, all compatible with declared equipment
- Increased representation of selected muscle groups versus non-selected (where rules apply)
- Daily nutrition totals within expected ranges for the member's TDEE calculation
- Program date range spanning four weeks

HTTP/onboarding tests are secondary: assert wizard completion redirects to program and marks onboarding complete. Admin CRUD tests are smoke-level for v1.

Avoid testing private helper methods; test observable program structure and member-facing HTTP outcomes.

## Testing Decisions

- **Good tests** assert external behavior: HTTP responses, database state, and program shape visible to members—not internal private methods of the generator.
- **Primary module under test:** Program Generator service (integration tests with seeded exercise/meal catalog).
- **Secondary:** Feature tests for onboarding flow end-to-end and admin authorization boundaries.
- **Prior art:** None yet—greenfield Laravel project; follow Laravel Pest/PHPUnit feature and unit test conventions.
- **Seeded catalog required** in test setup so generator tests are deterministic.

## Out of Scope

- Multi-tenant / multiple gyms
- Payment and subscription billing
- Email verification on signup
- Coach chat or messaging
- AI/LLM-based program generation
- Detailed recipes or meal prep instructions (v1 is macros + meal suggestions only)
- Progress tracking (weight logs, photos, PR history)
- Mobile native apps
- English or LTR locale in v1
- Social features or member-to-member interaction

## Further Notes

- Issue tracker is not yet configured via `/setup-matt-pocock-skills`; this spec is published locally at `docs/gym.md`.
- Repository currently contains only Cursor agent skills under `.cursor/skills/`—all application code is net-new.
- Recommended admin seed credentials should be documented in README (not committed as production secrets).
- Injury handling in v1 may be limited to storing the note; automated exercise exclusion rules can be incremental if time-constrained.
- Regenerating a program should deactivate the previous active program to avoid multiple conflicting active programs per member.
