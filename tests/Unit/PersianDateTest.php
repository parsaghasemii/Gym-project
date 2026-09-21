<?php

namespace Tests\Unit;

use App\Support\PersianDate;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;

class PersianDateTest extends TestCase
{
    public function test_converts_gregorian_date_to_jalali_with_persian_digits(): void
    {
        $formatted = PersianDate::format(Carbon::create(2026, 3, 20));

        $this->assertSame('۱۴۰۴/۱۲/۲۹', $formatted);
    }

    public function test_formats_date_range(): void
    {
        $range = PersianDate::range(
            Carbon::create(2026, 3, 20),
            Carbon::create(2026, 4, 17),
        );

        $this->assertSame('۱۴۰۴/۱۲/۲۹ — ۱۴۰۵/۰۱/۲۸', $range);
    }
}
