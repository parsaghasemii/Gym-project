<?php

namespace Database\Seeders;

use App\Enums\Difficulty;
use App\Enums\Equipment;
use App\Models\Exercise;
use App\Models\MuscleGroup;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    public function run(): void
    {
        $groups = MuscleGroup::query()->pluck('id', 'slug');

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
            Exercise::query()->updateOrCreate(
                ['name' => $exercise['name']],
                [
                    ...$exercise,
                    'equipment' => $exercise['equipment']->value,
                    'difficulty' => $exercise['difficulty']->value,
                ],
            );
        }
    }
}
