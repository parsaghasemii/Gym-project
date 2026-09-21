@php
    use App\Support\ValidationPresenter;
@endphp

<x-admin-layout>
    <div class="mb-6">
        <p class="section-label">مدیریت</p>
        <h1 class="text-2xl font-bold text-slate-900">ایجاد دسترسی کاربر</h1>
        <p class="mt-1 text-sm text-slate-500">حساب عضو جدید بسازید تا بتواند وارد سایت شود.</p>
    </div>

    <form method="POST" action="{{ route('admin.members.store') }}" class="card max-w-2xl">
        @csrf

        <div>
            <x-input-label for="name" value="نام" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" :has-error="ValidationPresenter::hasError($errors, 'name')" required autofocus autocomplete="name" />
            <x-input-error field="name" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" value="ایمیل" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" :has-error="ValidationPresenter::hasError($errors, 'email')" required autocomplete="username" />
            <x-input-error field="email" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="رمز عبور" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" :has-error="ValidationPresenter::hasError($errors, 'password')" required autocomplete="new-password" />
            <x-input-error field="password" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="تکرار رمز عبور" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" :has-error="ValidationPresenter::hasError($errors, 'password_confirmation')" required autocomplete="new-password" />
            <x-input-error field="password_confirmation" class="mt-2" />
        </div>

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row">
            <x-primary-button>ایجاد دسترسی</x-primary-button>
            <a href="{{ route('admin.members.index') }}" class="btn-secondary">انصراف</a>
        </div>
    </form>
</x-admin-layout>
