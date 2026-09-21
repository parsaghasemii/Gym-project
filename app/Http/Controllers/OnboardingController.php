<?php

namespace App\Http\Controllers;

use App\Enums\Equipment;
use App\Enums\FitnessLevel;
use App\Enums\Gender;
use App\Enums\Goal;
use App\Models\MuscleGroup;
use App\Models\UserProfile;
use App\Services\ProgramGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    public function step1(Request $request): View
    {
        $profile = $this->profileFor($request);

        return view('onboarding.step1', compact('profile'));
    }

    public function storeStep1(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'age' => ['required', 'integer', 'min:14', 'max:80'],
            'gender' => ['required', 'in:'.implode(',', array_column(Gender::cases(), 'value'))],
        ], $this->messages());

        $this->profileFor($request)->update($validated);

        return redirect()->route('onboarding.step2');
    }

    public function step2(Request $request): View
    {
        $profile = $this->profileFor($request);

        return view('onboarding.step2', compact('profile'));
    }

    public function storeStep2(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'height' => ['required', 'numeric', 'min:120', 'max:230'],
            'weight' => ['required', 'numeric', 'min:35', 'max:200'],
        ], $this->messages());

        $this->profileFor($request)->update($validated);

        return redirect()->route('onboarding.step3');
    }

    public function step3(Request $request): View
    {
        $profile = $this->profileFor($request);

        return view('onboarding.step3', compact('profile'));
    }

    public function storeStep3(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'fitness_level' => ['required', 'in:'.implode(',', array_column(FitnessLevel::cases(), 'value'))],
            'goal' => ['required', 'in:'.implode(',', array_column(Goal::cases(), 'value'))],
            'days_per_week' => ['required', 'in:3,4,5'],
            'equipment' => ['required', 'in:'.implode(',', array_column(Equipment::cases(), 'value'))],
            'injuries' => ['nullable', 'string', 'max:1000'],
        ], $this->messages());

        $this->profileFor($request)->update($validated);

        return redirect()->route('onboarding.step4');
    }

    public function step4(Request $request): View
    {
        $profile = $this->profileFor($request);
        $muscleGroups = MuscleGroup::query()->orderBy('name')->get();
        $selected = $request->user()->muscleFocus()->pluck('muscle_groups.id')->all();

        return view('onboarding.step4', compact('profile', 'muscleGroups', 'selected'));
    }

    public function storeStep4(Request $request, ProgramGenerator $generator): RedirectResponse
    {
        $validated = $request->validate([
            'muscle_groups' => ['required', 'array', 'min:1', 'max:3'],
            'muscle_groups.*' => ['exists:muscle_groups,id'],
        ], [
            'muscle_groups.required' => 'حداقل یک گروه عضلانی انتخاب کنید.',
            'muscle_groups.min' => 'حداقل یک گروه عضلانی انتخاب کنید.',
            'muscle_groups.max' => 'حداکثر سه گروه عضلانی می‌توانید انتخاب کنید.',
        ]);

        $user = $request->user();
        $user->muscleFocus()->sync($validated['muscle_groups']);
        $user->update(['onboarding_completed' => true]);

        $generator->generate($user);

        return redirect()->route('program.show');
    }

    private function profileFor(Request $request): UserProfile
    {
        return UserProfile::query()->firstOrCreate(['user_id' => $request->user()->id]);
    }

    /**
     * @return array<string, string>
     */
    private function messages(): array
    {
        return [
            'required' => 'این فیلد الزامی است.',
            'integer' => 'مقدار باید عدد صحیح باشد.',
            'numeric' => 'مقدار باید عدد باشد.',
            'min' => 'مقدار وارد شده کم است.',
            'max' => 'مقدار وارد شده زیاد است.',
            'in' => 'گزینه انتخاب‌شده معتبر نیست.',
        ];
    }
}
