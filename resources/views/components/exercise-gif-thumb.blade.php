@props(['exercise'])

@if ($exercise->hasGif())
    <button
        type="button"
        x-data
        class="group relative flex h-12 w-12 shrink-0 overflow-hidden rounded-xl border-2 border-gym-300 bg-white shadow-sm ring-1 ring-gym-100 transition hover:border-gym-500 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-gym-500/50"
        aria-label="نمایش ویدیوی حرکت {{ $exercise->name }}"
        @click="$dispatch('open-exercise-gif', { name: @js($exercise->name), url: @js($exercise->gifUrl()) })"
    >
        @if ($exercise->isVideo())
            <video
                src="{{ $exercise->gifUrl() }}"
                poster="{{ $exercise->gifPosterUrl() }}"
                class="h-full w-full object-cover"
                autoplay
                loop
                muted
                playsinline
                aria-hidden="true"
            ></video>
        @else
            <img
                src="{{ $exercise->gifUrl() }}"
                alt=""
                class="h-full w-full object-cover"
                loading="lazy"
                aria-hidden="true"
            />
        @endif
        <span class="absolute inset-0 flex items-center justify-center bg-black/30 transition group-hover:bg-black/40">
            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-white/90 text-gym-700 shadow">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M8 5.14v13.72a1 1 0 0 0 1.5.86l11.04-6.86a1 1 0 0 0 0-1.72L9.5 4.28A1 1 0 0 0 8 5.14Z" />
                </svg>
            </span>
        </span>
    </button>
@endif
