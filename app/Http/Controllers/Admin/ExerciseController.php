<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Difficulty;
use App\Enums\Equipment;
use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\MuscleGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExerciseController extends Controller
{
    public function index(): View
    {
        $exercises = Exercise::query()->with('muscleGroup')->orderBy('name')->paginate(20);

        return view('admin.exercises.index', compact('exercises'));
    }

    public function create(): View
    {
        $muscleGroups = MuscleGroup::query()->orderBy('name')->get();

        return view('admin.exercises.create', compact('muscleGroups'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateExercise($request);
        Exercise::query()->create($validated);

        return redirect()->route('admin.exercises.index')->with('status', 'حرکت اضافه شد.');
    }

    public function edit(Exercise $exercise): View
    {
        $muscleGroups = MuscleGroup::query()->orderBy('name')->get();

        return view('admin.exercises.edit', compact('exercise', 'muscleGroups'));
    }

    public function update(Request $request, Exercise $exercise): RedirectResponse
    {
        $exercise->update($this->validateExercise($request));

        return redirect()->route('admin.exercises.index')->with('status', 'حرکت به‌روزرسانی شد.');
    }

    public function destroy(Exercise $exercise): RedirectResponse
    {
        $exercise->delete();

        return redirect()->route('admin.exercises.index')->with('status', 'حرکت حذف شد.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateExercise(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'muscle_group_id' => ['required', 'exists:muscle_groups,id'],
            'equipment' => ['required', 'in:'.implode(',', array_column(Equipment::cases(), 'value'))],
            'difficulty' => ['required', 'in:'.implode(',', array_column(Difficulty::cases(), 'value'))],
            'default_sets' => ['required', 'integer', 'min:1', 'max:10'],
            'default_reps' => ['required', 'string', 'max:50'],
            'rest_seconds' => ['required', 'integer', 'min:30', 'max:300'],
        ], ['required' => 'این فیلد الزامی است.']);
    }
}
