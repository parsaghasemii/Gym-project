@props([
    'variant' => 'mobile',
])

<x-confirm-toast
    message="از حساب کاربری خارج می‌شوید و برای دسترسی دوباره باید وارد شوید. ادامه می‌دهید؟"
    confirm-label="بله، خارج می‌شوم"
    form-id="logout-form"
    {{ $attributes->except('variant') }}
>
    <x-slot:trigger>
        @if ($variant === 'dropdown')
            <button
                type="button"
                x-on:click.stop="open = true; $dispatch('close-mobile-nav')"
                class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
            >
                خروج
            </button>
        @else
            <button
                type="button"
                x-on:click.stop="open = true; $dispatch('close-mobile-nav')"
                @class([
                    'site-mobile-nav-link w-full text-start' => $variant === 'mobile',
                    'underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gym-500' => $variant === 'link',
                ])
            >
                {{ $slot->isEmpty() ? 'خروج' : $slot }}
            </button>
        @endif
    </x-slot:trigger>
</x-confirm-toast>
