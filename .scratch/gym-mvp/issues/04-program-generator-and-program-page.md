# 04: Program generator and program page — complete training & nutrition plan

**What to build:** When a member finishes onboarding, the system automatically generates a four-week personalized program and displays it on a member-facing program page. The rule-based generator selects a split from days per week (3 = Full Body, 4 = Upper/Lower, 5 = PPL + focus days), assigns exercises filtered by equipment and fitness level with emphasis on chosen muscle groups, calculates daily nutrition via Mifflin-St Jeor TDEE and goal adjustments, and attaches suggested meals from the catalog. The program page shows each training day (exercises with sets, reps, rest) and daily nutrition (calories, macros, meal suggestions). This ticket delivers the full visible feature — generator logic and program UI stay together.

**Blocked by:** 02 (Admin panel — exercise & meal catalog with member list), 03 (Onboarding wizard — four-step member profile)

**Status:** ready-for-agent

- [ ] Program persistence model stores programs, training days, day exercises, nutrition totals, and day meals
- [ ] ProgramGenerator service accepts a complete member profile and returns a persisted four-week program
- [ ] NutritionCalculator implements BMR (Mifflin-St Jeor), TDEE activity multiplier, goal calorie adjustment (−500 / +300 / ±0), and macro split (protein 1.8 g/kg, fat 25%, remainder carbs)
- [ ] Split selection matches days-per-week rules; exercises respect equipment and difficulty; selected muscle groups receive higher volume where rules apply
- [ ] Onboarding completion triggers automatic program generation
- [ ] Program page renders full training and nutrition plan in Persian RTL
- [ ] Integration test on primary seam: given a profile fixture with seeded catalog, assert correct day count, split behavior, equipment-compatible exercises, nutrition ranges, and four-week date span
