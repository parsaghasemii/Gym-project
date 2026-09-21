<nav
    x-data="{
        open: false,
        scrolled: false,
        init() {
            this.onScroll();
            window.addEventListener('scroll', () => this.onScroll(), { passive: true });
        },
        onScroll() {
            this.scrolled = window.scrollY > 8;
        },
        close() {
            this.open = false;
        },
        toggle() {
            this.open = ! this.open;
        },
    }"
    x-on:keydown.escape.window="open = false"
    :class="{ 'site-header--scrolled': scrolled }"
    class="site-header"
>
    <div class="site-header-inner">
        <x-gym-logo-light />

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
                <x-dropdown align="left" width="48">
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
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                خروج
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <button
                type="button"
                class="site-nav-menu-btn"
                x-on:click="toggle()"
                :aria-expanded="open"
                aria-label="منو"
            >
                <svg x-show="! open" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                </svg>
                <svg x-show="open" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18" />
                </svg>
            </button>
        </div>
    </div>

    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-1"
        class="site-mobile-nav md:hidden"
    >
        @if (Auth::user()->isAdmin())
            <x-responsive-nav-link :href="route('admin.exercises.index')" :active="request()->routeIs('admin.exercises.*')" x-on:click="close()">حرکات</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.meals.index')" :active="request()->routeIs('admin.meals.*')" x-on:click="close()">وعده‌ها</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.members.index')" :active="request()->routeIs('admin.members.*')" x-on:click="close()">اعضا</x-responsive-nav-link>
        @elseif (Auth::user()->onboarding_completed)
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" x-on:click="close()">داشبورد</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('program.show')" :active="request()->routeIs('program.*')" x-on:click="close()">برنامه</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('fitness-profile.edit')" :active="request()->routeIs('fitness-profile.*')" x-on:click="close()">پروفایل</x-responsive-nav-link>
        @else
            <x-responsive-nav-link :href="route('onboarding.step1')" :active="request()->routeIs('onboarding.*')" x-on:click="close()">تکمیل ثبت‌نام</x-responsive-nav-link>
        @endif

        <x-responsive-nav-link :href="route('profile.edit')" x-on:click="close()">تنظیمات</x-responsive-nav-link>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                خروج
            </x-responsive-nav-link>
        </form>
    </div>
</nav>
