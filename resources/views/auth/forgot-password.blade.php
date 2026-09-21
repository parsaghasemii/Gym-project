<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-xl font-bold text-slate-900">فراموشی رمز عبور</h1>
        <p class="mt-2 text-sm text-slate-500">ایمیل خود را وارد کنید تا لینک بازیابی ارسال شود.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="email" value="ایمیل" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-6 flex flex-col gap-3">
            <x-primary-button class="w-full justify-center !py-3">
                ارسال لینک
            </x-primary-button>
            <a href="{{ route('login') }}" class="text-center text-sm text-gym-600 hover:text-gym-700">بازگشت به ورود</a>
        </div>
    </form>
</x-guest-layout>
