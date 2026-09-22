<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <p class="section-label">برنامه ۴ هفته‌ای</p>
                <h2 class="mt-1 text-xl font-bold text-slate-900">برنامه شخصی شما</h2>
            </div>
            <p class="text-sm text-slate-500">
                <x-persian-date :date="$program->starts_at" :end="$program->ends_at" />
            </p>
        </div>
    </x-slot>

    <div class="page-content space-y-5 sm:space-y-6">
        @if (session('status'))
            <div class="rounded-xl border border-gym-200 bg-gym-50 px-4 py-3 text-sm text-gym-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="card">
            <p class="section-label">تغذیه روزانه</p>
            <div class="stat-grid mt-4">
                <div class="stat-item">
                    <p class="text-xl sm:text-2xl font-bold text-slate-900">
                        <x-persian-digits>{{ number_format($program->nutrition->daily_calories) }}</x-persian-digits>
                    </p>
                    <p class="text-xs sm:text-sm text-slate-500">کالری</p>
                </div>
                <div class="stat-item">
                    <p class="text-xl sm:text-2xl font-bold text-slate-900">
                        <x-persian-digits>{{ $program->nutrition->protein }}g</x-persian-digits>
                    </p>
                    <p class="text-xs sm:text-sm text-slate-500">پروتئین</p>
                </div>
                <div class="stat-item">
                    <p class="text-xl sm:text-2xl font-bold text-slate-900">
                        <x-persian-digits>{{ $program->nutrition->carbs }}g</x-persian-digits>
                    </p>
                    <p class="text-xs sm:text-sm text-slate-500">کربوهیدرات</p>
                </div>
                <div class="stat-item">
                    <p class="text-xl sm:text-2xl font-bold text-slate-900">
                        <x-persian-digits>{{ $program->nutrition->fat }}g</x-persian-digits>
                    </p>
                    <p class="text-xs sm:text-sm text-slate-500">چربی</p>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-600">نوع split: {{ $program->split_type->label() }}</p>
        </div>

        @foreach ($program->days as $day)
            <div class="card">
                <div class="mb-5">
                    <h3 class="text-lg font-bold text-slate-900">
                        <x-persian-digits>{{ $day->day_name }}</x-persian-digits>
                    </h3>
                    <p class="text-sm text-slate-500">
                        <x-persian-digits>{{ $day->focus_label }}</x-persian-digits>
                    </p>
                </div>

                <div class="space-y-6">
                    <div>
                        <p class="section-label mb-3">حرکات</p>

                        <div class="space-y-3 sm:hidden">
                            @foreach ($day->exercises as $dayExercise)
                                <div class="exercise-card">
                                    <div class="flex items-center gap-3">
                                        <x-exercise-gif-thumb :exercise="$dayExercise->exercise" />
                                        <p class="font-medium text-slate-900">{{ $dayExercise->exercise->name }}</p>
                                    </div>
                                    <div class="exercise-card-grid">
                                        <div class="exercise-card-stat">
                                            <p class="text-xs text-slate-500">ست</p>
                                            <p class="mt-1 text-sm font-semibold text-slate-900">
                                                <x-persian-digits>{{ $dayExercise->sets }}</x-persian-digits>
                                            </p>
                                        </div>
                                        <div class="exercise-card-stat">
                                            <p class="text-xs text-slate-500">تکرار</p>
                                            <p class="mt-1 text-sm font-semibold text-slate-900">
                                                <x-persian-digits>{{ $dayExercise->reps }}</x-persian-digits>
                                            </p>
                                        </div>
                                        <div class="exercise-card-stat">
                                            <p class="text-xs text-slate-500">استراحت</p>
                                            <p class="mt-1 text-sm font-semibold text-slate-900">
                                                <x-persian-digits>{{ $dayExercise->rest_seconds }}ث</x-persian-digits>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="table-scroll hidden sm:block">
                            <table class="w-full text-sm text-right">
                                <thead>
                                    <tr class="border-b border-slate-200 text-slate-500">
                                        <th class="py-2 w-14 font-medium text-gym-600">نمایش</th>
                                        <th class="py-2 font-medium">حرکت</th>
                                        <th class="py-2 font-medium">ست</th>
                                        <th class="py-2 font-medium">تکرار</th>
                                        <th class="py-2 font-medium">استراحت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($day->exercises as $dayExercise)
                                        <tr class="border-b border-slate-100">
                                            <td class="py-3">
                                                <x-exercise-gif-thumb :exercise="$dayExercise->exercise" />
                                            </td>
                                            <td class="py-3 font-medium text-slate-900">{{ $dayExercise->exercise->name }}</td>
                                            <td class="py-3">
                                                <x-persian-digits>{{ $dayExercise->sets }}</x-persian-digits>
                                            </td>
                                            <td class="py-3">
                                                <x-persian-digits>{{ $dayExercise->reps }}</x-persian-digits>
                                            </td>
                                            <td class="py-3">
                                                <x-persian-digits>{{ $dayExercise->rest_seconds }} ثانیه</x-persian-digits>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div>
                        <p class="section-label mb-3">پیشنهاد وعده‌ها</p>
                        <div class="grid gap-3 sm:grid-cols-2">
                            @foreach ($day->meals as $dayMeal)
                                <div class="rounded-xl border border-slate-200/80 bg-slate-50 p-4">
                                    <p class="font-medium text-slate-900">{{ $dayMeal->meal->name }}</p>
                                    <p class="text-xs text-gym-600 mt-1">{{ $dayMeal->meal->meal_type->label() }}</p>
                                    <p class="mt-2 text-xs text-slate-500">
                                        {{ $dayMeal->meal->calories }} kcal —
                                        P {{ $dayMeal->meal->protein }} /
                                        C {{ $dayMeal->meal->carbs }} /
                                        F {{ $dayMeal->meal->fat }}
                                    </p>
                                    @if ($dayMeal->meal->description)
                                        <p class="mt-2 text-xs text-slate-600">{{ $dayMeal->meal->description }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <x-exercise-gif-lightbox />
    </div>
</x-app-layout>
