<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="section-label">onboarding</p>
            <h2 class="mt-1 text-xl font-bold text-slate-900">اندازه‌های بدنی</h2>
        </div>
    </x-slot>

    <div class="page-content-narrow">
        <x-onboarding-progress :step="2" />

        <form method="POST" action="{{ route('onboarding.step2.store') }}" class="card space-y-5">
            @csrf

            <div>
                <x-input-label for="height" value="قد (سانتی‌متر)" />
                <x-text-input id="height" name="height" type="number" step="0.1" class="mt-1 block w-full" :value="old('height', $profile->height)" required />
                <x-input-error :messages="$errors->get('height')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="weight" value="وزن (کیلوگرم)" />
                <x-text-input id="weight" name="weight" type="number" step="0.1" class="mt-1 block w-full" :value="old('weight', $profile->weight)" required />
                <x-input-error :messages="$errors->get('weight')" class="mt-2" />
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('onboarding.step1') }}" class="btn-secondary flex-1 justify-center">قبلی</a>
                <x-primary-button class="flex-1 justify-center">مرحله بعد</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
