<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="section-label">تنظیمات</p>
            <h2 class="mt-1 text-xl font-bold text-slate-900">پروفایل</h2>
        </div>
    </x-slot>

    <div
        class="page-content max-w-5xl"
        x-data="{
            section: window.location.hash.replace('#', '') || 'profile',
            setSection(s) {
                this.section = s;
                history.replaceState(null, '', s === 'profile' ? '{{ route('profile.edit') }}' : '{{ route('profile.edit') }}#' + s);
            }
        }"
        x-init="
            if (['profile', 'password', 'delete'].includes(window.location.hash.replace('#', ''))) {
                section = window.location.hash.replace('#', '');
            }
            @if ($errors->updatePassword->isNotEmpty()) section = 'password'; @endif
            @if ($errors->userDeletion->isNotEmpty()) section = 'delete'; @endif
        "
    >
        <div class="flex flex-col lg:flex-row gap-6">
            {{-- Side menu --}}
            <nav class="lg:w-52 shrink-0">
                <div class="mobile-tabs lg:hidden">
                    <button type="button" @click="setSection('profile')"
                        :class="section === 'profile' ? 'bg-gym-50 text-gym-800 font-semibold' : 'bg-white text-slate-600 border border-slate-200'"
                        class="mobile-tab">
                        اطلاعات شخصی
                    </button>
                    <button type="button" @click="setSection('password')"
                        :class="section === 'password' ? 'bg-gym-50 text-gym-800 font-semibold' : 'bg-white text-slate-600 border border-slate-200'"
                        class="mobile-tab">
                        رمز عبور
                    </button>
                    <button type="button" @click="setSection('delete')"
                        :class="section === 'delete' ? 'bg-red-50 text-red-700 font-semibold' : 'bg-white text-slate-600 border border-slate-200'"
                        class="mobile-tab">
                        حذف حساب
                    </button>
                </div>
                <div class="hidden lg:block card !p-2 space-y-1">
                    <button type="button" @click="setSection('profile')"
                        :class="section === 'profile' ? 'bg-gym-50 text-gym-800 font-semibold' : 'text-slate-600 hover:bg-slate-50'"
                        class="w-full text-start px-4 py-2.5 rounded-lg text-sm transition">
                        اطلاعات شخصی
                    </button>
                    <button type="button" @click="setSection('password')"
                        :class="section === 'password' ? 'bg-gym-50 text-gym-800 font-semibold' : 'text-slate-600 hover:bg-slate-50'"
                        class="w-full text-start px-4 py-2.5 rounded-lg text-sm transition">
                        رمز عبور
                    </button>
                    <button type="button" @click="setSection('delete')"
                        :class="section === 'delete' ? 'bg-red-50 text-red-700 font-semibold' : 'text-slate-600 hover:bg-slate-50'"
                        class="w-full text-start px-4 py-2.5 rounded-lg text-sm transition">
                        حذف حساب
                    </button>
                </div>
            </nav>

            {{-- Content --}}
            <div class="flex-1 min-w-0">
                <div x-show="section === 'profile'" x-cloak class="card">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div x-show="section === 'password'" x-cloak class="card" id="password">
                    @include('profile.partials.update-password-form')
                </div>

                <div x-show="section === 'delete'" x-cloak class="card border-red-200" id="delete">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
