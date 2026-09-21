@props([
    'message',
    'confirmLabel' => 'ادامه',
    'cancelLabel' => 'انصراف',
])

<div
    x-data="{ open: false, confirm() { open = false; $el.closest('form')?.requestSubmit(); } }"
    x-on:keydown.escape.window="open = false"
    {{ $attributes }}
>
    {{ $trigger }}

    <div
        x-cloak
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-3"
        class="fixed inset-x-4 z-50 mx-auto max-w-md bottom-[calc(5.5rem+env(safe-area-inset-bottom,0px))] sm:inset-x-auto sm:start-6 sm:bottom-[calc(6rem+env(safe-area-inset-bottom,0px))]"
        role="alertdialog"
        aria-modal="true"
        :aria-label="@js($message)"
    >
        <div class="rounded-2xl border border-slate-200/80 bg-white/95 p-5 shadow-card backdrop-blur-sm sm:p-6">
            <p class="text-base leading-7 text-slate-700">{{ $message }}</p>
            <div class="mt-5 flex flex-col-reverse gap-2.5 sm:flex-row sm:items-center">
                <button
                    type="button"
                    x-on:click="confirm()"
                    class="btn-primary !px-5 !py-2.5 !text-sm w-full sm:w-auto justify-center"
                >
                    {{ $confirmLabel }}
                </button>
                <button
                    type="button"
                    x-on:click="open = false"
                    class="btn-ghost !px-5 !py-2.5 !text-sm text-slate-600 w-full sm:w-auto justify-center"
                >
                    {{ $cancelLabel }}
                </button>
            </div>
        </div>
    </div>
</div>
