@php
    $faqs = [
        [
            'question' => 'چطور میتونم برنامه خودم رو درست کنم؟',
            'answer' => 'کافیه ثبت‌نام کنی و onboarding چهار مرحله‌ای رو کامل کنی: اطلاعات بدن، هدف، روزهای تمرین و تجهیزات. بعد ۱ تا ۳ گروه عضلانی انتخاب می‌کنی و سیستم بر اساس همین داده‌ها یک برنامه ۴ هفته‌ای تمرین و تغذیه شخصی می‌سازه — بدون حدس و بدون جستجو در اینترنت.',
        ],
        [
            'question' => 'چرا بیشتر از ۳ ناحیه برای عضله‌سازی نمیتونم انتخاب کنم؟',
            'answer' => 'محدودیت ۳ ناحیه عمدیه تا برنامه واقع‌بینانه و مؤثر بمونه. وقتی تمرکز روی عضله‌های زیاد پخش بشه، حجم تمرین هر ناحیه کم می‌شه و بدن فرصت ریکاوری و رشد واقعی پیدا نمی‌کنه. با ۱ تا ۳ اولویت، برنامه متعادل‌تره و نتیجه‌اش هم سریع‌تر دیده می‌شه.',
        ],
        [
            'question' => 'راه‌های ارتباطی',
            'answer' => 'برای دریافت برنامه، ثبت‌نام و تکمیل پروفایل سریع‌ترین راهه. برای پشتیبانی می‌تونی به ایمیل '.config('gym.admin_email').' پیام بدی — معمولاً ظرف ۲۴ ساعت پاسخ می‌دیم. همین چت هم برای سوالات پرتکرار همیشه در دسترسه.',
        ],
    ];
@endphp

<div
    x-data="{
        open: false,
        visible: false,
        loading: false,
        messages: [
            {
                role: 'bot',
                text: 'سلام! روی هر سوال بزن تا جوابش رو ببینی.',
            },
        ],
        faqs: @js($faqs),
        toggle() {
            this.open = ! this.open;
            if (this.open) {
                this.$nextTick(() => this.scrollToBottom());
            }
        },
        ask(faq) {
            if (this.loading) {
                return;
            }

            this.messages.push({ role: 'user', text: faq.question });
            this.loading = true;
            this.$nextTick(() => this.scrollToBottom());

            window.setTimeout(() => {
                this.messages.push({ role: 'bot', text: faq.answer });
                this.loading = false;
                this.$nextTick(() => this.scrollToBottom());
            }, 450);
        },
        scrollToBottom() {
            const panel = this.$refs.messages;
            if (panel) {
                panel.scrollTop = panel.scrollHeight;
            }
        },
    }"
    x-init="window.setTimeout(() => visible = true, 400)"
    x-cloak
    class="fixed start-5 z-[60] safe-fixed-bottom sm:start-6"
    :class="visible ? 'translate-y-0 opacity-100' : 'translate-y-16 opacity-0'"
    style="transition: transform 0.55s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.55s ease;"
>
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="mb-3 w-[min(calc(100vw-2rem),22rem)] overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-gym sm:w-[min(calc(100vw-2.5rem),22rem)]"
        role="dialog"
        aria-label="سوالات متداول"
    >
        <div class="flex items-center justify-between gap-3 border-b border-slate-100 bg-gradient-to-l from-gym-600 to-gym-700 px-4 py-3 text-white">
            <div class="flex items-center gap-2.5">
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-white/15 ring-1 ring-white/20">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5M12 3a9 9 0 0 0-6.32 15.6L4 21l2.4-1.68A9 9 0 1 0 12 3z" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm font-semibold">دستیار {{ config('app.name') }}</p>
                    <p class="text-xs text-gym-100">آنلاین · سوالات متداول</p>
                </div>
            </div>
            <button
                type="button"
                x-on:click="open = false"
                class="rounded-lg p-1.5 text-white/80 transition hover:bg-white/10 hover:text-white"
                aria-label="بستن"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div x-ref="messages" class="chat-widget-messages max-h-[min(42vh,16rem)] space-y-3 overflow-y-auto bg-slate-50/80 px-4 py-4 sm:max-h-64">
            <template x-for="(message, index) in messages" :key="index">
                <div class="flex" :class="message.role === 'user' ? 'justify-start' : 'justify-end'">
                    <div
                        class="max-w-[90%] rounded-2xl px-3.5 py-2.5 text-sm leading-6 shadow-sm"
                        :class="message.role === 'user'
                            ? 'rounded-br-md bg-gym-600 text-white'
                            : 'rounded-bl-md border border-slate-200/80 bg-white text-slate-700'"
                        x-text="message.text"
                    ></div>
                </div>
            </template>

            <div x-show="loading" x-cloak class="flex justify-end">
                <div class="rounded-2xl rounded-bl-md border border-slate-200/80 bg-white px-3.5 py-2.5 text-sm text-slate-400">
                    در حال نوشتن...
                </div>
            </div>
        </div>

        <div class="border-t border-slate-100 bg-white p-3">
            <p class="mb-2 text-xs font-medium text-slate-500">یک سوال انتخاب کن:</p>
            <div class="space-y-2">
                <template x-for="(faq, index) in faqs" :key="index">
                    <button
                        type="button"
                        x-on:click="ask(faq)"
                        :disabled="loading"
                        class="chat-faq-btn w-full text-start"
                        x-text="faq.question"
                    ></button>
                </template>
            </div>
        </div>
    </div>

    <button
        type="button"
        x-on:click="toggle()"
        class="group relative flex h-12 w-12 sm:h-14 sm:w-14 items-center justify-center rounded-full bg-gradient-to-br from-gym-500 to-gym-700 text-white shadow-gym ring-4 ring-white transition hover:scale-105 hover:from-gym-400 hover:to-gym-600 focus:outline-none focus:ring-2 focus:ring-gym-500 focus:ring-offset-2"
        :aria-expanded="open"
        aria-label="باز کردن سوالات متداول"
    >
        <span class="absolute -top-0.5 -start-0.5 h-3.5 w-3.5 rounded-full border-2 border-white bg-emerald-400" aria-hidden="true"></span>
        <svg
            x-show="! open"
            class="h-6 w-6"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.8"
            aria-hidden="true"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5M12 3a9 9 0 0 0-6.32 15.6L4 21l2.4-1.68A9 9 0 1 0 12 3z" />
        </svg>
        <svg
            x-show="open"
            x-cloak
            class="h-6 w-6"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            aria-hidden="true"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
</div>
