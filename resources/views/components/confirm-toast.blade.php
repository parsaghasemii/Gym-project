@props([
    'message',
    'confirmLabel' => 'ادامه',
    'cancelLabel' => 'انصراف',
    'formId' => null,
])

<div
    x-data="{
        open: false,
        bodyWasLocked: false,
        formElement: null,
        init() {
            const formId = @js($formId);
            this.formElement = formId
                ? document.getElementById(formId)
                : this.$el.closest('form');
        },
        confirm() {
            this.formElement?.submit();
            this.open = false;
        },
        setBodyScroll(locked) {
            if (locked) {
                this.bodyWasLocked = document.body.classList.contains('overflow-hidden');
                document.body.classList.add('overflow-hidden');
                return;
            }

            if (! this.bodyWasLocked) {
                document.body.classList.remove('overflow-hidden');
            }
        },
    }"
    x-effect="setBodyScroll(open)"
    x-on:keydown.escape.window="open = false"
    {{ $attributes }}
>
    {{ $trigger }}

    <template x-teleport="body">
        <div
            x-show="open"
            x-cloak
            class="confirm-toast fixed inset-0 z-[110] flex items-end justify-center p-4 pb-[calc(1rem+env(safe-area-inset-bottom,0px))] sm:items-center sm:p-6"
            role="alertdialog"
            aria-modal="true"
            :aria-label="@js($message)"
        >
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="confirm-toast__backdrop absolute inset-0"
                x-on:click="open = false"
                aria-hidden="true"
            ></div>

            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-4 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-4 sm:scale-95"
                class="confirm-toast__panel relative w-full max-w-md"
            >
                <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-gym sm:p-6">
                    <div class="flex items-start gap-3">
                        <span class="confirm-toast__icon flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gym-50 text-gym-600">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86 2.82 17.05a2 2 0 0 0 1.71 3h14.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                            </svg>
                        </span>
                        <p class="confirm-toast__message pt-1.5 text-base leading-7 text-slate-700">{{ $message }}</p>
                    </div>

                    <div class="mt-5 flex flex-col gap-2.5 sm:flex-row-reverse sm:justify-start">
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
                            class="btn-secondary !px-5 !py-2.5 !text-sm w-full sm:w-auto justify-center"
                        >
                            {{ $cancelLabel }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
