<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use Illuminate\View\View;

class MealController extends Controller
{
    public function index(): View
    {
        $meals = Meal::query()->orderBy('name')->paginate(20);

        return view('admin.meals.index', compact('meals'));
    }
}
