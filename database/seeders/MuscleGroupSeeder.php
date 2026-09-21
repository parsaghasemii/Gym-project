<?php

namespace Database\Seeders;

use App\Models\MuscleGroup;
use Illuminate\Database\Seeder;

class MuscleGroupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            ['name' => 'سینه', 'slug' => 'chest'],
            ['name' => 'پشت', 'slug' => 'back'],
            ['name' => 'پا', 'slug' => 'legs'],
            ['name' => 'شانه', 'slug' => 'shoulders'],
            ['name' => 'بازو', 'slug' => 'arms'],
            ['name' => 'ساعد', 'slug' => 'forearms'],
            ['name' => 'شکم', 'slug' => 'abs'],
        ];

        foreach ($groups as $group) {
            MuscleGroup::query()->updateOrCreate(['slug' => $group['slug']], $group);
        }
    }
}
