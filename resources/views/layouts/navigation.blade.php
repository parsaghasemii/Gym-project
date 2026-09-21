<nav
    x-data="{
        open: false,
        scrolled: false,
        search: '',
        init() {
            this.onScroll();
            window.addEventListener('scroll', () => this.onScroll(), { passive: true });
        },
        onScroll() {
            this.scrolled = window.scrollY > 8;
        },
        close() {
            this.open = false;
            this.search = '';
            document.body.classList.remove('overflow-hidden');
        },
        toggle() {
            if (this.open) {
                this.close();
                return;
            }

            this.open = true;
            document.body.classList.add('overflow-hidden');
        },
        matchesSearch(label) {
            const query = this.search.trim().toLowerCase();
            return ! query || label.toLowerCase().includes(query);
        },
    }"
    x-on:keydown.escape.window="close()"
    x-on:close-mobile-nav.window="close()"
    :class="{ 'site-header--scrolled': scrolled }"
    class="site-header site-header--sticky"
>
    <div class="site-header-inner">
        <div class="site-header-start">
            <button
                type="button"
                class="site-nav-menu-btn"
                x-on:click="toggle()"
                :aria-expanded="open"
                aria-label="منو"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                </svg>
            </button>

            <x-gym-logo-light />
        </div>

        <div class="site-nav">
            @if (Auth::user()->isAdmin())
                <x-nav-link :href="route('admin.exercises.index')" :active="request()->routeIs('admin.exercises.*')">حرکات</x-nav-link>
                <x-nav-link :href="route('admin.meals.index')" :active="request()->routeIs('admin.meals.*')">وعده‌ها</x-nav-link>
                <x-nav-link :href="route('admin.members.index')" :active="request()->routeIs('admin.members.*')">اعضا</x-nav-link>
            @elseif (Auth::user()->onboarding_completed)
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">داشبورد</x-nav-link>
                <x-nav-link :href="route('program.show')" :active="request()->routeIs('program.*')">برنامه</x-nav-link>
                <x-nav-link :href="route('fitness-profile.edit')" :active="request()->routeIs('fitness-profile.*')">پروفایل</x-nav-link>
            @else
                <x-nav-link :href="route('onboarding.step1')" :active="request()->routeIs('onboarding.*')">تکمیل ثبت‌نام</x-nav-link>
            @endif
        </div>

        <div class="site-nav-actions">
            <div class="hidden md:block">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="site-user-btn">
                            <span class="truncate">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 shrink-0 opacity-50" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">تنظیمات</x-dropdown-link>
                        <x-logout-form variant="dropdown" />
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>

    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="site-mobile-drawer md:hidden"
        role="dialog"
        aria-label="منوی موبایل"
    >
        <div class="site-mobile-drawer__header">
            <p class="text-sm font-semibold text-slate-900">منو</p>
            <button
                type="button"
                x-on:click="close()"
                class="site-mobile-drawer__close"
                aria-label="بستن منو"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="site-mobile-drawer__search">
            <label class="sr-only" for="app-mobile-search">جستجو در منو</label>
            <div class="relative">
                <svg class="pointer-events-none absolute start-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" />
                </svg>
                <input
                    id="app-mobile-search"
                    type="search"
                    x-model="search"
                    placeholder="دنبال چی میگردی ؟"
                    class="site-mobile-drawer__search-input"
                >
            </div>
        </div>

        <div class="site-mobile-drawer__nav">
            @if (Auth::user()->isAdmin())
                <div x-show="matchesSearch('حرکات')" x-cloak>
                    <x-responsive-nav-link :href="route('admin.exercises.index')" :active="request()->routeIs('admin.exercises.*')" x-on:click="close()">حرکات</x-responsive-nav-link>
                </div>
                <div x-show="matchesSearch('وعده‌ها')" x-cloak>
                    <x-responsive-nav-link :href="route('admin.meals.index')" :active="request()->routeIs('admin.meals.*')" x-on:click="close()">وعده‌ها</x-responsive-nav-link>
                </div>
                <div x-show="matchesSearch('اعضا')" x-cloak>
                    <x-responsive-nav-link :href="route('admin.members.index')" :active="request()->routeIs('admin.members.*')" x-on:click="close()">اعضا</x-responsive-nav-link>
                </div>
            @elseif (Auth::user()->onboarding_completed)
                <div x-show="matchesSearch('داشبورد')" x-cloak>
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" x-on:click="close()">داشبورد</x-responsive-nav-link>
                </div>
                <div x-show="matchesSearch('برنامه')" x-cloak>
                    <x-responsive-nav-link :href="route('program.show')" :active="request()->routeIs('program.*')" x-on:click="close()">برنامه</x-responsive-nav-link>
                </div>
                <div x-show="matchesSearch('پروفایل')" x-cloak>
                    <x-responsive-nav-link :href="route('fitness-profile.edit')" :active="request()->routeIs('fitness-profile.*')" x-on:click="close()">پروفایل</x-responsive-nav-link>
                </div>
            @else
                <div x-show="matchesSearch('تکمیل ثبت‌نام')" x-cloak>
                    <x-responsive-nav-link :href="route('onboarding.step1')" :active="request()->routeIs('onboarding.*')" x-on:click="close()">تکمیل ثبت‌نام</x-responsive-nav-link>
                </div>
            @endif

            <div class="site-mobile-drawer__divider"></div>

            <div x-show="matchesSearch('تنظیمات')" x-cloak>
                <x-responsive-nav-link :href="route('profile.edit')" x-on:click="close()">تنظیمات</x-responsive-nav-link>
            </div>

            <x-logout-form
                variant="mobile"
                x-show="matchesSearch('خروج')"
                x-cloak
            />
        </div>
    </div>
</nav>

<x-logout-form-target />
