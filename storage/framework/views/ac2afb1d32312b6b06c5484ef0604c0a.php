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

<body class="min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 transition-all duration-300 antialiased">
    <div id="page-loader" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/90 backdrop-blur-xl transition-all duration-300">
        <div class="flex flex-col items-center gap-3 text-center">
            <div class="h-16 w-16 rounded-full border-4 border-red-500 border-t-transparent animate-spin"></div>
            <p class="text-sm text-white/90">Loading your care dashboard…</p>
        </div>
    </div>

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
                <?php if(auth()->guard()->guest()): ?>
                    <a href="/" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Home</a>
                    <a href="/login" class="rounded-full px-4 py-2 bg-red-600 text-white hover:bg-red-700">Login</a>
                    <a href="/register" class="rounded-full px-4 py-2 border border-slate-300 text-slate-700 hover:border-red-500 hover:text-red-600 dark:border-slate-700 dark:text-slate-200">Register</a>
                <?php else: ?>
                    <?php if(auth()->user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.home')); ?>" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Home</a>
                        <a href="/admin/requests" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Requests</a>
                    <?php elseif(auth()->user()->isRequester()): ?>
                        <a href="<?php echo e(route('requester.home')); ?>" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Home</a>
                        <a href="<?php echo e(route('requester.search.index')); ?>" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Search Donors</a>
                        <a href="<?php echo e(route('requester.requests.create')); ?>" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Emergency Request</a>
                        <a href="<?php echo e(route('requester.requests.index')); ?>" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">My Requests</a>
                        <a href="/profile" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Profile</a>
                    <?php elseif(auth()->user()->isDonor()): ?>
                        <a href="<?php echo e(route('donor.home')); ?>" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Home</a>
                        <a href="/profile" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Profile</a>
                        <a href="/profile#availability" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Availability</a>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
                        <?php echo csrf_field(); ?>
                        <button class="rounded-full px-4 py-2 bg-red-600 text-white hover:bg-red-700">Logout</button>
                    </form>
                <?php endif; ?>
            </div>

            <div class="flex items-center gap-3">
                <div class="relative">
                    <button id="notification-toggle" type="button" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-red-300 hover:text-red-600 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:hover:border-red-500/60">
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>
                        <span>Alerts</span>
                        <span id="notification-badge" class="hidden rounded-full bg-red-600 px-2 py-0.5 text-[11px] font-bold text-white">0</span>
                    </button>
                    <div id="notification-dropdown" class="hidden absolute right-0 top-[calc(100%+0.75rem)] z-[60] flex max-h-[24rem] w-[22rem] max-w-[calc(100vw-2rem)] flex-col overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white/95 p-4 shadow-[0_30px_80px_-40px_rgba(15,23,42,0.4)] backdrop-blur-xl dark:border-slate-700 dark:bg-slate-950/95">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">Notification center</p>
                                <p class="text-xs text-slate-500 dark:text-slate-300">Unread updates stay visible until marked read.</p>
                            </div>
                            <button id="mark-all-read" type="button" class="text-xs font-semibold text-red-600 hover:text-red-700">Mark all read</button>
                        </div>
                        <div id="notification-list" class="mt-4 flex-1 space-y-3 overflow-y-auto pr-1"></div>
                    </div>
                </div>
                <button type="button" class="js-dark-mode-toggle inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-300 bg-white text-slate-700 shadow transition duration-300 hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700" aria-label="Toggle dark mode" title="Toggle dark mode">
                    <svg class="dark-mode-icon w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"></svg>
                </button>

                <button id="menu-btn" class="md:hidden inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-lg text-slate-900 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-white" aria-label="Toggle menu">☰</button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden flex-col gap-3 px-4 pb-4 md:hidden">
            <?php if(auth()->guard()->guest()): ?>
                <a href="/" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Home</a>
                <a href="/login" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Login</a>
                <a href="/register" class="block rounded-2xl bg-white px-4 py-3 text-center text-red-600 font-semibold hover:bg-slate-100 dark:bg-slate-900 dark:text-white">Register</a>
            <?php else: ?>
                <?php if(auth()->user()->isAdmin()): ?>
                    <a href="<?php echo e(route('admin.home')); ?>" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Home</a>
                    <a href="/admin/requests" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Requests</a>
                <?php elseif(auth()->user()->isRequester()): ?>
                    <a href="<?php echo e(route('requester.home')); ?>" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Home</a>
                    <a href="<?php echo e(route('requester.search.index')); ?>" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Search Donors</a>
                    <a href="<?php echo e(route('requester.requests.create')); ?>" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Emergency Request</a>
                    <a href="<?php echo e(route('requester.requests.index')); ?>" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">My Requests</a>
                    <a href="/profile" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Profile</a>
                <?php elseif(auth()->user()->isDonor()): ?>
                    <a href="<?php echo e(route('donor.home')); ?>" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Home</a>
                    <a href="/profile" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Profile</a>
                    <a href="/profile#availability" class="block rounded-2xl px-4 py-3 text-slate-900 hover:bg-red-100 hover:text-red-700 dark:text-slate-100 dark:hover:bg-slate-800">Availability</a>
                <?php endif; ?>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="w-full">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full rounded-2xl bg-red-600 px-4 py-3 text-sm font-semibold text-white hover:bg-red-700">Logout</button>
                </form>
                <button type="button" class="js-dark-mode-toggle w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-left text-slate-900 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:hover:bg-slate-800">Toggle theme</button>
            <?php endif; ?>
        </div>
    </nav>

    <?php if (! empty(trim($__env->yieldContent('hero')))): ?>
        <section class="relative overflow-hidden px-4 py-8 sm:py-10">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(239,68,68,0.16),transparent_30%),radial-gradient(circle_at_bottom_right,_rgba(59,130,246,0.14),transparent_28%)]"></div>
            <div class="relative container mx-auto px-4">
                <?php echo $__env->yieldContent('hero'); ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if(session('success') || session('error')): ?>
        <div class="container mx-auto px-4 mt-6">
            <?php if(session('success')): ?>
                <div id="success-alert" class="glass-card border-green-400/40 bg-green-50/80 text-green-800 px-5 py-4">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div id="error-alert" class="glass-card border-red-400/40 bg-red-50/80 text-red-800 px-5 py-4">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <main class="container mx-auto px-4 pb-16">
        <div class="fade-in-up">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
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
                        <?php if(auth()->check() && auth()->user()->isRequester()): ?>
                            <li><a href="<?php echo e(route('requester.search.index')); ?>" class="hover:text-red-400">Search Donors</a></li>
                        <?php endif; ?>
                        <?php if(auth()->guard()->check()): ?>
                            <?php if(auth()->user()->isRequester()): ?>
                                <li><a href="<?php echo e(route('requester.requests.create')); ?>" class="hover:text-red-400">Emergency Request</a></li>
                            <?php endif; ?>
                            <?php if (! (auth()->user()->isAdmin())): ?>
                                <li><a href="/profile" class="hover:text-red-400">Profile</a></li>
                            <?php endif; ?>
                        <?php endif; ?>
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
                    <div>© <?php echo e(date('Y')); ?> E-Blood Donation Platform. All rights reserved.</div>
                    <div class="mt-3 md:mt-0">Made with ❤️ to save lives.</div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        setTimeout(() => {
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                successAlert.style.display = 'none';
            }
            const errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                errorAlert.style.display = 'none';
            }
        }, 3000);
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views\layouts\app.blade.php ENDPATH**/ ?>