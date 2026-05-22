<!DOCTYPE html>
<html lang="en" id="html">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>E-Blood Donation</title>

    <?php echo app('Illuminate\Foundation\Vite')([
        'resources/css/app.css',
        'resources/js/app.js'
    ]); ?>

</head>

<body class="bg-slate-100 text-slate-900 dark:bg-slate-950 dark:text-slate-100 transition-all duration-300 scroll-smooth">

<!-- Page Loader -->

<!-- Navbar -->

<nav class="bg-red-600 dark:bg-slate-950 text-white shadow-lg sticky top-0 z-40">

    <div class="container mx-auto px-6 py-4">

        <div class="flex justify-between items-center">

            <!-- Logo -->
            <a href="/" class="text-3xl font-extrabold">
                E-Blood
            </a>

            <?php
                $homeUrl = auth()->check()
                    ? (auth()->user()->isAdmin()
                        ? route('admin.home')
                        : (auth()->user()->isRequester() ? route('requester.home') : route('donor.home')))
                    : url('/');
            ?>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-4">

                <a href="<?php echo e($homeUrl); ?>" class="hover:text-red-200 transition duration-200">Home</a>

                <?php if(auth()->guard()->guest()): ?>
                    <a href="/search" class="hover:text-red-200 transition duration-200">Search Donors</a>
                    <a href="/login" class="hover:text-red-200 transition duration-200">Login</a>
                    <a href="/register" class="bg-white text-red-600 px-4 py-2 rounded-xl font-bold hover:bg-red-100 transition duration-200">Register</a>
                <?php endif; ?>

                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.home')); ?>" class="hover:text-red-200 transition duration-200 <?php echo e(request()->is('admin/home') ? 'text-red-200 font-semibold' : ''); ?>">Home</a>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-red-200 transition duration-200 <?php echo e(request()->is('admin') ? 'text-red-200 font-semibold' : ''); ?>">Dashboard</a>
                        <a href="/admin/requests" class="hover:text-red-200 transition duration-200 <?php echo e(request()->is('admin/requests*') ? 'text-red-200 font-semibold' : ''); ?>">Emergency Requests</a>
                    <?php elseif(auth()->user()->isRequester()): ?>
                        <a href="<?php echo e(route('requester.home')); ?>" class="hover:text-red-200 transition duration-200 <?php echo e(request()->is('requester/home') ? 'text-red-200 font-semibold' : ''); ?>">Dashboard</a>
                        <a href="/blood-request" class="hover:text-red-200 transition duration-200">Emergency Request</a>
                        <a href="/my-requests" class="hover:text-red-200 transition duration-200">My Requests</a>
                    <?php elseif(auth()->user()->isDonor()): ?>
                        <a href="/search" class="hover:text-red-200 transition duration-200">Search Donors</a>
                        <a href="<?php echo e(route('donor.home')); ?>" class="hover:text-red-200 transition duration-200 <?php echo e(request()->is('donor/home') ? 'text-red-200 font-semibold' : ''); ?>">Dashboard</a>
                        <a href="/profile" class="hover:text-red-200 transition duration-200">Profile</a>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline ml-2">
                        <?php echo csrf_field(); ?>
                        <button class="bg-red-600 px-4 py-2 rounded-xl text-white hover:bg-red-500 transition duration-200">Logout</button>
                    </form>
                <?php endif; ?>

                <button type="button" class="js-dark-mode-toggle flex items-center justify-center w-10 h-10 rounded-lg border border-slate-300 bg-white text-slate-700 shadow transition duration-300 hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700" aria-label="Toggle dark mode" title="Toggle dark mode">
                    <svg class="dark-mode-icon w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"></svg>
                </button>

            </div>

            <!-- Mobile Menu Button -->
            <button id="menu-btn" class="md:hidden text-3xl focus:outline-none" aria-label="Toggle menu">☰</button>

        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden flex-col gap-3 mt-6 md:hidden">
            <a href="<?php echo e($homeUrl); ?>" class="block px-3 py-2 rounded-lg hover:bg-red-700 hover:bg-opacity-75">Home</a>

            <?php if(auth()->guard()->guest()): ?>
                <a href="/search" class="block px-3 py-2 rounded-lg hover:bg-red-700 hover:bg-opacity-75">Search Donors</a>
                <a href="/login" class="block px-3 py-2 rounded-lg hover:bg-red-700 hover:bg-opacity-75">Login</a>
                <a href="/register" class="block px-3 py-2 rounded-lg bg-white text-red-600 font-bold hover:bg-red-100">Register</a>
            <?php endif; ?>

            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->isAdmin()): ?>
                    <a href="<?php echo e(route('admin.home')); ?>" class="block px-3 py-2 rounded-lg <?php echo e(request()->is('admin/home') ? 'bg-red-700' : 'hover:bg-red-700 hover:bg-opacity-75'); ?>">Home</a>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-3 py-2 rounded-lg <?php echo e(request()->is('admin') ? 'bg-red-700' : 'hover:bg-red-700 hover:bg-opacity-75'); ?>">Dashboard</a>
                    <a href="/admin/requests" class="block px-3 py-2 rounded-lg <?php echo e(request()->is('admin/requests*') ? 'bg-red-700' : 'hover:bg-red-700 hover:bg-opacity-75'); ?>">Emergency Requests</a>
                <?php elseif(auth()->user()->isRequester()): ?>
                    <a href="<?php echo e(route('requester.home')); ?>" class="block px-3 py-2 rounded-lg <?php echo e(request()->is('requester/home') ? 'bg-red-700' : 'hover:bg-red-700 hover:bg-opacity-75'); ?>">Dashboard</a>
                    <a href="/blood-request" class="block px-3 py-2 rounded-lg hover:bg-red-700 hover:bg-opacity-75">Emergency Request</a>
                    <a href="/my-requests" class="block px-3 py-2 rounded-lg hover:bg-red-700 hover:bg-opacity-75">My Requests</a>
                <?php elseif(auth()->user()->isDonor()): ?>
                    <a href="/search" class="block px-3 py-2 rounded-lg hover:bg-red-700 hover:bg-opacity-75">Search Donors</a>
                    <a href="<?php echo e(route('donor.home')); ?>" class="block px-3 py-2 rounded-lg <?php echo e(request()->is('donor/home') ? 'bg-red-700' : 'hover:bg-red-700 hover:bg-opacity-75'); ?>">Dashboard</a>
                    <a href="/profile" class="block px-3 py-2 rounded-lg hover:bg-red-700 hover:bg-opacity-75">Profile</a>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('logout')); ?>" class="w-full">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full px-3 py-2 rounded-lg bg-red-600 text-white hover:bg-red-500">Logout</button>
                </form>

                <button type="button" class="js-dark-mode-toggle w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                    <svg class="dark-mode-icon w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"></svg>
                    <span>Theme</span>
                </button>
            <?php endif; ?>

        </div>

    </div>

