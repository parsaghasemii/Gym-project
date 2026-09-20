<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            داشبورد
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <p>سلام {{ Auth::user()->name }}، خوش آمدید.</p>

                    @if (Auth::user()->isMember() && ! Auth::user()->onboarding_completed)
                        <div class="rounded-md border border-amber-200 bg-amber-50 p-4 text-amber-900">
                            <p class="font-medium">مرحله بعد: تکمیل onboarding</p>
                            <p class="mt-1 text-sm">
                                ویزارد چندمرحله‌ای onboarding به‌زودی اینجا قرار می‌گیرد تا بتوانید برنامه شخصی‌سازی‌شده دریافت کنید.
                            </p>
                        </div>
                    @else
                        <p>شما وارد حساب کاربری خود شده‌اید.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
