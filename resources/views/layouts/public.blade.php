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

            <x-site-footer />
        </div>

        <x-chat-widget />
    </body>
</html>
