<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased page-shell overflow-x-hidden">
        <div class="min-h-screen flex flex-col">
            <x-public-header />

            <main class="flex-1">
                {{ $slot }}
            </main>

            <footer class="border-t border-slate-200 bg-white">
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-sm text-slate-500">
                    <p>{{ config('app.name') }} — برنامه تمرین و تغذیه شخصی</p>
                    <nav class="flex items-center gap-5">
                        <a href="{{ route('home') }}#about" class="hover:text-slate-800 transition">درباره</a>
                        <a href="{{ route('home') }}#testimonials" class="hover:text-slate-800 transition">نظرات</a>
                        @guest
                            <a href="{{ route('login') }}" class="hover:text-slate-800 transition">ورود</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="hover:text-slate-800 transition">داشبورد</a>
                        @endguest
                    </nav>
                </div>
            </footer>
        </div>

        <x-chat-widget />
    </body>
</html>
