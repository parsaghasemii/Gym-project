<x-admin-layout>
    <div class="admin-page-header">
        <div>
            <p class="section-label">مدیریت</p>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900">حرکات</h1>
        </div>
        <a href="{{ route('admin.exercises.create') }}" class="btn-primary !text-sm w-full sm:w-auto justify-center">حرکت جدید</a>
    </div>

    <p class="table-scroll-hint">برای مشاهده کامل جدول، به چپ بکشید ←</p>
    <div class="card admin-table-card">
        <div class="table-scroll">
            <table class="w-full text-sm text-right">
                <thead>
                    <tr>
                        <th>نام</th>
                        <th>گروه عضلانی</th>
                        <th>تجهیزات</th>
                        <th>سطح</th>
                        <th class="w-24"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($exercises as $exercise)
                        <tr>
                            <td class="font-medium text-slate-900">{{ $exercise->name }}</td>
                            <td>{{ $exercise->muscleGroup->name }}</td>
                            <td>{{ $exercise->equipment->label() }}</td>
                            <td>{{ $exercise->difficulty->label() }}</td>
                            <td>
                                <a href="{{ route('admin.exercises.edit', $exercise) }}" class="admin-table-action">ویرایش</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-10 text-center text-slate-500">حرکتی ثبت نشده است.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $exercises->links('vendor.pagination.admin') }}</div>
</x-admin-layout>
