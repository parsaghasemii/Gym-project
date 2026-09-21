<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="section-label">خوش آمدید</p>
            <h2 class="mt-1 text-xl font-bold text-slate-900">سلام، {{ Auth::user()->name }}</h2>
        </div>
    </x-slot>

    <div class="page-content">
        <div class="grid gap-4 sm:gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div class="card text-center sm:text-start">
                <p class="section-label">وضعیت</p>
                <p class="mt-2 text-2xl font-bold text-slate-900">فعال</p>
                <p class="mt-1 text-sm text-slate-500">حساب کاربری شما</p>
            </div>

            @if ($profile)
                <div class="card text-center sm:text-start">
                    <p class="section-label">هدف</p>
                    <p class="mt-2 text-xl sm:text-2xl font-bold text-slate-900">{{ $profile->goal?->label() ?? '—' }}</p>
                    <p class="mt-1 text-sm text-slate-500">{{ $profile->days_per_week ?? '—' }} روز در هفته</p>
                </div>
            @endif

            <div class="card text-center sm:text-start sm:col-span-2 lg:col-span-1">
                <p class="section-label">برنامه</p>
                @if ($program)
                    <p class="mt-2 text-base sm:text-lg font-bold text-slate-900">
                        <x-persian-date :date="$program->starts_at" :end="$program->ends_at" />
                    </p>
                    <p class="mt-1 text-sm text-slate-500">{{ $program->split_type->label() }}</p>
                @else
                    <p class="mt-2 text-2xl font-bold text-slate-900">—</p>
                    <p class="mt-1 text-sm text-slate-500">برنامه فعالی وجود ندارد</p>
                @endif
            </div>
        </div>

        <div class="mt-5 sm:mt-6 card">
            <p class="section-label">دسترسی سریع</p>
            <div class="mt-4 flex flex-col sm:flex-row sm:flex-wrap gap-3">
                @if ($program)
                    <a href="{{ route('program.show') }}" class="btn-primary !text-sm w-full sm:w-auto justify-center">
                        مشاهده برنامه
                    </a>
                @endif
                <a href="{{ route('fitness-profile.edit') }}" class="btn-secondary !text-sm w-full sm:w-auto justify-center">
                    پروفایل ورزشی
                </a>
                <a href="{{ route('profile.edit') }}" class="btn-ghost !text-sm border border-slate-200 w-full sm:w-auto justify-center">
                    تنظیمات حساب
                </a>
            </div>

            @if ($program)
                <form method="POST"
                      action="{{ route('program.regenerate') }}"
                      class="mt-4 pt-4 border-t border-slate-100">
                    @csrf
                    <p class="text-sm text-slate-600 mb-3">پروفایلت را در «پروفایل ورزشی» ویرایش کن، بعد برنامه جدید بگیر.</p>
                    <x-confirm-toast message="برنامه فعلی غیرفعال می‌شود و بر اساس پروفایل فعلی‌تان برنامه جدید ساخته می‌شود. ادامه می‌دهید؟">
                        <x-slot:trigger>
                            <button type="button" x-on:click="open = true" class="btn-secondary !text-sm">
                                درخواست برنامه جدید
                            </button>
                        </x-slot:trigger>
                    </x-confirm-toast>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
