

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-6 py-8">
    <div class="mb-8 section-panel dark:section-panel-dark">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-2xl">
                <p class="mb-3 inline-flex rounded-full bg-red-100 px-4 py-1 text-sm font-semibold uppercase tracking-[0.3em] text-red-700 dark:bg-red-900 dark:text-red-300">Admin Home</p>
                <h1 class="text-3xl font-semibold text-slate-900 dark:text-slate-100 sm:text-4xl">Welcome back, <?php echo e($admin->name); ?>.</h1>
                <p class="mt-4 max-w-2xl text-slate-600 dark:text-slate-300">Monitor donor availability, review recent requests, and take action from your admin dashboard in one place.</p>
            </div>
            <div class="card-panel dark:card-panel-dark text-slate-900 dark:text-slate-100">
                <p class="text-sm uppercase tracking-[0.24em] text-slate-500 dark:text-slate-400">Account</p>
                <p class="mt-4 text-2xl font-semibold"><?php echo e($admin->email); ?></p>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Admin since <?php echo e(optional($admin->created_at)->format('M d, Y')); ?></p>
            </div>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-4">
        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Donors</p>
            <p class="mt-4 text-3xl font-semibold text-slate-900 dark:text-slate-100"><?php echo e(number_format($totalDonors)); ?></p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">All donors currently registered.</p>
        </div>
        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Available Donors</p>
            <p class="mt-4 text-3xl font-semibold text-slate-900 dark:text-slate-100"><?php echo e(number_format($availableDonors)); ?></p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Donors marked as available for emergency matches.</p>
        </div>
        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Requests Received</p>
            <p class="mt-4 text-3xl font-semibold text-slate-900 dark:text-slate-100"><?php echo e(number_format($totalRequests)); ?></p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Total active blood requests across the system.</p>
        </div>
        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Pending Requests</p>
            <p class="mt-4 text-3xl font-semibold text-slate-900 dark:text-slate-100"><?php echo e(number_format($pendingRequests)); ?></p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Requests waiting for review or donor assignment.</p>
        </div>
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-3">
        <a href="/admin" class="group card-panel dark:card-panel-dark transition hover:-translate-y-1 hover:border-red-300 hover:bg-red-50 dark:hover:border-red-500 dark:hover:bg-slate-800">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">View admin dashboard</p>
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-200">→</span>
            </div>
            <p class="mt-4 text-sm text-slate-500 dark:text-slate-400">Open the full analytics page and monitor trends, blood group distribution, and city request patterns.</p>
        </a>
        <a href="/admin" class="group card-panel dark:card-panel-dark transition hover:-translate-y-1 hover:border-red-300 hover:bg-red-50 dark:hover:border-red-500 dark:hover:bg-slate-800">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">Manage emergency requests</p>
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-200">→</span>
            </div>
            <p class="mt-4 text-sm text-slate-500 dark:text-slate-400">Review recent blood requests, approve urgent cases, and assign donors quickly.</p>
        </a>
        <a href="/admin" class="group card-panel dark:card-panel-dark transition hover:-translate-y-1 hover:border-red-300 hover:bg-red-50 dark:hover:border-red-500 dark:hover:bg-slate-800">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">Review latest donors</p>
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-200">→</span>
            </div>
            <p class="mt-4 text-sm text-slate-500 dark:text-slate-400">See the most recent donor registrations and confirm availability for matches.</p>
        </a>
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-2">
        <div class="card-panel dark:card-panel-dark">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Latest donor signups</h2>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Recent registrations waiting for review.</p>
                </div>
            </div>
            <div class="mt-6 space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $latestDonors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="card-panel dark:card-panel-dark">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="font-medium text-slate-900 dark:text-slate-100"><?php echo e($donor->name); ?></p>
                                <p class="text-sm text-slate-500 dark:text-slate-400"><?php echo e($donor->email); ?></p>
                            </div>
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200"><?php echo e(ucfirst($donor->blood_group ?? 'N/A')); ?></span>
                        </div>
                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Joined <?php echo e(optional($donor->created_at)->diffForHumans()); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-slate-500 dark:text-slate-400">No recent donor registrations yet.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card-panel dark:card-panel-dark">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Recent request activity</h2>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Latest request updates and statuses.</p>
                </div>
            </div>
            <div class="mt-6 space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="card-panel dark:card-panel-dark">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="font-medium text-slate-900 dark:text-slate-100"><?php echo e($request->patient_name ?? 'Request #' . $request->_id); ?></p>
                                <p class="text-sm text-slate-500 dark:text-slate-400"><?php echo e($request->blood_type ?? $request->blood_group ?? 'Unknown blood group'); ?></p>
                            </div>
                            <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-yellow-700 dark:bg-yellow-900 dark:text-yellow-200"><?php echo e($request->status ?? 'Pending'); ?></span>
                        </div>
                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Updated <?php echo e(optional($request->updated_at)->diffForHumans()); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-slate-500 dark:text-slate-400">No recent request updates yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views\admin\home.blade.php ENDPATH**/ ?>