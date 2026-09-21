<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramDay extends Model
{
    protected $fillable = [
        'program_id',
        'day_number',
        'day_name',
        'focus_label',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(ProgramDayExercise::class)->orderBy('sort_order');
    }

    public function meals(): HasMany
    {
        return $this->hasMany(ProgramDayMeal::class)->orderBy('sort_order');
    }
}
