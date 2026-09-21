@php
    use App\Support\ValidationPresenter;
@endphp

<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-xl font-bold text-slate-900">ورود</h1>
        <p class="mt-1 text-sm text-slate-500">به حساب کاربری خود وارد شوید</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" value="ایمیل" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" :has-error="ValidationPresenter::hasError($errors, 'email')" required autofocus autocomplete="username" />
            <x-input-error field="email" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="رمز عبور" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" :has-error="ValidationPresenter::hasError($errors, 'password')" required autocomplete="current-password" />
            <x-input-error field="password" class="mt-2" />
        </div>

        <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-gym-600 shadow-sm focus:ring-gym-500" name="remember">
                <span class="ms-2 text-sm text-slate-600">مرا به خاطر بسپار</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-gym-600 hover:text-gym-700 sm:text-end" href="{{ route('password.request') }}">
                    فراموشی رمز؟
                </a>
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center !py-3">
                ورود
            </x-primary-button>
        </div>

        <p class="mt-4 text-center text-sm text-slate-500">
            حساب ندارید؟
            <a href="{{ route('register') }}" class="text-gym-600 hover:text-gym-700 font-medium">ثبت‌نام</a>
        </p>
    </form>
</x-guest-layout>
