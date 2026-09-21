<?php

namespace App\Models;

use App\Enums\ProgramStatus;
use App\Enums\SplitType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Program extends Model
{
    protected $fillable = [
        'user_id',
        'starts_at',
        'ends_at',
        'status',
        'split_type',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'date',
            'ends_at' => 'date',
            'status' => ProgramStatus::class,
            'split_type' => SplitType::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function days(): HasMany
    {
        return $this->hasMany(ProgramDay::class)->orderBy('day_number');
    }

    public function nutrition(): HasOne
    {
        return $this->hasOne(ProgramNutrition::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', ProgramStatus::Active);
    }
}
