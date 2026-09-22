<?php

namespace Database\Seeders;

use App\Enums\Difficulty;
use App\Enums\Equipment;
use App\Models\Exercise;
use App\Models\MuscleGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ExerciseSeeder extends Seeder
{
    /** @var array<string, array<string, mixed>>|null */
    private ?array $fedbExercises = null;

    public function run(): void
    {
        $groups = MuscleGroup::query()->pluck('id', 'slug');
        /** @var array<string, array{type: string, name?: string, id?: string}> $mediaSources */
        $mediaSources = require database_path('seeders/data/exercise-media-sources.php');

        $exercises = [
            // Chest
            ['name' => 'پرس سینه هالتر', 'muscle_group_id' => $groups['chest'], 'equipment' => Equipment::FullGym, 'difficulty' => Difficulty::Intermediate, 'default_sets' => 4, 'default_reps' => '8-10', 'rest_seconds' => 120],
            ['name' => 'پرس سینه دمبل', 'muscle_group_id' => $groups['chest'], 'equipment' => Equipment::Home, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '10-12', 'rest_seconds' => 90],
            ['name' => 'شنا سوئدی', 'muscle_group_id' => $groups['chest'], 'equipment' => Equipment::Bodyweight, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '8-15', 'rest_seconds' => 60],
            ['name' => 'فلای سینه', 'muscle_group_id' => $groups['chest'], 'equipment' => Equipment::FullGym, 'difficulty' => Difficulty::Intermediate, 'default_sets' => 3, 'default_reps' => '12-15', 'rest_seconds' => 60],
            ['name' => 'پوش‌آپ شیب‌دار', 'muscle_group_id' => $groups['chest'], 'equipment' => Equipment::Bodyweight, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '10-15', 'rest_seconds' => 60],

            // Back
            ['name' => 'ددلیفت رومانیایی', 'muscle_group_id' => $groups['back'], 'equipment' => Equipment::FullGym, 'difficulty' => Difficulty::Intermediate, 'default_sets' => 4, 'default_reps' => '8-10', 'rest_seconds' => 120],
            ['name' => 'بارفیکس', 'muscle_group_id' => $groups['back'], 'equipment' => Equipment::Bodyweight, 'difficulty' => Difficulty::Intermediate, 'default_sets' => 3, 'default_reps' => '6-10', 'rest_seconds' => 90],
            ['name' => 'پول‌آپ دمبل', 'muscle_group_id' => $groups['back'], 'equipment' => Equipment::Home, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '10-12', 'rest_seconds' => 90],
            ['name' => 'زیربغل سیم‌کش', 'muscle_group_id' => $groups['back'], 'equipment' => Equipment::FullGym, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '10-12', 'rest_seconds' => 90],
            ['name' => 'سوپرمن', 'muscle_group_id' => $groups['back'], 'equipment' => Equipment::Bodyweight, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '12-15', 'rest_seconds' => 60],

            // Legs
            ['name' => 'اسکوات هالتر', 'muscle_group_id' => $groups['legs'], 'equipment' => Equipment::FullGym, 'difficulty' => Difficulty::Intermediate, 'default_sets' => 4, 'default_reps' => '8-10', 'rest_seconds' => 120],
            ['name' => 'اسکوات گوبلت', 'muscle_group_id' => $groups['legs'], 'equipment' => Equipment::Home, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '10-12', 'rest_seconds' => 90],
            ['name' => 'لانج', 'muscle_group_id' => $groups['legs'], 'equipment' => Equipment::Bodyweight, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '10-12', 'rest_seconds' => 60],
            ['name' => 'پرس پا', 'muscle_group_id' => $groups['legs'], 'equipment' => Equipment::FullGym, 'difficulty' => Difficulty::Beginner, 'default_sets' => 4, 'default_reps' => '10-12', 'rest_seconds' => 90],
            ['name' => 'پل باسن', 'muscle_group_id' => $groups['legs'], 'equipment' => Equipment::Bodyweight, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '12-15', 'rest_seconds' => 60],
            ['name' => 'رومانیایی دمبل', 'muscle_group_id' => $groups['legs'], 'equipment' => Equipment::Home, 'difficulty' => Difficulty::Intermediate, 'default_sets' => 3, 'default_reps' => '10-12', 'rest_seconds' => 90],

            // Shoulders
            ['name' => 'پرس سرشانه هالتر', 'muscle_group_id' => $groups['shoulders'], 'equipment' => Equipment::FullGym, 'difficulty' => Difficulty::Intermediate, 'default_sets' => 4, 'default_reps' => '8-10', 'rest_seconds' => 90],
            ['name' => 'پرس سرشانه دمبل', 'muscle_group_id' => $groups['shoulders'], 'equipment' => Equipment::Home, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '10-12', 'rest_seconds' => 90],
            ['name' => 'نشر جانب دمبل', 'muscle_group_id' => $groups['shoulders'], 'equipment' => Equipment::Home, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '12-15', 'rest_seconds' => 60],
            ['name' => 'پاگودا', 'muscle_group_id' => $groups['shoulders'], 'equipment' => Equipment::Bodyweight, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '10-15', 'rest_seconds' => 60],
            ['name' => 'کشش رو به رو', 'muscle_group_id' => $groups['shoulders'], 'equipment' => Equipment::FullGym, 'difficulty' => Difficulty::Intermediate, 'default_sets' => 3, 'default_reps' => '12-15', 'rest_seconds' => 60],

            // Arms
            ['name' => 'جلو بازو هالتر', 'muscle_group_id' => $groups['arms'], 'equipment' => Equipment::FullGym, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '10-12', 'rest_seconds' => 60],
            ['name' => 'جلو بازو دمبل', 'muscle_group_id' => $groups['arms'], 'equipment' => Equipment::Home, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '10-12', 'rest_seconds' => 60],
            ['name' => 'پشت بازو سیم‌کش', 'muscle_group_id' => $groups['arms'], 'equipment' => Equipment::FullGym, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '12-15', 'rest_seconds' => 60],
            ['name' => 'پشت بازو دمبل', 'muscle_group_id' => $groups['arms'], 'equipment' => Equipment::Home, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '10-12', 'rest_seconds' => 60],
            ['name' => 'دیپ', 'muscle_group_id' => $groups['arms'], 'equipment' => Equipment::Bodyweight, 'difficulty' => Difficulty::Intermediate, 'default_sets' => 3, 'default_reps' => '8-12', 'rest_seconds' => 90],

            // Forearms
            ['name' => 'کرل مچ هالتر', 'muscle_group_id' => $groups['forearms'], 'equipment' => Equipment::FullGym, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '12-15', 'rest_seconds' => 60],
            ['name' => 'کرل معکوس دمبل', 'muscle_group_id' => $groups['forearms'], 'equipment' => Equipment::Home, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '12-15', 'rest_seconds' => 60],
            ['name' => 'آویز مچ', 'muscle_group_id' => $groups['forearms'], 'equipment' => Equipment::Bodyweight, 'difficulty' => Difficulty::Intermediate, 'default_sets' => 3, 'default_reps' => '30-45 ثانیه', 'rest_seconds' => 60],

            // Abs
            ['name' => 'کرانچ', 'muscle_group_id' => $groups['abs'], 'equipment' => Equipment::Bodyweight, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '15-20', 'rest_seconds' => 45],
            ['name' => 'پلانک', 'muscle_group_id' => $groups['abs'], 'equipment' => Equipment::Bodyweight, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '30-60 ثانیه', 'rest_seconds' => 45],
            ['name' => 'پایه دوچرخه', 'muscle_group_id' => $groups['abs'], 'equipment' => Equipment::Bodyweight, 'difficulty' => Difficulty::Beginner, 'default_sets' => 3, 'default_reps' => '15-20', 'rest_seconds' => 45],
            ['name' => 'بالا آوردن پا', 'muscle_group_id' => $groups['abs'], 'equipment' => Equipment::Bodyweight, 'difficulty' => Difficulty::Intermediate, 'default_sets' => 3, 'default_reps' => '10-15', 'rest_seconds' => 60],
            ['name' => 'کرنچ کابل', 'muscle_group_id' => $groups['abs'], 'equipment' => Equipment::FullGym, 'difficulty' => Difficulty::Intermediate, 'default_sets' => 3, 'default_reps' => '12-15', 'rest_seconds' => 60],
        ];

        foreach ($exercises as $exercise) {
            $mediaPath = isset($mediaSources[$exercise['name']])
                ? $this->publishExerciseMedia($mediaSources[$exercise['name']])
                : null;

            Exercise::query()->updateOrCreate(
                ['name' => $exercise['name']],
                [
                    ...$exercise,
                    'equipment' => $exercise['equipment']->value,
                    'difficulty' => $exercise['difficulty']->value,
                    'gif_path' => $mediaPath,
                ],
            );
        }
    }

    /**
     * @param  array{type: string, name?: string, id?: string}  $source
     */
    private function publishExerciseMedia(array $source): ?string
    {
        return match ($source['type']) {
            'fedb' => $this->publishFedbVideo($source['name'] ?? ''),
            'exercisedb' => $this->publishExerciseGif($source['id'] ?? ''),
            default => null,
        };
    }

    private function publishFedbVideo(string $exerciseName): ?string
    {
        $fedbExercise = $this->findFedbExercise($exerciseName);

        if ($fedbExercise === null) {
            return null;
        }

        $gender = isset($fedbExercise['videos']['male']) ? 'male' : 'female';
        $videoUrl = $fedbExercise['videos'][$gender] ?? null;

        if ($videoUrl === null) {
            return null;
        }

        $filename = basename(parse_url($videoUrl, PHP_URL_PATH) ?: '');
        $storagePath = "exercises/{$gender}/{$filename}";

        if (Storage::disk('public')->exists($storagePath)) {
            return $storagePath;
        }

        $response = Http::withUserAgent('GymApp/1.0 (local seed)')
            ->timeout(120)
            ->get($videoUrl);

        if (! $response->successful()) {
            return null;
        }

        Storage::disk('public')->put($storagePath, $response->body());

        return $storagePath;
    }

    private function publishExerciseGif(string $exerciseId): ?string
    {
        if ($exerciseId === '') {
            return null;
        }

        $assetPath = database_path("seeders/assets/exercises/{$exerciseId}.gif");

        if (! file_exists($assetPath)) {
            $response = Http::withUserAgent('GymApp/1.0 (local seed)')
                ->timeout(60)
                ->get("https://static.exercisedb.dev/media/{$exerciseId}.gif");

            if (! $response->successful()) {
                return null;
            }

            $storagePath = "exercises/{$exerciseId}.gif";
            Storage::disk('public')->put($storagePath, $response->body());

            return $storagePath;
        }

        $storagePath = "exercises/{$exerciseId}.gif";
        Storage::disk('public')->put($storagePath, file_get_contents($assetPath));

        return $storagePath;
    }

    /**
     * @return array<string, mixed>|null
     */
    private function findFedbExercise(string $exerciseName): ?array
    {
        foreach ($this->fedbCatalogue() as $exercise) {
            if (($exercise['name'] ?? null) === $exerciseName) {
                return $exercise;
            }
        }

        return null;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function fedbCatalogue(): array
    {
        if ($this->fedbExercises !== null) {
            return $this->fedbExercises;
        }

        $cataloguePath = database_path('seeders/data/fedb-exercises.json');

        if (! file_exists($cataloguePath)) {
            $response = Http::withUserAgent('GymApp/1.0 (local seed)')
                ->timeout(60)
                ->get('https://raw.githubusercontent.com/harshvishu/free-exercise-db-with-videos/main/data/exercises.json');

            if (! $response->successful()) {
                $this->fedbExercises = [];

                return $this->fedbExercises;
            }

            file_put_contents($cataloguePath, $response->body());
        }

        /** @var array<int, array<string, mixed>> $catalogue */
        $catalogue = json_decode(file_get_contents($cataloguePath), true) ?? [];
        $this->fedbExercises = $catalogue;

        return $this->fedbExercises;
    }
}
