<div
    x-data="{ open: false, name: '', url: '' }"
    x-on:open-exercise-gif.window="open = true; name = $event.detail.name; url = $event.detail.url"
    x-on:keydown.escape.window="open = false"
    x-init="$watch('open', value => document.body.classList.toggle('overflow-hidden', value))"
    x-show="open"
    x-cloak
    class="exercise-gif-lightbox fixed inset-0 z-50"
    style="display: none;"
>
    <div
        x-show="open"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="exercise-gif-lightbox__backdrop fixed inset-0"
        x-on:click="open = false"
    ></div>

    <button
        type="button"
        x-show="open"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="exercise-gif-lightbox__close-bar"
        aria-label="بستن"
        x-on:click="open = false"
    >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
            <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18" />
        </svg>
        <span>بستن</span>
    </button>

    <div
        x-show="open"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="pointer-events-none relative z-10 flex min-h-full items-center justify-center p-4 pt-20 sm:pt-24"
        role="dialog"
        aria-modal="true"
        :aria-label="name"
    >
        <div class="pointer-events-auto w-full max-w-3xl text-center">
            <p class="mb-4 text-lg font-semibold text-white sm:text-xl" x-text="name"></p>

            <video
                x-show="url.endsWith('.mp4')"
                x-bind:src="url.endsWith('.mp4') ? url : ''"
                class="mx-auto max-h-[70vh] w-full rounded-2xl bg-black object-contain shadow-2xl"
                autoplay
                loop
                playsinline
                controls
                x-bind:aria-label="name"
            ></video>

            <img
                x-show="! url.endsWith('.mp4')"
                x-bind:src="! url.endsWith('.mp4') ? url : ''"
                x-bind:alt="name"
                class="mx-auto max-h-[70vh] w-full rounded-2xl object-contain shadow-2xl"
            >

            <p class="mt-4 text-sm text-white/70">برای بستن، دکمه بالا یا بیرون کادر را لمس کنید</p>
        </div>
    </div>
</div>
