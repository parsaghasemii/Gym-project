@props([
    'date' => null,
    'end' => null,
    'format' => 'Y/m/d',
    'separator' => ' — ',
])

@php
    use App\Support\PersianDate;

    $formatted = $end
        ? PersianDate::range($date, $end, $separator)
        : PersianDate::format($date, $format);
@endphp

@if ($formatted)
    <span {{ $attributes->merge(['class' => 'tabular-nums']) }}>{{ $formatted }}</span>
@endif
