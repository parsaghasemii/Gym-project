<x-admin-layout>
    <div class="admin-page-header">
        <div>
            <p class="section-label">مدیریت</p>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900">وعده‌های غذایی</h1>
        </div>
        <a href="{{ route('admin.meals.create') }}" class="btn-primary !text-sm w-full sm:w-auto justify-center">وعده جدید</a>
    </div>

    <p class="table-scroll-hint">برای مشاهده کامل جدول، به چپ بکشید ←</p>
    <div class="card table-scroll">
        <table class="w-full text-sm text-right">
            <thead>
                <tr class="border-b border-slate-200 text-slate-500">
                    <th class="py-2 font-medium">نام</th>
                    <th class="py-2 font-medium">نوع</th>
                    <th class="py-2 font-medium">کالری</th>
                    <th class="py-2 font-medium">P/C/F</th>
                    <th class="py-2 font-medium"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($meals as $meal)
                    <tr class="border-b border-slate-100">
                        <td class="py-3 font-medium">{{ $meal->name }}</td>
                        <td class="py-3">{{ $meal->meal_type->label() }}</td>
                        <td class="py-3">{{ $meal->calories }}</td>
                        <td class="py-3">{{ $meal->protein }}/{{ $meal->carbs }}/{{ $meal->fat }}</td>
                        <td class="py-3 text-left">
                            <a href="{{ route('admin.meals.edit', $meal) }}" class="text-gym-600 hover:underline">ویرایش</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-8 text-center text-slate-500">وعده‌ای ثبت نشده است.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $meals->links() }}</div>
</x-admin-layout>
