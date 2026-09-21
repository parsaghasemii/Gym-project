<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>مدیریت — {{ config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased page-shell overflow-x-hidden" x-data="{ open: false, scrolled: false, init() { this.onScroll(); window.addEventListener('scroll', () => this.onScroll(), { passive: true }); }, onScroll() { this.scrolled = window.scrollY > 8; } }">
        <div class="min-h-screen flex flex-col">
            <header :class="{ 'site-header--scrolled': scrolled }" class="site-header">
                <div class="site-header-inner !max-w-6xl">
                    <x-gym-logo-light />

                    <nav class="site-nav" aria-label="ناوبری مدیریت">
                        <a href="{{ route('admin.exercises.index') }}" @class(['site-nav-link', 'site-nav-link--active' => request()->routeIs('admin.exercises.*')])>حرکات</a>
                        <a href="{{ route('admin.meals.index') }}" @class(['site-nav-link', 'site-nav-link--active' => request()->routeIs('admin.meals.*')])>وعده‌ها</a>
                        <a href="{{ route('admin.members.index') }}" @class(['site-nav-link', 'site-nav-link--active' => request()->routeIs('admin.members.*')])>اعضا</a>
                    </nav>

                    <div class="site-nav-actions">
                        <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                            @csrf
                            <button type="submit" class="site-nav-login hover:text-slate-900">خروج</button>
                        </form>

                        <button type="button" class="site-nav-menu-btn" x-on:click="open = ! open" :aria-expanded="open" aria-label="منو">
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
                    <a href="{{ route('admin.exercises.index') }}" x-on:click="open = false" @class(['site-mobile-nav-link', 'site-mobile-nav-link--active' => request()->routeIs('admin.exercises.*')])>حرکات</a>
                    <a href="{{ route('admin.meals.index') }}" x-on:click="open = false" @class(['site-mobile-nav-link', 'site-mobile-nav-link--active' => request()->routeIs('admin.meals.*')])>وعده‌ها</a>
                    <a href="{{ route('admin.members.index') }}" x-on:click="open = false" @class(['site-mobile-nav-link', 'site-mobile-nav-link--active' => request()->routeIs('admin.members.*')])>اعضا</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="site-mobile-nav-link w-full text-start">خروج</button>
                    </form>
                </div>
            </header>

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
