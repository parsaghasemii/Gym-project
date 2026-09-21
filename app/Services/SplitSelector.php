<?php

namespace App\Services;

use App\Enums\SplitType;
use App\Models\MuscleGroup;
use App\Support\PersianDate;
use Illuminate\Support\Collection;

class SplitSelector
{
    /**
     * @param  Collection<int, MuscleGroup>  $focusGroups
     * @return list<array{day_name: string, focus_label: string, muscle_slugs: list<string>}>
     */
    public function buildDays(int $daysPerWeek, Collection $focusGroups): array
    {
        $focusSlugs = $focusGroups->pluck('slug')->all();
        $split = SplitType::forDaysPerWeek($daysPerWeek);

        return match ($split) {
            SplitType::FullBody => $this->fullBodyDays($daysPerWeek, $focusSlugs),
            SplitType::UpperLower => $this->upperLowerDays($focusSlugs),
            SplitType::PplFocus => $this->pplFocusDays($focusSlugs),
        };
    }

    /**
     * @param  list<string>  $focusSlugs
     * @return list<array{day_name: string, focus_label: string, muscle_slugs: list<string>}>
     */
    private function fullBodyDays(int $days, array $focusSlugs): array
    {
        $base = ['chest', 'back', 'legs', 'shoulders', 'arms', 'abs'];
        $emphasis = [...$focusSlugs, ...$focusSlugs];
        $prioritized = [...$emphasis, ...array_values(array_diff($base, $focusSlugs))];

        $daysList = [];
        for ($i = 1; $i <= $days; $i++) {
            $daysList[] = [
                'day_name' => 'روز '.PersianDate::toPersianDigits((string) $i).' — تمام بدن',
                'focus_label' => 'تمرین تمام بدن'.($focusSlugs ? ' (تاکید: '.implode('، ', $this->slugLabels($focusSlugs)).')' : ''),
                'muscle_slugs' => $prioritized,
            ];
        }

        return $daysList;
    }

    /**
     * @param  list<string>  $focusSlugs
     * @return list<array{day_name: string, focus_label: string, muscle_slugs: list<string>}>
     */
    private function upperLowerDays(array $focusSlugs): array
    {
        $upper = array_values(array_unique([...array_intersect($focusSlugs, ['chest', 'back', 'shoulders', 'arms', 'forearms']), 'chest', 'back', 'shoulders', 'arms']));
        $lower = array_values(array_unique([...array_intersect($focusSlugs, ['legs', 'abs']), 'legs', 'abs']));

        return [
            ['day_name' => 'روز ۱ — بالاتنه', 'focus_label' => 'تمرین بالاتنه', 'muscle_slugs' => $upper],
            ['day_name' => 'روز ۲ — پایین‌تنه', 'focus_label' => 'تمرین پایین‌تنه', 'muscle_slugs' => $lower],
            ['day_name' => 'روز ۳ — بالاتنه', 'focus_label' => 'تمرین بالاتنه', 'muscle_slugs' => $upper],
            ['day_name' => 'روز ۴ — پایین‌تنه', 'focus_label' => 'تمرین پایین‌تنه', 'muscle_slugs' => $lower],
        ];
    }

    /**
     * @param  list<string>  $focusSlugs
     * @return list<array{day_name: string, focus_label: string, muscle_slugs: list<string>}>
     */
    private function pplFocusDays(array $focusSlugs): array
    {
        $focusPrimary = $focusSlugs[0] ?? 'chest';
        $focusSecondary = $focusSlugs[1] ?? ($focusSlugs[0] ?? 'back');

        return [
            ['day_name' => 'روز ۱ — Push', 'focus_label' => 'سینه، شانه، بازو', 'muscle_slugs' => ['chest', 'shoulders', 'arms', 'abs']],
            ['day_name' => 'روز ۲ — Pull', 'focus_label' => 'پشت، بازو، ساعد', 'muscle_slugs' => ['back', 'arms', 'forearms', 'abs']],
            ['day_name' => 'روز ۳ — Legs', 'focus_label' => 'پا و شکم', 'muscle_slugs' => ['legs', 'abs']],
            ['day_name' => 'روز ۴ — تمرکز', 'focus_label' => 'تمرکز: '.$this->slugLabel($focusPrimary), 'muscle_slugs' => array_values(array_unique([$focusPrimary, 'abs']))],
            ['day_name' => 'روز ۵ — تمرکز', 'focus_label' => 'تمرکز: '.$this->slugLabel($focusSecondary), 'muscle_slugs' => array_values(array_unique([$focusSecondary, 'abs']))],
        ];
    }

    /**
     * @param  list<string>  $slugs
     * @return list<string>
     */
    private function slugLabels(array $slugs): array
    {
        return array_map(fn (string $slug) => $this->slugLabel($slug), $slugs);
    }

    private function slugLabel(string $slug): string
    {
        return match ($slug) {
            'chest' => 'سینه',
            'back' => 'پشت',
            'legs' => 'پا',
            'shoulders' => 'شانه',
            'arms' => 'بازو',
            'forearms' => 'ساعد',
            'abs' => 'شکم',
            default => $slug,
        };
    }
}
