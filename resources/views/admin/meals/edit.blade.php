<x-admin-layout>
    <div class="mb-6">
        <p class="section-label">مدیریت</p>
        <h1 class="text-2xl font-bold text-slate-900">ویرایش وعده</h1>
    </div>

    <form method="POST" action="{{ route('admin.meals.update', $meal) }}" class="card max-w-2xl">
        @csrf
        @method('PUT')
        @include('admin.meals._form', ['meal' => $meal])
        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row">
            <x-primary-button>به‌روزرسانی</x-primary-button>
            <a href="{{ route('admin.meals.index') }}" class="btn-secondary">انصراف</a>
        </div>
    </form>

    <form method="POST" action="{{ route('admin.meals.destroy', $meal) }}" class="mt-4" onsubmit="return confirm('حذف شود؟')">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-sm text-red-600 hover:underline">حذف وعده</button>
    </form>
</x-admin-layout>
