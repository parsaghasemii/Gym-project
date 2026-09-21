@props(['meal' => null])

<div class="space-y-4">
    <div>
        <x-input-label for="name" value="نام" />
        <x-text-input id="name" name="name" class="mt-1 block w-full" :value="old('name', $meal?->name)" required />
    </div>

    <div>
        <x-input-label for="meal_type" value="نوع وعده" />
        <select id="meal_type" name="meal_type" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-gym-500 focus:ring-gym-500" required>
            @foreach (\App\Enums\MealType::cases() as $type)
                <option value="{{ $type->value }}" @selected(old('meal_type', $meal?->meal_type?->value) === $type->value)>{{ $type->label() }}</option>
            @endforeach
        </select>
    </div>

    <div class="grid gap-4 sm:grid-cols-4">
        <div>
            <x-input-label for="calories" value="کالری" />
            <x-text-input id="calories" name="calories" type="number" class="mt-1 block w-full" :value="old('calories', $meal?->calories)" required />
        </div>
        <div>
            <x-input-label for="protein" value="پروتئین" />
            <x-text-input id="protein" name="protein" type="number" class="mt-1 block w-full" :value="old('protein', $meal?->protein)" required />
        </div>
        <div>
            <x-input-label for="carbs" value="کربوهیدرات" />
            <x-text-input id="carbs" name="carbs" type="number" class="mt-1 block w-full" :value="old('carbs', $meal?->carbs)" required />
        </div>
        <div>
            <x-input-label for="fat" value="چربی" />
            <x-text-input id="fat" name="fat" type="number" class="mt-1 block w-full" :value="old('fat', $meal?->fat)" required />
        </div>
    </div>

    <div>
        <x-input-label for="description" value="توضیحات" />
        <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-gym-500 focus:ring-gym-500">{{ old('description', $meal?->description) }}</textarea>
    </div>
</div>