</nav>

<!-- Success Message -->

<?php if(session('success')): ?>

<div class="container mx-auto px-6 mt-6">

    <div
        id="success-alert"
        class="bg-green-100 border border-green-400
               text-green-700 px-4 py-3 rounded-2xl">

        <?php echo e(session('success')); ?>


    </div>

</div>

<?php endif; ?>

<!-- Error Message -->

<?php if(session('error')): ?>

<div class="container mx-auto px-6 mt-6">

    <div
        id="error-alert"
        class="bg-red-100 border border-red-400
               text-red-700 px-4 py-3 rounded-2xl">

        <?php echo e(session('error')); ?>


    </div>

</div>

<?php endif; ?>

<!-- Main Content -->

<div class="container mx-auto p-6 min-h-screen">

    <?php echo $__env->yieldContent('content'); ?>

</div>

<!-- Footer -->

<footer class="bg-gradient-to-r from-gray-900 to-black text-white mt-20">
    <div class="container mx-auto px-6 py-12">
        <div class="grid md:grid-cols-4 gap-8">

            <div>
                <h3 class="text-2xl font-bold text-red-500">E-Blood</h3>
                <p class="text-gray-400 mt-3">Connecting patients with donors quickly during emergencies. Give blood, save lives.</p>

                <p class="mt-4 italic text-sm text-gray-400">"Donate blood, be someone's hero."</p>
            </div>

            <div>
                <h4 class="font-semibold mb-3">Quick Links</h4>
                <ul class="space-y-2 text-gray-300">
                    <li><a href="/" class="hover:text-red-400">Home</a></li>
                    <li><a href="/search" class="hover:text-red-400">Search Donors</a></li>
                    <li><a href="/blood-request" class="hover:text-red-400">Emergency Request</a></li>
                    <?php if(auth()->guard()->check()): ?>
                        <?php if (! (auth()->user()->isAdmin())): ?>
                            <li><a href="/profile" class="hover:text-red-400">Profile</a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold mb-3">Contact</h4>
                <p class="text-gray-300">Email: support@eblood.com</p>
                <p class="text-gray-300 mt-1">Punjab, India</p>
                <div class="flex gap-3 mt-4">
                    <!-- Social icons -->
                    <a href="#" class="text-gray-300 hover:text-red-400" aria-label="Twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557a9.83 9.83 0 0 1-2.828.775 4.93 4.93 0 0 0 2.165-2.724 9.86 9.86 0 0 1-3.127 1.195 4.916 4.916 0 0 0-8.38 4.482A13.94 13.94 0 0 1 1.671 3.149a4.916 4.916 0 0 0 1.523 6.574 4.897 4.897 0 0 1-2.229-.616c-.054 2.281 1.581 4.415 3.949 4.89a4.935 4.935 0 0 1-2.224.084 4.918 4.918 0 0 0 4.588 3.417A9.867 9.867 0 0 1 0 21.542a13.94 13.94 0 0 0 7.548 2.212c9.058 0 14.01-7.514 14.01-14.01 0-.213-.005-.425-.015-.636A10.012 10.012 0 0 0 24 4.557z"/></svg>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-red-400" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2.2V12h2.2V9.8c0-2.2 1.3-3.4 3.3-3.4.95 0 1.95.17 1.95.17v2.14h-1.1c-1.1 0-1.45.69-1.45 1.4V12h2.5l-.4 2.9h-2.1v7A10 10 0 0 0 22 12z"/></svg>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-red-400" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7zm10 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/></svg>
                    </a>
                </div>
            </div>

        </div>

        <div class="border-t border-gray-800 mt-8 pt-6 text-center text-gray-400">
            <div class="md:flex md:justify-between md:items-center">
                <div>© <?php echo e(date('Y')); ?> E-Blood Donation Platform. All rights reserved.</div>
                <div class="mt-3 md:mt-0">Made with ❤️ to save lives.</div>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->

<script>

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

<?php echo $__env->yieldPushContent('scripts'); ?>

</body>

</html><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views/layouts/app.blade.php ENDPATH**/ ?>