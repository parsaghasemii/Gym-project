<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>مدیریت — {{ config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased page-shell overflow-x-hidden">
        <div class="min-h-screen flex flex-col">
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
                <div class="site-header-inner !max-w-6xl">
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

                    <div class="site-nav" aria-label="ناوبری مدیریت">
                        <a href="{{ route('admin.exercises.index') }}" @class(['site-nav-link', 'site-nav-link--active' => request()->routeIs('admin.exercises.*')])>حرکات</a>
                        <a href="{{ route('admin.meals.index') }}" @class(['site-nav-link', 'site-nav-link--active' => request()->routeIs('admin.meals.*')])>وعده‌ها</a>
                        <a href="{{ route('admin.members.index') }}" @class(['site-nav-link', 'site-nav-link--active' => request()->routeIs('admin.members.*')])>اعضا</a>
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
                        <label class="sr-only" for="admin-mobile-search">جستجو در منو</label>
                        <div class="relative">
                            <svg class="pointer-events-none absolute start-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" />
                            </svg>
                            <input
                                id="admin-mobile-search"
                                type="search"
                                x-model="search"
                                placeholder="دنبال چی میگردی ؟"
                                class="site-mobile-drawer__search-input"
                            >
                        </div>
                    </div>

                    <div class="site-mobile-drawer__nav">
                        <div x-show="matchesSearch('حرکات')" x-cloak>
                            <x-responsive-nav-link :href="route('admin.exercises.index')" :active="request()->routeIs('admin.exercises.*')" x-on:click="close()">حرکات</x-responsive-nav-link>
                        </div>
                        <div x-show="matchesSearch('وعده‌ها')" x-cloak>
                            <x-responsive-nav-link :href="route('admin.meals.index')" :active="request()->routeIs('admin.meals.*')" x-on:click="close()">وعده‌ها</x-responsive-nav-link>
                        </div>
                        <div x-show="matchesSearch('اعضا')" x-cloak>
                            <x-responsive-nav-link :href="route('admin.members.index')" :active="request()->routeIs('admin.members.*')" x-on:click="close()">اعضا</x-responsive-nav-link>
                        </div>

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

            <main class="flex-1 max-w-6xl mx-auto w-full min-w-0 px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
                @if (session('status'))
                    <div class="mb-4 rounded-xl border border-gym-200 bg-gym-50 px-4 py-3 text-sm text-gym-800">
                        {{ session('status') }}
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>

        <x-chat-widget />
    </body>
</html>
