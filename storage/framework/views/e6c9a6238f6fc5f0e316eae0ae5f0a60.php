<nav class="bg-white/95 border-b border-slate-200/70 backdrop-blur-xl shadow-sm dark:bg-slate-950/95 dark:border-slate-700/70">
    <div class="container mx-auto flex flex-wrap items-center justify-between gap-3 px-4 py-4">
        <a href="/" class="flex items-center gap-3 font-semibold text-slate-900 dark:text-white">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-red-600 text-white shadow-lg">E</span>
            <div class="leading-tight">
                <span class="block text-lg">E-Blood</span>
                <span class="block text-xs text-slate-500 dark:text-slate-400">Emergency support</span>
            </div>
        </a>

        <div class="flex flex-wrap items-center gap-3 text-sm">
            <?php if(auth()->guard()->guest()): ?>
                <a href="/" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Home</a>
                <a href="/login" class="rounded-full px-4 py-2 bg-red-600 text-white hover:bg-red-700">Login</a>
                <a href="/register" class="rounded-full px-4 py-2 border border-slate-300 text-slate-700 hover:border-red-500 hover:text-red-600 dark:border-slate-700 dark:text-slate-200">Register</a>
            <?php else: ?>
                <?php if(Auth::user()->isAdmin()): ?>
                    <a href="<?php echo e(route('admin.home')); ?>" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Home</a>
                    <a href="/admin/requests" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Requests</a>
                <?php elseif(Auth::user()->isRequester()): ?>
                    <a href="<?php echo e(route('requester.home')); ?>" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Home</a>
                    <a href="<?php echo e(route('requester.search.index')); ?>" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Search Donors</a>
                    <a href="<?php echo e(route('requester.requests.create')); ?>" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Emergency Request</a>
                    <a href="<?php echo e(route('requester.requests.index')); ?>" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">My Requests</a>
                    <a href="/profile" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Profile</a>
                <?php elseif(Auth::user()->isDonor()): ?>
                    <a href="<?php echo e(route('donor.home')); ?>" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Home</a>
                    <a href="/profile" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Profile</a>
                    <a href="/profile#availability" class="rounded-full px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 dark:text-slate-200 dark:hover:bg-slate-800">Availability</a>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="rounded-full px-4 py-2 bg-red-600 text-white hover:bg-red-700">Logout</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</nav><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views\layouts\navigation.blade.php ENDPATH**/ ?>