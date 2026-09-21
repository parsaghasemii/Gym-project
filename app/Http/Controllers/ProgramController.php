<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Services\ProgramGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        $program = $request->user()->activeProgram;

        if ($program === null) {
            return redirect()->route('dashboard');
        }

        $program->load([
            'days.exercises.exercise.muscleGroup',
            'days.meals.meal',
            'nutrition',
        ]);

        return view('program.show', compact('program'));
    }

    public function regenerate(Request $request, ProgramGenerator $generator): RedirectResponse
    {
        $user = $request->user()->load(['profile', 'muscleFocus']);

        if ($user->profile === null || ! $user->profile->isComplete() || $user->muscleFocus->isEmpty()) {
            return redirect()
                ->route('fitness-profile.edit')
                ->with('error', 'برای ساخت برنامه جدید، ابتدا پروفایل ورزشی را کامل کنید.');
        }

        try {
            $generator->generate($user);
        } catch (\InvalidArgumentException) {
            return redirect()
                ->route('fitness-profile.edit')
                ->with('error', 'اطلاعات پروفایل کافی نیست. لطفاً همه فیلدها را تکمیل کنید.');
        }

        return redirect()
            ->route('program.show')
            ->with('status', 'برنامه جدید بر اساس پروفایل فعلی‌تان ساخته شد.');
    }
}
