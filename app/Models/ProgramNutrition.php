<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramNutrition extends Model
{
    protected $table = 'program_nutrition';

    protected $fillable = [
        'program_id',
        'daily_calories',
        'protein',
        'carbs',
        'fat',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
