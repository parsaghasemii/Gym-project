@props(['showText' => true])

<a {{ $attributes->merge(['href' => route('home'), 'class' => 'inline-flex items-center gap-2.5 group']) }}>
    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gym-600 text-white shadow-gym transition group-hover:bg-gym-500">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M6.5 6.5h11"/>
            <path d="M6.5 17.5h11"/>
            <rect x="2" y="4" width="4.5" height="16" rx="1.5"/>
            <rect x="17.5" y="4" width="4.5" height="16" rx="1.5"/>
        </svg>
    </span>
    @if ($showText)
        <span class="text-lg font-bold text-slate-900 group-hover:text-gym-700 transition">
            {{ config('app.name') }}
        </span>
    @endif
</a>
