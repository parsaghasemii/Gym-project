<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="section-label">پروفایل ورزشی</p>
            <h2 class="mt-1 text-xl font-bold text-slate-900">اطلاعات ثبت‌شده در ساخت برنامه</h2>
        </div>
    </x-slot>

    <div class="page-content max-w-2xl">
        <p class="mb-4 text-sm text-slate-600">
            این اطلاعات همان چیزهایی است که هنگام ساخت برنامه انتخاب کردید و پایه برنامه فعلی‌تان است.
        </p>

        <div class="card space-y-6">
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <p class="section-label">سن</p>
                    <p class="mt-1 text-base font-semibold text-slate-900">
                        <x-persian-digits>{{ $profile->age ?? '—' }}</x-persian-digits>
                    </p>
                </div>
                <div>
                    <p class="section-label">جنسیت</p>
                    <p class="mt-1 text-base font-semibold text-slate-900">{{ $profile->gender?->label() ?? '—' }}</p>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <p class="section-label">قد (سانتی‌متر)</p>
                    <p class="mt-1 text-base font-semibold text-slate-900">
                        <x-persian-digits>{{ $profile->height ?? '—' }}</x-persian-digits>
                    </p>
                </div>
                <div>
                    <p class="section-label">وزن (کیلوگرم)</p>
                    <p class="mt-1 text-base font-semibold text-slate-900">
                        <x-persian-digits>{{ $profile->weight ?? '—' }}</x-persian-digits>
                    </p>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <p class="section-label">سطح آمادگی</p>
                    <p class="mt-1 text-base font-semibold text-slate-900">{{ $profile->fitness_level?->label() ?? '—' }}</p>
                </div>
                <div>
                    <p class="section-label">هدف</p>
                    <p class="mt-1 text-base font-semibold text-slate-900">{{ $profile->goal?->label() ?? '—' }}</p>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <p class="section-label">روز تمرین در هفته</p>
                    <p class="mt-1 text-base font-semibold text-slate-900">
                        <x-persian-digits>{{ $profile->days_per_week ?? '—' }}</x-persian-digits>
                        @if ($profile->days_per_week)
                            <span class="font-normal text-slate-600">روز</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="section-label">تجهیزات</p>
                    <p class="mt-1 text-base font-semibold text-slate-900">{{ $profile->equipment?->label() ?? '—' }}</p>
                </div>
            </div>

            <div>
                <p class="section-label">آسیب‌دیدگی</p>
                <p class="mt-1 text-base text-slate-900">{{ filled($profile->injuries) ? $profile->injuries : '—' }}</p>
            </div>

            <div>
                <p class="section-label">اولویت عضلانی</p>
                @if ($muscleGroups->isNotEmpty())
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($muscleGroups as $group)
                            <span class="inline-flex rounded-full border border-gym-200 bg-gym-50 px-3 py-1 text-sm font-medium text-gym-800">
                                {{ $group->name }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="mt-1 text-base text-slate-900">—</p>
                @endif
            </div>
        </div>

        <div class="mt-5">
            <a href="{{ route('dashboard') }}" class="btn-secondary !text-sm">بازگشت به داشبورد</a>
        </div>
    </div>
</x-app-layout>
