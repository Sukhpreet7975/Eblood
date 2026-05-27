<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'E-Blood') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            window.__ebloodCurrentRole = @json(auth()->check() ? (auth()->user()->isAdmin() ? 'admin' : (auth()->user()->isDonor() ? 'donor' : 'user')) : 'guest');
        </script>
    </head>
    <body class="flex min-h-screen flex-col bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 antialiased">
        <nav class="sticky top-0 z-40 border-b border-slate-200/70 bg-white/95 backdrop-blur-xl shadow-sm dark:border-slate-700/70 dark:bg-slate-950/95">
            <div class="container mx-auto flex flex-wrap items-center justify-between gap-4 px-4 py-4">
                <a href="/" class="flex items-center gap-3 font-semibold text-slate-900 dark:text-white">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-red-600 text-white shadow-lg">E</span>
                    <div class="leading-tight">
                        <span class="block text-lg">E-Blood</span>
                        <span class="block text-xs text-slate-500 dark:text-slate-400">Emergency support</span>
                    </div>
                </a>

                <div class="hidden md:flex items-center gap-3 text-sm">
                    @guest
                        <a href="/" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Home</a>
                        <a href="/login" class="rounded-full px-4 py-2 bg-red-600 text-white hover:bg-red-700">Login</a>
                        <a href="/register" class="rounded-full px-4 py-2 border border-slate-300 text-slate-700 hover:border-red-500 hover:text-red-600 dark:border-slate-700 dark:text-slate-200">Register</a>
                    @else
                        @if(auth()->user()->isAdmin())
                            @php
                                $adminLinkClasses = 'rounded-full px-4 py-2 transition';
                                $adminActiveClasses = 'bg-red-100 text-red-700 dark:bg-red-950/60 dark:text-red-200';
                                $adminInactiveClasses = 'text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800';
                            @endphp

                            <a href="{{ route('admin.home') }}" class="{{ $adminLinkClasses }} {{ request()->routeIs('admin.home') ? $adminActiveClasses : $adminInactiveClasses }}">Home</a>
                            <a href="{{ route('admin.dashboard') }}" class="{{ $adminLinkClasses }} {{ request()->routeIs('admin.dashboard') ? $adminActiveClasses : $adminInactiveClasses }}">Dashboard</a>
                            <a href="{{ route('admin.donors.index') }}" class="{{ $adminLinkClasses }} {{ request()->routeIs('admin.donors.*') ? $adminActiveClasses : $adminInactiveClasses }}">Manage Donors</a>
                            <a href="{{ route('admin.users.index') }}" class="{{ $adminLinkClasses }} {{ request()->routeIs('admin.users.*') ? $adminActiveClasses : $adminInactiveClasses }}">Manage Users</a>
                            <a href="{{ route('admin.requests.index') }}" class="{{ $adminLinkClasses }} {{ request()->routeIs('admin.requests.*') ? $adminActiveClasses : $adminInactiveClasses }}">Emergency Requests</a>
                        @elseif(auth()->user()->isDonor())
                            <a href="{{ route('donor.home') }}" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Home</a>
                            <a href="{{ route('search.index') }}" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Search Donors</a>
                            <a href="{{ route('requests.create') }}" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Create Request</a>
                            <a href="{{ route('requests.index') }}" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">My Requests</a>
                            <a href="{{ route('profile') }}" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Profile</a>
                            <a href="{{ route('availability') }}" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Availability</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Dashboard</a>
                            <a href="{{ route('search.index') }}" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Search Donors</a>
                            <a href="{{ route('requests.create') }}" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Create Request</a>
                            <a href="{{ route('requests.index') }}" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">My Requests</a>
                            <a href="{{ route('profile') }}" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Profile</a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button class="rounded-full px-4 py-2 bg-red-600 text-white hover:bg-red-700">Logout</button>
                        </form>
                    @endguest
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" class="js-dark-mode-toggle inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-300 bg-white text-slate-700 shadow transition duration-300 hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700" aria-label="Toggle dark mode" title="Toggle dark mode">
                        <svg class="dark-mode-icon w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"></svg>
                    </button>

                    <button id="menu-btn" class="md:hidden inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-lg text-slate-900 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-white" aria-label="Toggle menu">☰</button>
                </div>
            </div>

            <div id="mobile-menu" class="hidden flex-col gap-3 px-4 pb-4 md:hidden">
                @guest
                    <a href="/" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Home</a>
                    <a href="/login" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Login</a>
                    <a href="/register" class="block rounded-2xl bg-white px-4 py-3 text-center text-red-600 font-semibold hover:bg-slate-100 dark:bg-slate-900 dark:text-white">Register</a>
                @else
                    @if(auth()->user()->isAdmin())
                        @php
                            $mobileAdminLinkClasses = 'block rounded-2xl px-4 py-3 transition';
                            $mobileAdminActiveClasses = 'bg-red-100 text-red-700 dark:bg-red-950/60 dark:text-red-200';
                            $mobileAdminInactiveClasses = 'text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800';
                        @endphp
                        <a href="{{ route('admin.home') }}" class="{{ $mobileAdminLinkClasses }} {{ request()->routeIs('admin.home') ? $mobileAdminActiveClasses : $mobileAdminInactiveClasses }}">Home</a>
                        <a href="{{ route('admin.dashboard') }}" class="{{ $mobileAdminLinkClasses }} {{ request()->routeIs('admin.dashboard') ? $mobileAdminActiveClasses : $mobileAdminInactiveClasses }}">Dashboard</a>
                        <a href="{{ route('admin.donors.index') }}" class="{{ $mobileAdminLinkClasses }} {{ request()->routeIs('admin.donors.*') ? $mobileAdminActiveClasses : $mobileAdminInactiveClasses }}">Manage Donors</a>
                        <a href="{{ route('admin.users.index') }}" class="{{ $mobileAdminLinkClasses }} {{ request()->routeIs('admin.users.*') ? $mobileAdminActiveClasses : $mobileAdminInactiveClasses }}">Manage Users</a>
                        <a href="{{ route('admin.analytics') }}" class="{{ $mobileAdminLinkClasses }} {{ request()->routeIs('admin.analytics') ? $mobileAdminActiveClasses : $mobileAdminInactiveClasses }}">Analytics</a>
                        <a href="{{ route('admin.requests.index') }}" class="{{ $mobileAdminLinkClasses }} {{ request()->routeIs('admin.requests.*') ? $mobileAdminActiveClasses : $mobileAdminInactiveClasses }}">Emergency Requests</a>
                        <a href="{{ route('admin.notifications') }}" class="{{ $mobileAdminLinkClasses }} {{ request()->routeIs('admin.notifications') ? $mobileAdminActiveClasses : $mobileAdminInactiveClasses }}">Notifications</a>
                    @elseif(auth()->user()->isDonor())
                        <a href="{{ route('donor.home') }}" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Home</a>
                        <a href="{{ route('search.index') }}" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Search Donors</a>
                        <a href="{{ route('requests.create') }}" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Create Request</a>
                        <a href="{{ route('requests.index') }}" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">My Requests</a>
                        <a href="{{ route('profile') }}" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Profile</a>
                        <a href="{{ route('availability') }}" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Availability</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Dashboard</a>
                        <a href="{{ route('search.index') }}" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Search Donors</a>
                        <a href="{{ route('requests.create') }}" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Create Request</a>
                        <a href="{{ route('requests.index') }}" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">My Requests</a>
                        <a href="{{ route('profile') }}" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Profile</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full rounded-2xl bg-red-600 px-4 py-3 text-sm font-semibold text-white hover:bg-red-700">Logout</button>
                    </form>
                    <button type="button" class="js-dark-mode-toggle w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-left text-slate-900 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:hover:bg-slate-800">Toggle theme</button>
                @endguest
            </div>
        </nav>

        <main class="flex-1">
            @yield('content')
        </main>

        <footer class="bg-gradient-to-r from-slate-950 via-slate-900 to-slate-950 text-white">
            <div class="container mx-auto px-4 py-12">
                <div class="grid gap-8 md:grid-cols-4">
                    <div class="space-y-4">
                        <h3 class="text-2xl font-semibold text-red-500">E-Blood</h3>
                        <p class="text-sm text-slate-300">Connecting patients with donors quickly during emergencies. Give blood, save lives.</p>
                        <p class="text-xs italic text-slate-400">"Donate blood, be someone's hero."</p>
                    </div>
                    <div class="space-y-3">
                        <h4 class="font-semibold text-white">Quick Links</h4>
                        <ul class="space-y-2 text-slate-300 text-sm">
                            <li><a href="/" class="hover:text-red-400">Home</a></li>
                            @auth
                                @unless(auth()->user()->isAdmin())
                                    <li><a href="{{ route('search.index') }}" class="hover:text-red-400">Search Donors</a></li>
                                    <li><a href="{{ route('requests.create') }}" class="hover:text-red-400">Emergency Request</a></li>
                                    <li><a href="{{ route('profile') }}" class="hover:text-red-400">Profile</a></li>
                                @endunless
                            @endauth
                        </ul>
                    </div>
                    <div class="space-y-3">
                        <h4 class="font-semibold text-white">Contact</h4>
                        <p class="text-slate-300 text-sm">Email: support@eblood.com</p>
                        <p class="text-slate-300 text-sm">Punjab, India</p>
                        <div class="flex items-center gap-3 pt-2 text-slate-300">
                            <a href="#" class="hover:text-red-400" aria-label="Twitter"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557a9.83 9.83 0 0 1-2.828.775 4.93 4.93 0 0 0 2.165-2.724 9.86 9.86 0 0 1-3.127 1.195 4.916 4.916 0 0 0-8.38 4.482A13.94 13.94 0 0 1 1.671 3.149a4.916 4.916 0 0 0 1.523 6.574 4.897 4.897 0 0 1-2.229-.616c-.054 2.281 1.581 4.415 3.949 4.89a4.935 4.935 0 0 1-2.224.084 4.918 4.918 0 0 0 4.588 3.417A9.867 9.867 0 0 1 0 21.542a13.94 13.94 0 0 0 7.548 2.212c9.058 0 14.01-7.514 14.01-14.01 0-.213-.005-.425-.015-.636A10.012 10.012 0 0 0 24 4.557z"/></svg></a>
                            <a href="#" class="hover:text-red-400" aria-label="Facebook"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2.2V12h2.2V9.8c0-2.2 1.3-3.4 3.3-3.4.95 0 1.95.17 1.95.17v2.14h-1.1c-1.1 0-1.45.69-1.45 1.4V12h2.5l-.4 2.9h-2.1v7A10 10 0 0 0 22 12z"/></svg></a>
                            <a href="#" class="hover:text-red-400" aria-label="Instagram"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7zm10 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/></svg></a>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <h4 class="font-semibold text-white">Support</h4>
                        <p class="text-slate-300 text-sm">Need help? Reach our care team 24/7.</p>
                        <p class="text-slate-400 text-sm">Our mission is to make blood matches fast and transparent.</p>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-8 pt-6 text-center text-gray-400">
                    <div class="md:flex md:justify-between md:items-center">
                        <div>© {{ date('Y') }} E-Blood Donation Platform. All rights reserved.</div>
                        <div class="mt-3 md:mt-0">Made with ❤️ to save lives.</div>
                    </div>
                </div>
            </div>
        </footer>

        @stack('scripts')
    </body>
</html>
