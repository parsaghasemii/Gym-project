<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->isMember() && ! $user->onboarding_completed) {
            return redirect()->route('onboarding.step1');
        }

        $program = $user->activeProgram;
        $program?->load('nutrition');
        $profile = $user->profile;

        return view('dashboard', compact('program', 'profile'));
    }
}
