<?php

namespace App\Http\Controllers;

use App\Enums\Equipment;
use App\Enums\FitnessLevel;
use App\Enums\Gender;
use App\Enums\Goal;
use App\Models\MuscleGroup;
use App\Models\UserProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FitnessProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $profile = UserProfile::query()->firstOrCreate(['user_id' => $request->user()->id]);
        $muscleGroups = MuscleGroup::query()->orderBy('name')->get();
        $selected = $request->user()->muscleFocus()->pluck('muscle_groups.id')->all();

        return view('fitness-profile.edit', compact('profile', 'muscleGroups', 'selected'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'age' => ['required', 'integer', 'min:14', 'max:80'],
            'gender' => ['required', 'in:'.implode(',', array_column(Gender::cases(), 'value'))],
            'height' => ['required', 'numeric', 'min:120', 'max:230'],
            'weight' => ['required', 'numeric', 'min:35', 'max:200'],
            'fitness_level' => ['required', 'in:'.implode(',', array_column(FitnessLevel::cases(), 'value'))],
            'goal' => ['required', 'in:'.implode(',', array_column(Goal::cases(), 'value'))],
            'days_per_week' => ['required', 'in:3,4,5'],
            'equipment' => ['required', 'in:'.implode(',', array_column(Equipment::cases(), 'value'))],
            'injuries' => ['nullable', 'string', 'max:1000'],
            'muscle_groups' => ['required', 'array', 'min:1', 'max:3'],
            'muscle_groups.*' => ['exists:muscle_groups,id'],
        ], [
            'required' => 'این فیلد الزامی است.',
            'muscle_groups.required' => 'حداقل یک گروه عضلانی انتخاب کنید.',
            'muscle_groups.max' => 'حداکثر سه گروه عضلانی می‌توانید انتخاب کنید.',
        ]);

        $muscleGroups = $validated['muscle_groups'];
        unset($validated['muscle_groups']);

        $user = $request->user();
        UserProfile::query()->updateOrCreate(['user_id' => $user->id], $validated);
        $user->muscleFocus()->sync($muscleGroups);

        return redirect()->route('fitness-profile.edit')->with('status', 'پروفایل ورزشی ذخیره شد.');
    }
}
