@props(['exercise' => null, 'muscleGroups'])

<div class="space-y-4">
    <div>
        <x-input-label for="name" value="نام حرکت" />
        <x-text-input id="name" name="name" class="mt-1 block w-full" :value="old('name', $exercise?->name)" required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="muscle_group_id" value="گروه عضلانی" />
        <select id="muscle_group_id" name="muscle_group_id" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-gym-500 focus:ring-gym-500" required>
            @foreach ($muscleGroups as $group)
                <option value="{{ $group->id }}" @selected(old('muscle_group_id', $exercise?->muscle_group_id) == $group->id)>{{ $group->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <x-input-label for="equipment" value="تجهیزات" />
            <select id="equipment" name="equipment" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-gym-500 focus:ring-gym-500" required>
                @foreach (\App\Enums\Equipment::cases() as $equipment)
                    <option value="{{ $equipment->value }}" @selected(old('equipment', $exercise?->equipment?->value) === $equipment->value)>{{ $equipment->label() }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <x-input-label for="difficulty" value="سطح" />
            <select id="difficulty" name="difficulty" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-gym-500 focus:ring-gym-500" required>
                @foreach (\App\Enums\Difficulty::cases() as $difficulty)
                    <option value="{{ $difficulty->value }}" @selected(old('difficulty', $exercise?->difficulty?->value) === $difficulty->value)>{{ $difficulty->label() }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <div>
            <x-input-label for="default_sets" value="ست پیش‌فرض" />
            <x-text-input id="default_sets" name="default_sets" type="number" class="mt-1 block w-full" :value="old('default_sets', $exercise?->default_sets ?? 3)" required />
        </div>
        <div>
            <x-input-label for="default_reps" value="تکرار پیش‌فرض" />
            <x-text-input id="default_reps" name="default_reps" class="mt-1 block w-full" :value="old('default_reps', $exercise?->default_reps ?? '8-12')" required />
        </div>
        <div>
            <x-input-label for="rest_seconds" value="استراحت (ثانیه)" />
            <x-text-input id="rest_seconds" name="rest_seconds" type="number" class="mt-1 block w-full" :value="old('rest_seconds', $exercise?->rest_seconds ?? 90)" required />
        </div>
    </div>
</div>
