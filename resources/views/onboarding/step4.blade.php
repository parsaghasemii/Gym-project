<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="section-label">onboarding</p>
            <h2 class="mt-1 text-xl font-bold text-slate-900">اولویت عضلانی</h2>
        </div>
    </x-slot>

    <div class="page-content-narrow">
        <x-onboarding-progress :step="4" />

        <form method="POST" action="{{ route('onboarding.step4.store') }}" class="card space-y-5">
            @csrf

            <p class="text-sm text-slate-600">۱ تا ۳ گروه عضلانی که می‌خواهید بیشتر روی آن‌ها تمرکز کنید را انتخاب کنید.</p>

            <div class="grid gap-3 sm:grid-cols-2">
                @foreach ($muscleGroups as $group)
                    <label class="flex items-center gap-3 rounded-xl border border-slate-200 p-3 cursor-pointer hover:border-gym-300 has-[:checked]:border-gym-500 has-[:checked]:bg-gym-50">
                        <input type="checkbox" name="muscle_groups[]" value="{{ $group->id }}"
                            @checked(in_array($group->id, old('muscle_groups', $selected)))
                            class="rounded border-slate-300 text-gym-600 focus:ring-gym-500">
                        <span class="text-sm font-medium text-slate-800">{{ $group->name }}</span>
                    </label>
                @endforeach
            </div>
            <x-input-error :messages="$errors->get('muscle_groups')" class="mt-2" />
            <x-input-error :messages="$errors->get('muscle_groups.*')" class="mt-2" />

            <div class="flex gap-3 pt-2">
                <a href="{{ route('onboarding.step3') }}" class="btn-secondary flex-1 justify-center">قبلی</a>
                <x-primary-button class="flex-1 justify-center">ساخت برنامه</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
