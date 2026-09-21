<section>
    <header>
        <h2 class="text-lg font-semibold text-slate-900">
            اطلاعات شخصی
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            نام و ایمیل حساب کاربری خود را به‌روز کنید.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="نام" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="ایمیل" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <div>
                    <p class="text-sm mt-2 text-slate-700">
                        ایمیل شما تأیید نشده است.
                        <button form="send-verification" class="underline text-sm text-gym-600 hover:text-gym-700">
                            ارسال مجدد لینک تأیید
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-gym-600">
                            لینک تأیید جدید ارسال شد.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button>ذخیره</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gym-600"
                >ذخیره شد.</p>
            @endif
        </div>
    </form>
</section>
