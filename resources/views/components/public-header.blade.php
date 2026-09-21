@php
    $navItems = [
        ['label' => 'درباره', 'href' => route('home').'#about'],
        ['label' => 'نظرات', 'href' => route('home').'#testimonials'],
        ['label' => 'چرا ما؟', 'href' => route('home').'#why-us'],
    ];
@endphp

<header
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

        <nav class="site-nav" aria-label="ناوبری اصلی">
            @foreach ($navItems as $item)
                <a href="{{ $item['href'] }}" class="site-nav-link">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="site-nav-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="site-nav-cta">
                    داشبورد
                </a>
            @else
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="site-nav-login">
                        ورود
                    </a>
                @endif
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="site-nav-cta">
                        ثبت‌نام
                    </a>
                @endif
            @endauth

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
        class="site-mobile-nav"
    >
        <nav aria-label="منوی موبایل">
            @foreach ($navItems as $item)
                <a href="{{ $item['href'] }}" x-on:click="close()" class="site-mobile-nav-link">
                    {{ $item['label'] }}
                </a>
            @endforeach

            @auth
                <a href="{{ route('dashboard') }}" x-on:click="close()" class="site-mobile-nav-link font-medium text-gym-600">
                    داشبورد
                </a>
            @else
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" x-on:click="close()" class="site-mobile-nav-link">
                        ورود
                    </a>
                @endif
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" x-on:click="close()" class="site-mobile-nav-link font-medium text-gym-600">
                        ثبت‌نام
                    </a>
                @endif
            @endauth
        </nav>
    </div>
</header>
