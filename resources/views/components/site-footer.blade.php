<footer class="site-footer">
    <div class="site-footer-inner">
        <div class="site-footer-grid">
            <div class="site-footer-brand">
                <x-gym-logo-light />
                <p class="site-footer-tagline">برنامه تمرین و تغذیه شخصی، متناسب با بدن و هدف شما</p>
            </div>

            @guest
                <nav class="site-footer-nav" aria-label="فوتر">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="site-footer-nav-link">ورود</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="site-footer-nav-link site-footer-nav-link--cta">ثبت‌نام</a>
                    @endif
                </nav>
            @endguest
        </div>

        <div class="site-footer-bottom">
            <p class="site-footer-copy">© {{ date('Y') }} {{ config('app.name') }}. تمامی حقوق محفوظ است.</p>

            <button
                type="button"
                x-data
                x-on:click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                class="site-footer-top"
                aria-label="بازگشت به بالا"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                </svg>
            </button>
        </div>
    </div>
</footer>
