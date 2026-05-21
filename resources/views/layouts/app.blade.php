<!DOCTYPE html>
<html lang="en" id="html">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>E-Blood Donation</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="bg-gray-100 text-black
             dark:bg-gray-900 dark:text-white
             transition-all duration-300">

<!-- Page Loader -->

<div
    id="loader"
    class="fixed inset-0 bg-white
           dark:bg-gray-900
           flex items-center justify-center
           z-50">

    <div class="text-center">

        <!-- Spinner -->

        <div class="w-16 h-16
                    border-4 border-red-600
                    border-t-transparent
                    rounded-full animate-spin
                    mx-auto">

        </div>

        <!-- Text -->

        <p class="mt-4 text-xl font-bold">

            Loading...

        </p>

    </div>

</div>

<!-- Navbar -->

<nav class="bg-red-600 dark:bg-gray-950
            text-white shadow-lg sticky top-0 z-40">

    <div class="container mx-auto px-6 py-4">

        <div class="flex justify-between items-center">

            <!-- Logo -->

            <a href="/"
               class="text-3xl font-extrabold">

                E-Blood

            </a>

            <!-- Desktop Menu -->

            <div class="hidden md:flex items-center gap-6">

                <a href="/"
                   class="hover:text-red-200 transition">

                    Home

                </a>

                @unless(auth()->check() && auth()->user()->is_admin)
                    <a href="/blood-request"
                       class="hover:text-red-200 transition">

                        Emergency Request

                    </a>
                @endunless

                <a href="/search"
                   class="hover:text-red-200 transition">

                    Search Donors

                </a>

                @auth

                    @unless(auth()->user()->is_admin)
                        <a href="/profile"
                           class="hover:text-red-200 transition">
                            Profile
                        </a>
                    @endunless

                    @if(auth()->user()->is_admin)
                        <a href="/admin" class="hover:text-red-200 transition">
                            Admin Dashboard
                        </a>
                    @else
                        <a href="/dashboard" class="hover:text-red-200 transition">
                            Dashboard
                        </a>
                    @endif

                    <!-- Dark Mode -->

                    <button
                        onclick="toggleDarkMode()"
                        class="bg-white dark:bg-gray-800
                               dark:text-white text-black
                               px-3 py-1 rounded-lg">

                        🌙

                    </button>

                    <!-- Logout -->

                    <form method="POST"
                          action="{{ route('logout') }}">

                        @csrf

                        <button
                            class="hover:text-red-200 transition">

                            Logout

                        </button>

                    </form>

                @else

                    <a href="/login"
                       class="hover:text-red-200 transition">

                        Login

                    </a>

                    <a href="/register"
                       class="bg-white text-red-600
                              px-4 py-2 rounded-xl
                              font-bold hover:bg-red-100
                              transition">

                        Register

                    </a>

                @endauth

            </div>

            <!-- Mobile Menu Button -->

            <button
                id="menu-btn"
                class="md:hidden text-3xl">

                ☰

            </button>

        </div>

        <!-- Mobile Menu -->

        <div
            id="mobile-menu"
            class="hidden flex-col gap-4
                   mt-6 md:hidden">

            <a href="/"
               class="block">

                Home

            </a>

            @unless(auth()->check() && auth()->user()->is_admin)
                <a href="/blood-request"
                   class="block">

                    Emergency Request

                </a>
            @endunless

            <a href="/search"
               class="block">

                Search Donors

            </a>

            @auth

                @unless(auth()->user()->is_admin)
                    <a href="/profile"
                       class="block">

                        Profile

                    </a>
                @endunless

                @if(auth()->user()->is_admin)

                <a href="/admin"
                   class="block">

                    Admin Dashboard

                </a>

                @endif

                <!-- Dark Mode -->

                <button
                    onclick="toggleDarkMode()"
                    class="bg-white text-black
                           px-3 py-2 rounded-lg
                           w-fit">

                    🌙 Dark Mode

                </button>

                <!-- Logout -->

                <form method="POST"
                      action="{{ route('logout') }}">

                    @csrf

                    <button class="block mt-2">

                        Logout

                    </button>

                </form>

            @else

                <a href="/login"
                   class="block">

                    Login

                </a>

                <a href="/register"
                   class="block">

                    Register

                </a>

            @endauth

        </div>

    </div>

