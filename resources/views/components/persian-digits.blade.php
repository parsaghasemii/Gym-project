@php
    use App\Support\PersianDate;
@endphp

<span {{ $attributes->merge(['class' => 'tabular-nums']) }}>
    {{ PersianDate::toPersianDigits(trim($slot)) }}
</span>
