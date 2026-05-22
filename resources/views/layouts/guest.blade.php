<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'E-Blood') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 antialiased">
        <div class="min-h-screen flex flex-col justify-center px-4 py-10">
            <div class="mx-auto w-full max-w-lg">
                <div class="bg-white dark:bg-slate-950/90 border border-slate-200/70 dark:border-slate-700/70 shadow-2xl shadow-slate-900/10 rounded-[2rem] overflow-hidden">
                    <div class="bg-gradient-to-r from-red-600 via-pink-600 to-fuchsia-500 px-8 py-8 text-white">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-white/15 text-white text-xl font-bold">E</span>
                            <div>
                                <h1 class="text-2xl font-semibold">E-Blood</h1>
                                <p class="text-sm text-white/80">Beautifully connect donors and requests.</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-8 bg-white dark:bg-slate-950">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
