<?php

namespace App\Models;

use App\Enums\Equipment;
use App\Enums\FitnessLevel;
use App\Enums\Gender;
use App\Enums\Goal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'age',
        'gender',
        'height',
        'weight',
        'fitness_level',
        'goal',
        'days_per_week',
        'equipment',
        'injuries',
    ];

    protected function casts(): array
    {
        return [
            'gender' => Gender::class,
            'height' => 'decimal:1',
            'weight' => 'decimal:1',
            'fitness_level' => FitnessLevel::class,
            'goal' => Goal::class,
            'equipment' => Equipment::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isComplete(): bool
    {
        return $this->age !== null
            && $this->gender !== null
            && $this->height !== null
            && $this->weight !== null
            && $this->fitness_level !== null
            && $this->goal !== null
            && $this->days_per_week !== null
            && $this->equipment !== null;
    }
}
