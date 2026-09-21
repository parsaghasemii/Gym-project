<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramDayMeal extends Model
{
    protected $fillable = [
        'program_day_id',
        'meal_id',
        'sort_order',
    ];

    public function programDay(): BelongsTo
    {
        return $this->belongsTo(ProgramDay::class);
    }

    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }
}
