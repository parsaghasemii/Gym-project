<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased overflow-x-hidden">
        <div class="min-h-screen flex flex-col sm:justify-center items-center px-4 py-8 sm:py-10 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900">
            <div class="mb-8">
                <x-gym-logo />
            </div>

            <div class="w-full sm:max-w-md card !p-0 overflow-hidden">
                <div class="h-1 bg-gradient-to-l from-gym-400 to-gym-600"></div>
                <div class="px-5 py-7 sm:px-6 sm:py-8">
                    {{ $slot }}
                </div>
            </div>

            <p class="mt-6 sm:mt-8 text-sm text-slate-400 text-center">
                <a href="{{ route('home') }}" class="hover:text-gym-400 transition">بازگشت به صفحه اصلی</a>
            </p>
        </div>

        <x-chat-widget />
    </body>
</html>
