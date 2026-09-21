<x-admin-layout>
    <div class="admin-page-header">
        <div>
            <p class="section-label">مدیریت</p>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900">حرکات</h1>
        </div>
        <a href="{{ route('admin.exercises.create') }}" class="btn-primary !text-sm w-full sm:w-auto justify-center">حرکت جدید</a>
    </div>

    <p class="table-scroll-hint">برای مشاهده کامل جدول، به چپ بکشید ←</p>
    <div class="card table-scroll">
        <table class="w-full text-sm text-right">
            <thead>
                <tr class="border-b border-slate-200 text-slate-500">
                    <th class="py-2 font-medium">نام</th>
                    <th class="py-2 font-medium">گروه عضلانی</th>
                    <th class="py-2 font-medium">تجهیزات</th>
                    <th class="py-2 font-medium">سطح</th>
                    <th class="py-2 font-medium"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($exercises as $exercise)
                    <tr class="border-b border-slate-100">
                        <td class="py-3 font-medium">{{ $exercise->name }}</td>
                        <td class="py-3">{{ $exercise->muscleGroup->name }}</td>
                        <td class="py-3">{{ $exercise->equipment->label() }}</td>
                        <td class="py-3">{{ $exercise->difficulty->label() }}</td>
                        <td class="py-3 text-left">
                            <a href="{{ route('admin.exercises.edit', $exercise) }}" class="text-gym-600 hover:underline">ویرایش</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-8 text-center text-slate-500">حرکتی ثبت نشده است.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $exercises->links() }}</div>
</x-admin-layout>
