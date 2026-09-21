<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="section-label">onboarding</p>
            <h2 class="mt-1 text-xl font-bold text-slate-900">اهداف و تمرین</h2>
        </div>
    </x-slot>

    <div class="page-content-narrow">
        <x-onboarding-progress :step="3" />

        <form method="POST" action="{{ route('onboarding.step3.store') }}" class="card space-y-5">
            @csrf

            <div>
                <x-input-label for="fitness_level" value="سطح آمادگی" />
                <select id="fitness_level" name="fitness_level" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-gym-500 focus:ring-gym-500" required>
                    <option value="">انتخاب کنید</option>
                    @foreach (\App\Enums\FitnessLevel::cases() as $level)
                        <option value="{{ $level->value }}" @selected(old('fitness_level', $profile->fitness_level?->value) === $level->value)>{{ $level->label() }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('fitness_level')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="goal" value="هدف" />
                <select id="goal" name="goal" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-gym-500 focus:ring-gym-500" required>
                    <option value="">انتخاب کنید</option>
                    @foreach (\App\Enums\Goal::cases() as $goal)
                        <option value="{{ $goal->value }}" @selected(old('goal', $profile->goal?->value) === $goal->value)>{{ $goal->label() }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('goal')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="days_per_week" value="روز تمرین در هفته" />
                <select id="days_per_week" name="days_per_week" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-gym-500 focus:ring-gym-500" required>
                    <option value="">انتخاب کنید</option>
                    @foreach ([3, 4, 5] as $days)
                        <option value="{{ $days }}" @selected(old('days_per_week', $profile->days_per_week) == $days)>{{ $days }} روز</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('days_per_week')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="equipment" value="تجهیزات در دسترس" />
                <select id="equipment" name="equipment" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-gym-500 focus:ring-gym-500" required>
                    <option value="">انتخاب کنید</option>
                    @foreach (\App\Enums\Equipment::cases() as $equipment)
                        <option value="{{ $equipment->value }}" @selected(old('equipment', $profile->equipment?->value) === $equipment->value)>{{ $equipment->label() }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('equipment')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="injuries" value="آسیب‌دیدگی یا محدودیت (اختیاری)" />
                <textarea id="injuries" name="injuries" rows="3" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-gym-500 focus:ring-gym-500">{{ old('injuries', $profile->injuries) }}</textarea>
                <x-input-error :messages="$errors->get('injuries')" class="mt-2" />
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('onboarding.step2') }}" class="btn-secondary flex-1 justify-center">قبلی</a>
                <x-primary-button class="flex-1 justify-center">مرحله بعد</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
