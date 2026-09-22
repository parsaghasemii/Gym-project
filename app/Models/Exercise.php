<?php

namespace App\Models;

use App\Enums\Difficulty;
use App\Enums\Equipment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

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
        'gif_path',
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

    public function hasGif(): bool
    {
        if (! filled($this->gif_path)) {
            return false;
        }

        return Storage::disk('public')->exists($this->gif_path);
    }

    public function isVideo(): bool
    {
        return str_ends_with(strtolower($this->gif_path ?? ''), '.mp4');
    }

    public function gifUrl(): ?string
    {
        if ($this->gif_path === null) {
            return null;
        }

        return Storage::disk('public')->url($this->gif_path);
    }

    public function gifPosterUrl(): ?string
    {
        if (! $this->isVideo()) {
            return $this->gifUrl();
        }

        if (preg_match('#exercises/(male|female)/([^/]+)\.mp4$#', $this->gif_path, $matches)) {
            $filename = pathinfo($matches[2], PATHINFO_FILENAME);

            return "https://pub-585d42eb1aa64a67aedf483ec328d3fe.r2.dev/exercise-posters/{$matches[1]}/{$filename}.jpg";
        }

        $filename = pathinfo($this->gif_path, PATHINFO_FILENAME);

        return "https://pub-585d42eb1aa64a67aedf483ec328d3fe.r2.dev/exercise-posters/male/{$filename}.jpg";
    }
}
