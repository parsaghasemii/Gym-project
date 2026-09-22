<?php

namespace App\Http\Controllers;

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

    public function regenerate(Request $request): RedirectResponse
    {
        $user = $request->user();

        $user->programs()->delete();
        $user->update(['onboarding_completed' => false]);

        return redirect()
            ->route('onboarding.step1')
            ->with('status', 'برنامه قبلی حذف شد. مراحل ساخت برنامه جدید را از اول تکمیل کنید.');
    }
}
