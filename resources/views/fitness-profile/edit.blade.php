<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="section-label">پروفایل ورزشی</p>
            <h2 class="mt-1 text-xl font-bold text-slate-900">ویرایش اطلاعات بدنی و اهداف</h2>
        </div>
    </x-slot>

    <div class="page-content max-w-2xl">
        @if (session('status'))
            <div class="mb-4 rounded-xl border border-gym-200 bg-gym-50 px-4 py-3 text-sm text-gym-800">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('fitness-profile.update') }}" class="card space-y-5">
            @csrf
            @method('PATCH')

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <x-input-label for="age" value="سن" />
                    <x-text-input id="age" name="age" type="number" class="mt-1 block w-full" :value="old('age', $profile->age)" required />
                    <x-input-error :messages="$errors->get('age')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="gender" value="جنسیت" />
                    <select id="gender" name="gender" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-gym-500 focus:ring-gym-500" required>
                        @foreach (\App\Enums\Gender::cases() as $gender)
                            <option value="{{ $gender->value }}" @selected(old('gender', $profile->gender?->value) === $gender->value)>{{ $gender->label() }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
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
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <x-input-label for="fitness_level" value="سطح آمادگی" />
                    <select id="fitness_level" name="fitness_level" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-gym-500 focus:ring-gym-500" required>
                        @foreach (\App\Enums\FitnessLevel::cases() as $level)
                            <option value="{{ $level->value }}" @selected(old('fitness_level', $profile->fitness_level?->value) === $level->value)>{{ $level->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="goal" value="هدف" />
                    <select id="goal" name="goal" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-gym-500 focus:ring-gym-500" required>
                        @foreach (\App\Enums\Goal::cases() as $goal)
                            <option value="{{ $goal->value }}" @selected(old('goal', $profile->goal?->value) === $goal->value)>{{ $goal->label() }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <x-input-label for="days_per_week" value="روز تمرین در هفته" />
                    <select id="days_per_week" name="days_per_week" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-gym-500 focus:ring-gym-500" required>
                        @foreach ([3, 4, 5] as $days)
                            <option value="{{ $days }}" @selected(old('days_per_week', $profile->days_per_week) == $days)>{{ $days }} روز</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="equipment" value="تجهیزات" />
                    <select id="equipment" name="equipment" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-gym-500 focus:ring-gym-500" required>
                        @foreach (\App\Enums\Equipment::cases() as $equipment)
                            <option value="{{ $equipment->value }}" @selected(old('equipment', $profile->equipment?->value) === $equipment->value)>{{ $equipment->label() }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <x-input-label for="injuries" value="آسیب‌دیدگی (اختیاری)" />
                <textarea id="injuries" name="injuries" rows="3" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-gym-500 focus:ring-gym-500">{{ old('injuries', $profile->injuries) }}</textarea>
            </div>

            <div>
                <x-input-label value="اولویت عضلانی (۱ تا ۳)" />
                <div class="mt-3 grid gap-3 sm:grid-cols-2">
                    @foreach ($muscleGroups as $group)
                        <label class="flex items-center gap-3 rounded-xl border border-slate-200 p-3 cursor-pointer hover:border-gym-300 has-[:checked]:border-gym-500 has-[:checked]:bg-gym-50">
                            <input type="checkbox" name="muscle_groups[]" value="{{ $group->id }}"
                                @checked(in_array($group->id, old('muscle_groups', $selected)))
                                class="rounded border-slate-300 text-gym-600 focus:ring-gym-500">
                            <span class="text-sm font-medium">{{ $group->name }}</span>
                        </label>
                    @endforeach
                </div>
                <x-input-error :messages="$errors->get('muscle_groups')" class="mt-2" />
            </div>

            <x-primary-button>ذخیره تغییرات</x-primary-button>
        </form>

        @if (Auth::user()->activeProgram)
            <div class="mt-6 card">
                <p class="text-sm text-slate-600">بعد از ذخیره تغییرات، می‌توانید برنامه جدید بگیرید.</p>
                <form method="POST" action="{{ route('program.regenerate') }}" class="mt-4">
                    @csrf
                    <x-confirm-toast message="برنامه فعلی غیرفعال می‌شود و بر اساس پروفایل ذخیره‌شده، برنامه جدید ساخته می‌شود. ادامه می‌دهید؟">
                        <x-slot:trigger>
                            <button type="button" x-on:click="open = true" class="btn-secondary !text-sm">
                                دریافت برنامه جدید
                            </button>
                        </x-slot:trigger>
                    </x-confirm-toast>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
