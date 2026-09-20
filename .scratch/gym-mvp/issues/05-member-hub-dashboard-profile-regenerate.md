# 05: Member hub — dashboard, profile edit, and program regeneration

**What to build:** A member with an active program has a home dashboard summarizing their profile and linking to their program, a profile page to edit body metrics goals equipment injuries and muscle focus, and the ability to request a new program that deactivates the previous active program and generates a fresh four-week plan from updated data. All three surfaces are one vertical member-hub slice: schema changes (if any), backend actions, and Blade UI ship together and are demoable as a unit.

**Blocked by:** 04 (Program generator and program page — complete training & nutrition plan)

**Status:** ready-for-agent

- [ ] Dashboard shows member summary (name, goal, days per week, program dates) and link to program page
- [ ] Profile edit form updates user profile and muscle-focus selections with validation matching onboarding rules
- [ ] "New program" action deactivates the current active program and invokes ProgramGenerator with updated profile
- [ ] After regeneration, member sees the new program on the program page; only one active program per member
- [ ] Admin member list (from ticket 02) reflects updated onboarding/profile state for members who edit
- [ ] Feature test: edit profile → request new program → old program inactive, new program visible with updated nutrition or exercise emphasis where applicable
