<x-public-layout>
    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
            <div>
                <p class="text-sm font-medium text-indigo-600 mb-3">باشگاه آنلاین</p>
                <h1 class="text-3xl sm:text-4xl font-bold leading-tight text-slate-900">
                    برنامه تمرین و تغذیه شخصی‌سازی‌شده برای ۳ تا ۵ روز در هفته
                </h1>
                <p class="mt-4 text-lg text-slate-600 leading-8">
                    ثبت‌نام کنید، اطلاعات بدنی و اهداف خود را وارد کنید، و برنامه هفتگی متناسب با تمرکز عضلانی‌تان دریافت کنید.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    @guest
                        <a href="{{ route('register') }}" class="rounded-md bg-indigo-600 px-6 py-3 text-white font-medium hover:bg-indigo-700">
                            شروع ثبت‌نام
                        </a>
                        <a href="{{ route('login') }}" class="rounded-md border border-slate-300 px-6 py-3 font-medium hover:bg-white">
                            ورود اعضا
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="rounded-md bg-indigo-600 px-6 py-3 text-white font-medium hover:bg-indigo-700">
                            رفتن به داشبورد
                        </a>
                    @endguest
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
                <h2 class="text-xl font-semibold mb-4">چه چیزهایی دریافت می‌کنید؟</h2>
                <ul class="space-y-4 text-slate-700">
                    <li class="flex gap-3">
                        <span class="mt-1 h-2 w-2 rounded-full bg-indigo-500 shrink-0"></span>
                        <span>برنامه تمرینی متناسب با تعداد روزهای هفتگی (۳، ۴ یا ۵ روز)</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="mt-1 h-2 w-2 rounded-full bg-indigo-500 shrink-0"></span>
                        <span>هدف‌گذاری کالری و ماکرو با پیشنهاد وعده‌های غذایی</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="mt-1 h-2 w-2 rounded-full bg-indigo-500 shrink-0"></span>
                        <span>اولویت‌دهی به گروه‌های عضلانی انتخابی شما</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</x-public-layout>
