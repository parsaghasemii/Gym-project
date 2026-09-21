<?php

namespace App\Models;

use App\Enums\MealType;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = [
        'name',
        'meal_type',
        'calories',
        'protein',
        'carbs',
        'fat',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'meal_type' => MealType::class,
        ];
    }
}
