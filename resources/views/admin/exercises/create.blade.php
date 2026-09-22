<x-admin-layout>
    <div class="mb-6">
        <p class="section-label">مدیریت</p>
        <h1 class="text-2xl font-bold text-slate-900">حرکت جدید</h1>
    </div>

    <form method="POST" action="{{ route('admin.exercises.store') }}" enctype="multipart/form-data" class="card max-w-2xl">
        @csrf
        @include('admin.exercises._form', ['muscleGroups' => $muscleGroups])
        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row">
            <x-primary-button>ذخیره</x-primary-button>
            <a href="{{ route('admin.exercises.index') }}" class="btn-secondary">انصراف</a>
        </div>
    </form>
</x-admin-layout>