</nav>

<!-- Success Message -->

@if(session('success'))

<div class="container mx-auto px-6 mt-6">

    <div
        id="success-alert"
        class="bg-green-100 border border-green-400
               text-green-700 px-4 py-3 rounded-2xl">

        {{ session('success') }}

    </div>

</div>

@endif

<!-- Error Message -->

@if(session('error'))

<div class="container mx-auto px-6 mt-6">

    <div
        id="error-alert"
        class="bg-red-100 border border-red-400
               text-red-700 px-4 py-3 rounded-2xl">

        {{ session('error') }}

    </div>

</div>

@endif

<!-- Main Content -->

<div class="container mx-auto p-6 min-h-screen">

    @yield('content')

</div>

<!-- Footer -->

<footer class="bg-gray-900 dark:bg-black
               text-white mt-20">

    <div class="container mx-auto px-6 py-12">

        <div class="grid md:grid-cols-3 gap-10">

            <!-- About -->

            <div>

                <h2 class="text-3xl font-bold
                           text-red-500 mb-4">

                    E-Blood

                </h2>

                <p class="text-gray-400 leading-7">

                    E-Blood Donation Platform helps
                    patients connect with blood donors
                    quickly during emergencies.

                </p>

            </div>

            <!-- Links -->

            <div>

                <h2 class="text-2xl font-bold mb-4">

                    Quick Links

                </h2>

                <div class="flex flex-col gap-3">

                    <a href="/"
                       class="text-gray-400
                              hover:text-red-500 transition">

                        Home

                    </a>

                    <a href="/blood-request"
                       class="text-gray-400
                              hover:text-red-500 transition">

                        Emergency Request

                    </a>

                    <a href="/search"
                       class="text-gray-400
                              hover:text-red-500 transition">

                        Search Donors

                    </a>

                    @auth

                    @unless(auth()->user()->is_admin)
                        <a href="/profile"
                           class="text-gray-400
                                  hover:text-red-500 transition">

                            Profile

                        </a>
                    @endunless

                    @endif

                </div>

            </div>

            <!-- Contact -->

            <div>

                <h2 class="text-2xl font-bold mb-4">

                    Contact

                </h2>

                <div class="space-y-3 text-gray-400">

                    <p>

                        Email: support@eblood.com

                    </p>

                    <p>

                        Punjab, India

                    </p>

                </div>

            </div>

        </div>

        <!-- Bottom -->

        <div class="border-t border-gray-700
                    mt-10 pt-6 text-center
                    text-gray-500">

            © 2026 E-Blood Donation Platform.
            All rights reserved.

        </div>

    </div>

</footer>

<!-- Scripts -->

<script>

    /*
    |--------------------------------------------------------------------------
    | Loader
    |--------------------------------------------------------------------------
    */

    window.addEventListener('load', () => {

        document.getElementById('loader')
            .style.display = 'none';

    });

    /*
    |--------------------------------------------------------------------------
    | Dark Mode
    |--------------------------------------------------------------------------
    */

    const html =
        document.getElementById('html');

    if(
        localStorage.getItem('darkMode')
        === 'true'
    )
    {
        html.classList.add('dark');
    }

    function toggleDarkMode()
    {
        html.classList.toggle('dark');

        localStorage.setItem(
            'darkMode',
            html.classList.contains('dark')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Mobile Menu
    |--------------------------------------------------------------------------
    */

    const menuBtn =
        document.getElementById('menu-btn');

    const mobileMenu =
        document.getElementById('mobile-menu');

    if(menuBtn && mobileMenu)
    {
        menuBtn.addEventListener('click', () => {

            mobileMenu.classList.toggle('hidden');

        });
    }

    /*
    |--------------------------------------------------------------------------
    | Auto Hide Alerts
    |--------------------------------------------------------------------------
    */

    setTimeout(() => {

        const successAlert =
            document.getElementById(
                'success-alert'
            );

        if(successAlert)
        {
            successAlert.style.display = 'none';
        }

        const errorAlert =
            document.getElementById(
                'error-alert'
            );

        if(errorAlert)
        {
            errorAlert.style.display = 'none';
        }

    }, 3000);

</script>

</body>

</html>