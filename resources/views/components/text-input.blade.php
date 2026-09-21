@props(['disabled' => false, 'hasError' => false])

@php
    $stateClasses = $hasError
        ? 'border-red-400 text-slate-900 focus:border-red-500 focus:ring-red-500/20'
        : 'border-slate-200 focus:border-gym-500 focus:ring-gym-500/20';
@endphp

<input
    @disabled($disabled)
    @if ($hasError) aria-invalid="true" @endif
    {{ $attributes->merge(['class' => "rounded-lg border shadow-sm transition-colors {$stateClasses}"]) }}
>
