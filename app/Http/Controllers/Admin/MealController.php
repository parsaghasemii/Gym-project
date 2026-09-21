<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MealType;
use App\Http\Controllers\Controller;
use App\Models\Meal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MealController extends Controller
{
    public function index(): View
    {
        $meals = Meal::query()->orderBy('name')->paginate(20);

        return view('admin.meals.index', compact('meals'));
    }

    public function create(): View
    {
        return view('admin.meals.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Meal::query()->create($this->validateMeal($request));

        return redirect()->route('admin.meals.index')->with('status', 'وعده غذایی اضافه شد.');
    }

    public function edit(Meal $meal): View
    {
        return view('admin.meals.edit', compact('meal'));
    }

    public function update(Request $request, Meal $meal): RedirectResponse
    {
        $meal->update($this->validateMeal($request));

        return redirect()->route('admin.meals.index')->with('status', 'وعده غذایی به‌روزرسانی شد.');
    }

    public function destroy(Meal $meal): RedirectResponse
    {
        $meal->delete();

        return redirect()->route('admin.meals.index')->with('status', 'وعده غذایی حذف شد.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateMeal(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'meal_type' => ['required', 'in:'.implode(',', array_column(MealType::cases(), 'value'))],
            'calories' => ['required', 'integer', 'min:50', 'max:2000'],
            'protein' => ['required', 'integer', 'min:0', 'max:200'],
            'carbs' => ['required', 'integer', 'min:0', 'max:300'],
            'fat' => ['required', 'integer', 'min:0', 'max:200'],
            'description' => ['nullable', 'string', 'max:1000'],
        ], ['required' => 'این فیلد الزامی است.']);
    }
}
