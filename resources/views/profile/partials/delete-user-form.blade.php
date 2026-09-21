<section class="space-y-5">
    <header>
        <h2 class="text-lg font-semibold text-red-700">
            حذف حساب
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            با حذف حساب، تمام اطلاعات شما برای همیشه پاک می‌شود. این عمل قابل بازگشت نیست.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >حذف حساب</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-slate-900">
                مطمئنید که می‌خواهید حساب را حذف کنید؟
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                برای تأیید، رمز عبور خود را وارد کنید.
            </p>

            <div class="mt-5">
                <x-input-label for="password" value="رمز عبور" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="رمز عبور"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    انصراف
                </x-secondary-button>

                <x-danger-button>
                    حذف حساب
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
