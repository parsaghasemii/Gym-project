<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="section-label">onboarding</p>
            <h2 class="mt-1 text-xl font-bold text-slate-900">اطلاعات شخصی</h2>
        </div>
    </x-slot>

    <div class="page-content-narrow">
        @if (session('status'))
            <div class="mb-4 rounded-xl border border-gym-200 bg-gym-50 px-4 py-3 text-sm text-gym-800">
                {{ session('status') }}
            </div>
        @endif

        <x-onboarding-progress :step="1" />

        <form method="POST" action="{{ route('onboarding.step1.store') }}" class="card space-y-5">
            @csrf

            <div>
                <x-input-label for="age" value="سن" />
                <x-text-input id="age" name="age" type="number" class="mt-1 block w-full" :value="old('age', $profile->age)" required />
                <x-input-error :messages="$errors->get('age')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="gender" value="جنسیت" />
                <select id="gender" name="gender" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-gym-500 focus:ring-gym-500" required>
                    <option value="">انتخاب کنید</option>
                    @foreach (\App\Enums\Gender::cases() as $gender)
                        <option value="{{ $gender->value }}" @selected(old('gender', $profile->gender?->value) === $gender->value)>{{ $gender->label() }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>

            <div class="pt-2">
                <x-primary-button class="w-full justify-center">مرحله بعد</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
