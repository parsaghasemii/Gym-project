<?php

namespace App\Http\Controllers;

use App\Models\MuscleGroup;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FitnessProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $profile = UserProfile::query()->firstOrCreate(['user_id' => $request->user()->id]);
        $muscleGroups = MuscleGroup::query()
            ->whereIn('id', $request->user()->muscleFocus()->pluck('muscle_groups.id'))
            ->orderBy('name')
            ->get();

        return view('fitness-profile.edit', compact('profile', 'muscleGroups'));
    }
}
