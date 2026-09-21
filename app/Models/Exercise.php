<?php

namespace App\Models;

use App\Enums\Difficulty;
use App\Enums\Equipment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exercise extends Model
{
    protected $fillable = [
        'name',
        'muscle_group_id',
        'equipment',
        'difficulty',
        'default_sets',
        'default_reps',
        'rest_seconds',
    ];

    protected function casts(): array
    {
        return [
            'equipment' => Equipment::class,
            'difficulty' => Difficulty::class,
        ];
    }

    public function muscleGroup(): BelongsTo
    {
        return $this->belongsTo(MuscleGroup::class);
    }
}
