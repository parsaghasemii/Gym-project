<x-public-layout>
    {{-- Hero --}}
    <section id="hero" class="relative overflow-hidden scroll-mt-4">
        <div class="absolute inset-0 bg-gradient-to-bl from-gym-950/5 via-transparent to-gym-500/5"></div>
        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 md:py-20 lg:py-28">
            <div class="grid gap-6 sm:gap-10 lg:gap-12 lg:grid-cols-2 lg:items-center">
                <div class="text-center lg:text-start">
                    <p class="section-label mb-3 sm:mb-4">برنامه شخصی تمرین و تغذیه</p>
                    <h1 class="text-[1.75rem] leading-[1.2] sm:text-4xl sm:leading-tight md:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900">
                        بدنت رو بساز،<br>
                        <span class="text-gym-600">برنامه‌ات رو بگیر</span>
                    </h1>
                    <p class="mt-4 sm:mt-6 text-base sm:text-lg text-slate-600 leading-7 sm:leading-8 max-w-xl mx-auto lg:mx-0">
                        ثبت‌نام کن، اطلاعاتت رو وارد کن و برنامه ۴ هفته‌ای متناسب با هدف و زمان‌بندی‌ات دریافت کن.
                    </p>

                    <div class="mt-6 sm:mt-8 md:mt-10 flex flex-wrap justify-center lg:justify-start gap-3">
                        @guest
                            <a href="{{ route('register') }}" class="btn-primary !px-6 sm:!px-7 !py-2.5 sm:!py-3 !text-sm sm:!text-base">
                                شروع رایگان
                            </a>
                            <a href="{{ route('login') }}" class="btn-secondary !px-6 sm:!px-7 !py-2.5 sm:!py-3 !text-sm sm:!text-base">
                                ورود
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn-primary !px-6 sm:!px-7 !py-2.5 sm:!py-3 !text-sm sm:!text-base">
                                رفتن به داشبورد
                            </a>
                        @endguest
                    </div>
                </div>

                {{-- Feature boxes — vertical auto carousel --}}
                @php
                    $heroFeatures = [
                        [
                            'title' => 'برنامه تمرینی',
                            'description' => '۳ تا ۵ روز در هفته، متناسب با سطح و تجهیزات شما',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.5 6.5h11M6.5 17.5h11"/><rect x="2" y="4" width="4.5" height="16" rx="1.5"/><rect x="17.5" y="4" width="4.5" height="16" rx="1.5"/>',
                        ],
                        [
                            'title' => 'تغذیه هوشمند',
                            'description' => 'کالری و ماکرو روزانه با پیشنهاد وعده‌های غذایی',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3 12h18"/>',
                        ],
                        [
                            'title' => 'تمرکز عضلانی',
                            'description' => 'اولویت‌دهی به گروه‌های عضلانی انتخابی شما',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
                        ],
                    ];
                @endphp

                <div class="hero-feature-carousel"
                     x-data="{
                        active: 0,
                        total: {{ count($heroFeatures) }},
                        timer: null,
                        offset(index) {
                            let diff = index - this.active;
                            if (diff > 1) diff -= this.total;
                            if (diff < -1) diff += this.total;
                            return diff;
                        },
                        slideStyle(index) {
                            const diff = this.offset(index);
                            const isMobile = window.innerWidth < 640;
                            const gap = isMobile ? 4.75 : 8;
                            const y = diff * gap;
                            const scale = diff === 0 ? (isMobile ? 1 : 1.05) : (isMobile ? 0.9 : 0.88);
                            const opacity = diff === 0 ? 1 : (isMobile ? 0.45 : 0.38);
                            return {
                                transform: `translateY(calc(-50% + ${y}rem)) scale(${scale})`,
                                opacity,
                                zIndex: diff === 0 ? 30 : 20 - Math.abs(diff),
                            };
                        },
                        init() {
                            this.timer = setInterval(() => {
                                this.active = (this.active - 1 + this.total) % this.total;
                            }, 5000);
                        },
                        destroy() {
                            clearInterval(this.timer);
                        },
                     }"
                     aria-live="polite"
                     aria-roledescription="carousel">
                    @foreach ($heroFeatures as $index => $feature)
                        <div class="hero-feature-slide"
                             :class="offset({{ $index }}) === 0 ? 'hero-feature-slide--active' : 'hero-feature-slide--inactive'"
                             :style="slideStyle({{ $index }})"
                             :aria-hidden="offset({{ $index }}) !== 0">
                            <div class="hero-feature-slide__icon-wrap transition-colors duration-700"
                                 :class="offset({{ $index }}) === 0 ? 'hero-feature-slide__icon-wrap--active' : 'hero-feature-slide__icon-wrap--inactive'"
                                 aria-hidden="true">
                                <svg class="hero-feature-slide__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $feature['icon'] !!}</svg>
                            </div>
                            <div class="hero-feature-slide__content">
                                <h3 class="font-semibold transition-colors duration-700"
                                    :class="offset({{ $index }}) === 0 ? 'text-slate-900' : 'text-slate-400'">
                                    {{ $feature['title'] }}
                                </h3>
                                <p class="mt-1.5 text-sm leading-6 transition-colors duration-700"
                                   :class="offset({{ $index }}) === 0 ? 'text-slate-600' : 'text-slate-400'">
                                    {{ $feature['description'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- About --}}
    <section id="about" class="border-t border-slate-200/80 bg-white scroll-mt-4">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 md:py-20">
            <div class="max-w-3xl mx-auto lg:mx-0 text-center lg:text-start">
                <p class="section-label mb-2 sm:mb-3">درباره پلتفرم</p>
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-slate-900 leading-snug">
                    باشگاه آنلاین برای کسانی که می‌خوان منظم تمرین کنن، نه حدس بزنن
                </h2>
                <p class="mt-4 sm:mt-5 text-sm sm:text-base text-slate-600 leading-7 sm:leading-8">
                    {{ config('app.name') }} یک سامانه شخصی‌سازی‌شده برای برنامه تمرین و تغذیه است. شما اطلاعات بدنی، هدف و زمان‌بندی‌تان را وارد می‌کنید و سیستم بر اساس قوانین علمی، یک برنامه ۴ هفته‌ای آماده می‌کند — شامل روزهای تمرین، حرکات، ست و تکرار، و همچنین هدف کالری و ماکرو روزانه.
                </p>
                <p class="mt-3 sm:mt-4 text-sm sm:text-base text-slate-600 leading-7 sm:leading-8">
                    دیگر لازم نیست ساعت‌ها در اینترنت بگردید یا از برنامه‌های آماده‌ی نامرتبط استفاده کنید. همه‌چیز بر اساس شرایط واقعی شما طراحی می‌شود.
                </p>
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    @php
        $testimonials = [
            [
                'quote' => 'برنامه تمرین و تغذیه‌ای که گرفتم واقعاً متناسب با شرایط من بود. توی ۴ هفته اول ۳ کیلو چربی کم کردم و انرژیم خیلی بیشتر شد. دیگه لازم نیست ساعت‌ها تو اینترنت بگردم.',
                'name' => 'سارا محمدی',
                'meta' => 'عضو ۲ ماهه',
            ],
            [
                'quote' => 'قبلاً هر هفته برنامه‌ام رو از جاهای مختلف کپی می‌کردم و همیشه گیج می‌شدم. اینجا با چند تا سوال ساده split دقیق Upper/Lower گرفتم و توی دو ماه حجم عضلانی‌ام خیلی بهتر شد.',
                'name' => 'امیر حسینی',
                'meta' => 'عضو ۳ ماهه',
            ],
            [
                'quote' => 'به‌عنوان تازه‌کار نمی‌دونستم از کجا شروع کنم. onboarding ساده بود و برنامه ۳ روزه‌ام دقیقاً همون چیزی بود که می‌خواستم — نه سنگین، نه سبک. واقعاً حس می‌کنم با برنامه جلو می‌رم.',
                'name' => 'نرگس کاظمی',
                'meta' => 'عضو ۱ ماهه',
            ],
            [
                'quote' => 'هدفم کاهش وزن بود و توی ۶ هفته حدود ۴.۵ کیلو پایین اومدم بدون اینکه احساس کنم دارم خودمو از گرسنگی نابود می‌کنم. ماکروهای روزانه دقیقاً به درد زندگی واقعی‌ام خورد — نه یه عدد تئوری.',
                'name' => 'رضا مرادی',
                'meta' => 'عضو ۴ ماهه',
            ],
            [
                'quote' => 'قبل از اینجا هر ماه برنامه‌ام رو عوض می‌کردم و پیشرفتی نداشتم. الان ۵ ماهه با همین سیستم جلو می‌رم و پرس سینه‌ام از ۶۰ به ۷۷.۵ کیلو رسیده. حس می‌کنم بالاخره یه مسیر منطقی پیدا کردم.',
                'name' => 'مینا رضایی',
                'meta' => 'عضو ۵ ماهه',
            ],
            [
                'quote' => 'کارم پشت میز نشسته و وقت محدود دارم؛ برنامه ۴ روزه‌ام طوری چیده شده که هر جلسه زیر ۵۰ دقیقه تموم می‌شه. توی ۸ هفته کمردردم کمتر شده و انرژی بعدازظهرم اصلاً مثل قبل نیست.',
                'name' => 'کوروش نیک‌پور',
                'meta' => 'عضو ۲ ماهه',
            ],
            [
                'quote' => 'بعد از چند سال رکود، فکر می‌کردم دیگه بدنم جواب نمی‌ده. توی ۳ ماه اول ۲ سانتی دور بازوم اضافه شد و لباس‌هام دوباره اندازه‌ام شد. برای من مهم این بود که برنامه واقعاً قابل اجرا باشه — و بود.',
                'name' => 'لیلا احمدی',
                'meta' => 'عضو ۶ ماهه',
            ],
        ];
    @endphp

    <section id="testimonials" class="border-t border-slate-200/80 bg-slate-50 overflow-hidden scroll-mt-4">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 md:py-20">
            <div class="mb-8 sm:mb-10 text-center">
                <p class="section-label mb-2 sm:mb-3">نظرات کاربران</p>
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-slate-900">اعضا چی می‌گن؟</h2>
            </div>

            <div class="testimonial-slider"
                 x-data="{
                    active: 0,
                    total: {{ count($testimonials) }},
                    timer: null,
                    touchStartX: 0,
                    touchDeltaX: 0,
                    windowWidth: window.innerWidth,
                    isDesktop() { return this.windowWidth >= 768; },
                    offset(index) {
                        let diff = index - this.active;
                        if (diff > 1) diff -= this.total;
                        if (diff < -1) diff += this.total;
                        return diff;
                    },
                    slideMetrics() {
                        const w = this.windowWidth;
                        if (w < 640) return { gap: 52, slideWidth: 80, inactiveScale: 0.68, inactiveOpacity: 0.7 };
                        if (w < 1024) return { gap: 48, slideWidth: 66, inactiveScale: 0.70, inactiveOpacity: 0.68 };
                        return { gap: 44, slideWidth: 58, inactiveScale: 0.72, inactiveOpacity: 0.65 };
                    },
                    slideStyle(index) {
                        const diff = this.offset(index);
                        const { gap, slideWidth, inactiveScale, inactiveOpacity } = this.slideMetrics();
                        const scale = diff === 0 ? 1 : inactiveScale;
                        const opacity = diff === 0 ? 1 : inactiveOpacity;
                        return {
                            width: `${slideWidth}%`,
                            left: `calc(50% + ${diff * gap}%)`,
                            transform: `translate(-50%, -50%) scale(${scale})`,
                            opacity,
                            zIndex: diff === 0 ? 2 : 1,
                        };
                    },
                    goTo(index) {
                        this.active = ((index % this.total) + this.total) % this.total;
                        this.restartTimer();
                    },
                    next() { this.goTo(this.active + 1); },
                    prev() { this.goTo(this.active - 1); },
                    onTouchStart(event) {
                        this.touchStartX = event.touches[0].clientX;
                        this.touchDeltaX = 0;
                        clearInterval(this.timer);
                    },
                    onTouchMove(event) {
                        this.touchDeltaX = event.touches[0].clientX - this.touchStartX;
                    },
                    onTouchEnd() {
                        const threshold = 40;
                        if (this.touchDeltaX < -threshold) this.next();
                        else if (this.touchDeltaX > threshold) this.prev();
                        else this.restartTimer();
                        this.touchDeltaX = 0;
                    },
                    restartTimer() {
                        clearInterval(this.timer);
                        this.timer = setInterval(() => this.next(), 7000);
                    },
                    init() {
                        this.restartTimer();
                        this._onResize = () => { this.windowWidth = window.innerWidth; };
                        window.addEventListener('resize', this._onResize);
                    },
                    destroy() {
                        clearInterval(this.timer);
                        window.removeEventListener('resize', this._onResize);
                    },
                 }">
                <div class="testimonial-slider__frame" dir="ltr">
                    <button type="button"
                            @click="prev()"
                            class="testimonial-slider__nav"
                            aria-label="نظر قبلی">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>

                    {{-- dir=ltr keeps slide math reliable; each slide restores RTL text --}}
                    <div class="testimonial-carousel"
                         dir="ltr"
                         @touchstart.passive="onTouchStart($event)"
                         @touchmove.passive="onTouchMove($event)"
                         @touchend="onTouchEnd()"
                         aria-live="polite"
                         aria-roledescription="carousel">
                        @foreach ($testimonials as $index => $testimonial)
                            <div class="testimonial-slide"
                                 dir="rtl"
                                 :class="[
                                     offset({{ $index }}) === 0 ? 'testimonial-slide--active' : 'testimonial-slide--inactive',
                                     offset({{ $index }}) !== 0 && isDesktop() ? 'cursor-pointer' : '',
                                 ]"
                                 :style="slideStyle({{ $index }})"
                                 :aria-hidden="offset({{ $index }}) !== 0"
                                 @click="isDesktop() && offset({{ $index }}) !== 0 && goTo({{ $index }})">
                                <svg class="mx-auto h-8 w-8 transition-colors duration-700"
                                     :class="offset({{ $index }}) === 0 ? 'text-gym-200' : 'text-slate-300'"
                                     fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179zm10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179z"/>
                                </svg>
                                <p class="testimonial-slide__quote transition-colors duration-700"
                                   :class="offset({{ $index }}) === 0 ? 'text-slate-600' : 'text-slate-400'">
                                    {{ $testimonial['quote'] }}
                                </p>
                                <p class="testimonial-slide__name transition-colors duration-700"
                                   :class="offset({{ $index }}) === 0 ? 'text-slate-900' : 'text-slate-400'">
                                    {{ $testimonial['name'] }}
                                </p>
                                <p class="testimonial-slide__meta transition-colors duration-700"
                                   :class="offset({{ $index }}) === 0 ? 'text-slate-500' : 'text-slate-400'">
                                    {{ $testimonial['meta'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <button type="button"
                            @click="next()"
                            class="testimonial-slider__nav"
                            aria-label="نظر بعدی">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>

                <div class="testimonial-slider__dots">
                    <template x-for="i in total" :key="i">
                        <button type="button"
                                @click="goTo(i - 1)"
                                :class="active === i - 1 ? 'bg-gym-600 w-6' : 'bg-slate-300 hover:bg-slate-400'"
                                class="h-2 w-2 rounded-full transition-all"
                                :aria-label="`نظر ${i}`"
                                :aria-current="active === i - 1 ? 'true' : 'false'"></button>
                    </template>
                </div>
            </div>
        </div>
    </section>

    {{-- Audience --}}
    <section id="audience" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 md:py-20 scroll-mt-4">
        <div class="mb-8 sm:mb-10 md:mb-12">
            <p class="section-label mb-2 sm:mb-3">مخاطب ما</p>
            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-slate-900">به درد چه کسایی می‌خوره؟</h2>
        </div>

        <div class="grid gap-4 sm:gap-5 md:grid-cols-2 lg:grid-cols-3">
            <div class="card">
                <h3 class="font-semibold text-slate-900">تازه‌کارها</h3>
                <p class="mt-2 sm:mt-3 text-sm text-slate-600 leading-6 sm:leading-7">
                    کسانی که تازه شروع کرده‌اند و نمی‌دانند هفته‌ای چند روز تمرین کنند یا از کجا شروع کنند. برنامه بر اساس سطح مبتدی تنظیم می‌شود.
                </p>
            </div>

            <div class="card">
                <h3 class="font-semibold text-slate-900">ورزشکاران منظم</h3>
                <p class="mt-2 sm:mt-3 text-sm text-slate-600 leading-6 sm:leading-7">
                    کسانی که ۳ تا ۵ روز در هفته وقت دارند و می‌خواهند split مناسب (Full Body، Upper/Lower یا PPL) داشته باشند بدون طراحی دستی.
                </p>
            </div>

            <div class="card md:col-span-2 lg:col-span-1">
                <h3 class="font-semibold text-slate-900">هدف‌محورها</h3>
                <p class="mt-2 sm:mt-3 text-sm text-slate-600 leading-6 sm:leading-7">
                    کسانی که هدف مشخص دارند — کاهش وزن، عضله‌سازی یا تناسب اندام — و می‌خواهند تغذیه‌شان هم با تمرین‌شان هماهنگ باشد.
                </p>
            </div>
        </div>
    </section>

    {{-- Why us --}}
    <section id="why-us" class="border-t border-slate-200/80 bg-slate-900 text-white scroll-mt-4">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 md:py-20">
            <div class="mb-8 sm:mb-10">
                <p class="text-xs font-semibold uppercase tracking-wider text-gym-400 mb-2 sm:mb-3">چرا ما؟</p>
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold leading-snug">چرا پیشنهاد می‌کنیم از {{ config('app.name') }} استفاده کنید؟</h2>
            </div>

            <ul class="grid gap-4 sm:gap-5 md:grid-cols-2">
                <li class="flex gap-3 sm:gap-4 rounded-xl border border-slate-700/80 bg-slate-800/50 p-4 sm:p-5">
                    <span class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-gym-600 text-sm font-bold">۱</span>
                    <div>
                        <p class="font-semibold text-white">شخصی‌سازی واقعی</p>
                        <p class="mt-1.5 text-sm text-slate-400 leading-6">برنامه بر اساس قد، وزن، هدف، تعداد روز تمرین و تجهیزات در دسترس شما ساخته می‌شود — نه یک PDF عمومی.</p>
                    </div>
                </li>
                <li class="flex gap-3 sm:gap-4 rounded-xl border border-slate-700/80 bg-slate-800/50 p-4 sm:p-5">
                    <span class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-gym-600 text-sm font-bold">۲</span>
                    <div>
                        <p class="font-semibold text-white">تمرین + تغذیه با هم</p>
                        <p class="mt-1.5 text-sm text-slate-400 leading-6">فقط لیست حرکات نمی‌گیرید؛ کالری و ماکرو روزانه و پیشنهاد وعده هم دریافت می‌کنید تا مسیرتان یکپارچه باشد.</p>
                    </div>
                </li>
                <li class="flex gap-3 sm:gap-4 rounded-xl border border-slate-700/80 bg-slate-800/50 p-4 sm:p-5">
                    <span class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-gym-600 text-sm font-bold">۳</span>
                    <div>
                        <p class="font-semibold text-white">ساده و بدون پیچیدگی</p>
                        <p class="mt-1.5 text-sm text-slate-400 leading-6">ثبت‌نام، پر کردن فرم onboarding، و دریافت برنامه — بدون نیاز به مربی حضوری یا اپ‌های پیچیده.</p>
                    </div>
                </li>
                <li class="flex gap-3 sm:gap-4 rounded-xl border border-slate-700/80 bg-slate-800/50 p-4 sm:p-5">
                    <span class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-gym-600 text-sm font-bold">۴</span>
                    <div>
                        <p class="font-semibold text-white">قابل به‌روزرسانی</p>
                        <p class="mt-1.5 text-sm text-slate-400 leading-6">وزن یا هدفت عوض شد؟ پروفایل را ویرایش کن و برنامه جدید بگیر — همیشه با شرایط فعلی‌ات هماهنگ بمان.</p>
                    </div>
                </li>
            </ul>

            @guest
                <div class="mt-8 sm:mt-10 md:mt-12 text-center">
                    <a href="{{ route('register') }}" class="btn-primary !px-8 !py-3 !text-base">
                        همین الان شروع کن
                    </a>
                </div>
            @endguest
        </div>
    </section>

</x-public-layout>
