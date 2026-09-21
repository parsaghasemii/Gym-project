@props(['active'])

@php
$classes = ($active ?? false)
            ? 'site-mobile-nav-link site-mobile-nav-link--active'
            : 'site-mobile-nav-link';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
