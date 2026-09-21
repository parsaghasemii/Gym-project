<?php

namespace App\Support;

use DateTimeInterface;
use Illuminate\Support\Carbon;

class PersianDate
{
    /**
     * @return array{0: int, 1: int, 2: int}
     */
    public static function toJalali(int $year, int $month, int $day): array
    {
        $monthDays = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
        $jalaliYear = ($year <= 1600) ? 0 : 979;
        $year -= ($year <= 1600) ? 621 : 1600;
        $leapOffset = ($month > 2) ? ($year + 1) : $year;
        $days = (365 * $year)
            + intdiv($leapOffset + 3, 4)
            - intdiv($leapOffset + 99, 100)
            + intdiv($leapOffset + 399, 400)
            - 80
            + $day
            + $monthDays[$month - 1];
        $jalaliYear += 33 * intdiv($days, 12053);
        $days %= 12053;
        $jalaliYear += 4 * intdiv($days, 1461);
        $days %= 1461;
        $jalaliYear += intdiv($days - 1, 365);

        if ($days > 365) {
            $days = ($days - 1) % 365;
        }

        $jalaliMonth = ($days < 186) ? 1 + intdiv($days, 31) : 7 + intdiv($days - 186, 30);
        $jalaliDay = 1 + (($days < 186) ? ($days % 31) : (($days - 186) % 30));

        return [$jalaliYear, $jalaliMonth, $jalaliDay];
    }

    public static function format(DateTimeInterface|string|null $date, string $pattern = 'Y/m/d'): ?string
    {
        if ($date === null) {
            return null;
        }

        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        [$year, $month, $day] = self::toJalali(
            (int) $date->format('Y'),
            (int) $date->format('n'),
            (int) $date->format('j'),
        );

        $formatted = str_replace(
            ['Y', 'm', 'd'],
            [
                str_pad((string) $year, 4, '0', STR_PAD_LEFT),
                str_pad((string) $month, 2, '0', STR_PAD_LEFT),
                str_pad((string) $day, 2, '0', STR_PAD_LEFT),
            ],
            $pattern,
        );

        return self::toPersianDigits($formatted);
    }

    public static function range(DateTimeInterface|string|null $start, DateTimeInterface|string|null $end, string $separator = ' — '): ?string
    {
        $startFormatted = self::format($start);
        $endFormatted = self::format($end);

        if ($startFormatted === null || $endFormatted === null) {
            return null;
        }

        return $startFormatted.$separator.$endFormatted;
    }

    public static function toPersianDigits(string $value): string
    {
        return strtr($value, [
            '0' => '۰',
            '1' => '۱',
            '2' => '۲',
            '3' => '۳',
            '4' => '۴',
            '5' => '۵',
            '6' => '۶',
            '7' => '۷',
            '8' => '۸',
            '9' => '۹',
        ]);
    }
}
