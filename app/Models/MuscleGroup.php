<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MuscleGroup extends Model
{
    protected $fillable = ['name', 'slug'];

    public function exercises(): HasMany
    {
        return $this->hasMany(Exercise::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_muscle_focus');
    }
}
