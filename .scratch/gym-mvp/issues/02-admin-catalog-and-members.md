# 02: Admin panel — exercise & meal catalog with member list

**What to build:** An admin logs in and manages the gym's content catalog end-to-end: muscle groups, exercises, and meal suggestions via full CRUD in a Persian RTL admin area. Seed data populates the catalog (~30–40 exercises, ~15–20 meals, seven muscle groups) so later program generation has material to draw from. The admin also sees a member list (empty until members onboard in ticket 03), showing each member's name, email, and onboarding status.

**Blocked by:** 01 (App shell — Laravel, auth, and Persian RTL landing)

**Status:** ready-for-agent

- [ ] Database tables exist for muscle groups, exercises, and meals with fields needed for filtering (muscle group, equipment type, difficulty, meal type, macros)
- [ ] Seeders populate muscle groups (chest, back, legs, shoulders, arms, forearms, abs), exercises, and meals
- [ ] Admin-only middleware gates all admin routes; members cannot access admin URLs
- [ ] Admin can create, view, edit, and delete exercises and meals through Blade forms
- [ ] Admin member list page renders (empty state when no members; populated rows after ticket 03)
- [ ] Smoke test: admin logs in, creates an exercise, sees it in the list
