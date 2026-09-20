<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=vazirmatn:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-900">
        <div class="min-h-screen flex flex-col">
            <header class="border-b border-slate-200 bg-white">
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                    <a href="{{ route('home') }}" class="text-lg font-semibold text-indigo-700">
                        {{ config('app.name') }}
                    </a>

                    @if (Route::has('login'))
                        <nav class="flex items-center gap-3 text-sm">
                            @auth
                                <a href="{{ route('dashboard') }}" class="rounded-md border border-slate-300 px-4 py-2 hover:bg-slate-50">
                                    داشبورد
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="px-3 py-2 text-slate-600 hover:text-slate-900">
                                    ورود
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                                        ثبت‌نام
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
            </header>

            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
