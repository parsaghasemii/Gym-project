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
        search: '',
        navItems: @js($navItems),
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
        filteredNavItems() {
            const query = this.search.trim().toLowerCase();
            if (! query) {
                return this.navItems;
            }

            return this.navItems.filter((item) => item.label.toLowerCase().includes(query));
        },
    }"
    x-on:keydown.escape.window="close()"
    class="site-header"
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
            <label class="sr-only" for="site-mobile-search">جستجو در منو</label>
            <div class="relative">
                <svg class="pointer-events-none absolute start-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" />
                </svg>
                <input
                    id="site-mobile-search"
                    type="search"
                    x-model="search"
                    placeholder="دنبال چی میگردی ؟"
                    class="site-mobile-drawer__search-input"
                >
            </div>
        </div>

        <nav class="site-mobile-drawer__nav" aria-label="منوی موبایل">
            <template x-for="item in filteredNavItems()" :key="item.href">
                <a
                    :href="item.href"
                    x-on:click="close()"
                    class="site-mobile-nav-link"
                    x-text="item.label"
                ></a>
            </template>

            <p
                x-show="filteredNavItems().length === 0"
                x-cloak
                class="px-4 py-6 text-center text-sm text-slate-500"
            >
                موردی پیدا نشد.
            </p>

            <div class="site-mobile-drawer__divider"></div>

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
