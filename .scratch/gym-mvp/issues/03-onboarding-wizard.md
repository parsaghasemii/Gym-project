# 03: Onboarding wizard — four-step member profile

**What to build:** A new member, after signup, is guided through a four-step Persian RTL onboarding wizard until their profile is complete. Step 1 captures personal info; step 2 body metrics (age, gender, height, weight); step 3 goal, fitness level, days per week (3/4/5), equipment access, optional injuries; step 4 selects 1–3 muscle-group priorities. Each step validates before advancing. Incomplete members are redirected to onboarding from member-only areas. On completion, `onboarding_completed` is set true — program generation is ticket 04.

**Blocked by:** 01 (App shell — Laravel, auth, and Persian RTL landing)

**Status:** ready-for-agent

- [ ] User profile and muscle-focus pivot tables persist all onboarding fields
- [ ] Four-step wizard with server-side validation and Persian error messages
- [ ] Muscle-group selection enforces 1–3 choices from the seven seeded groups
- [ ] Middleware redirects authenticated members with incomplete onboarding to the wizard
- [ ] Completing step 4 sets `onboarding_completed` and redirects to a sensible next step (program page stub or dashboard placeholder until ticket 04)
- [ ] Feature test: register → complete all four steps → profile and muscle-focus rows exist in database
