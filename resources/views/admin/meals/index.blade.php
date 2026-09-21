<x-admin-layout>
    <div class="admin-page-header">
        <div>
            <p class="section-label">مدیریت</p>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900">وعده‌های غذایی</h1>
        </div>
    </div>

    <p class="table-scroll-hint">برای مشاهده کامل جدول، به چپ بکشید ←</p>
    <div class="card admin-table-card">
        <div class="table-scroll">
            <table class="w-full text-sm text-right">
                <thead>
                    <tr>
                        <th>نام</th>
                        <th>نوع</th>
                        <th>کالری</th>
                        <th>P/C/F</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($meals as $meal)
                        <tr>
                            <td class="font-medium text-slate-900">{{ $meal->name }}</td>
                            <td>{{ $meal->meal_type->label() }}</td>
                            <td>{{ $meal->calories }}</td>
                            <td>{{ $meal->protein }}/{{ $meal->carbs }}/{{ $meal->fat }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-10 text-center text-slate-500">وعده‌ای ثبت نشده است.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $meals->links('vendor.pagination.admin') }}</div>
</x-admin-layout>
