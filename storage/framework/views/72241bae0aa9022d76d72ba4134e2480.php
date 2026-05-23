<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <div class="rounded-[2rem] border border-slate-200 bg-gradient-to-br from-white via-red-50 to-rose-100 p-6 shadow-sm dark:border-slate-700 dark:from-slate-900 dark:via-slate-900 dark:to-rose-950/60">
        <div class="flex flex-col gap-6 xl:flex-row xl:items-end xl:justify-between">
            <div class="max-w-2xl">
                <p class="inline-flex rounded-full bg-red-100 px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-red-700 dark:bg-red-950/80 dark:text-red-200">Admin home</p>
                <h1 class="mt-4 text-3xl font-bold text-slate-900 dark:text-white sm:text-4xl">Welcome back, <?php echo e($admin->name); ?>.</h1>
                <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300">
                    Review the latest system activity, keep emergency requests moving, and jump into donor or requester management in one place.
                </p>
            </div>

            <div class="rounded-[1.5rem] border border-white/80 bg-white/85 px-5 py-4 shadow-sm backdrop-blur dark:border-slate-700 dark:bg-slate-950/80">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500 dark:text-slate-400">Account</p>
                <p class="mt-3 text-lg font-semibold text-slate-900 dark:text-white"><?php echo e($admin->email); ?></p>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Admin since <?php echo e(optional($admin->created_at)->format('M d, Y')); ?></p>
            </div>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-300">Total donors</p>
            <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-white"><?php echo e(number_format($totalDonors)); ?></p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Verified donor records in the platform.</p>
        </div>

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-300">Available donors</p>
            <p class="mt-3 text-3xl font-bold text-emerald-600"><?php echo e(number_format($availableDonors)); ?></p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Ready for emergency matching.</p>
        </div>

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-300">Requests received</p>
            <p class="mt-3 text-3xl font-bold text-amber-500"><?php echo e(number_format($totalRequests)); ?></p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Emergency requests currently in the system.</p>
        </div>

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-300">Pending requests</p>
            <p class="mt-3 text-3xl font-bold text-rose-600"><?php echo e(number_format($pendingRequests)); ?></p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Needs review or donor assignment.</p>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-2">
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-red-600">Quick actions</p>
                    <h2 class="mt-2 text-xl font-bold text-slate-900 dark:text-white">Jump to the right workflow</h2>
                </div>
            </div>
            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="rounded-[1.5rem] border border-slate-200 p-4 transition hover:border-red-300 hover:bg-red-50 dark:border-slate-700 dark:hover:border-red-500 dark:hover:bg-slate-800">
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">Open analytics</p>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Review charts, donor coverage, and requester demand.</p>
                </a>
                <a href="<?php echo e(route('admin.requests.index')); ?>" class="rounded-[1.5rem] border border-slate-200 p-4 transition hover:border-red-300 hover:bg-red-50 dark:border-slate-700 dark:hover:border-red-500 dark:hover:bg-slate-800">
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">Manage requests</p>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Review open cases and update request statuses.</p>
                </a>
                <a href="<?php echo e(route('admin.donors.index')); ?>" class="rounded-[1.5rem] border border-slate-200 p-4 transition hover:border-red-300 hover:bg-red-50 dark:border-slate-700 dark:hover:border-red-500 dark:hover:bg-slate-800">
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">Manage donors</p>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Audit donor records and support quick cleanup.</p>
                </a>
                <a href="<?php echo e(route('admin.requesters.index')); ?>" class="rounded-[1.5rem] border border-slate-200 p-4 transition hover:border-red-300 hover:bg-red-50 dark:border-slate-700 dark:hover:border-red-500 dark:hover:bg-slate-800">
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">Manage requesters</p>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Review requester profiles and their activity.</p>
                </a>
            </div>
        </div>

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-red-600">Shortcuts</p>
                    <h2 class="mt-2 text-xl font-bold text-slate-900 dark:text-white">One-tap navigation</h2>
                </div>
            </div>
            <div class="mt-5 space-y-3">
                <a href="<?php echo e(route('admin.home')); ?>" class="flex items-center justify-between rounded-[1.25rem] border border-slate-200 px-4 py-3 transition hover:border-red-200 hover:bg-red-50 dark:border-slate-700 dark:hover:border-red-500 dark:hover:bg-slate-800">
                    <span class="text-sm font-semibold text-slate-900 dark:text-white">Admin home</span>
                    <span class="text-red-600">→</span>
                </a>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center justify-between rounded-[1.25rem] border border-slate-200 px-4 py-3 transition hover:border-red-200 hover:bg-red-50 dark:border-slate-700 dark:hover:border-red-500 dark:hover:bg-slate-800">
                    <span class="text-sm font-semibold text-slate-900 dark:text-white">Analytics dashboard</span>
                    <span class="text-red-600">→</span>
                </a>
                <a href="<?php echo e(route('admin.requests.index')); ?>" class="flex items-center justify-between rounded-[1.25rem] border border-slate-200 px-4 py-3 transition hover:border-red-200 hover:bg-red-50 dark:border-slate-700 dark:hover:border-red-500 dark:hover:bg-slate-800">
                    <span class="text-sm font-semibold text-slate-900 dark:text-white">Emergency requests</span>
                    <span class="text-red-600">→</span>
                </a>
                <a href="<?php echo e(route('admin.donors.index')); ?>" class="flex items-center justify-between rounded-[1.25rem] border border-slate-200 px-4 py-3 transition hover:border-red-200 hover:bg-red-50 dark:border-slate-700 dark:hover:border-red-500 dark:hover:bg-slate-800">
                    <span class="text-sm font-semibold text-slate-900 dark:text-white">Donor records</span>
                    <span class="text-red-600">→</span>
                </a>
            </div>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-2">
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Latest donor activity</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">Fresh donor registrations and profile updates.</p>
                </div>
                <a href="<?php echo e(route('admin.donors.index')); ?>" class="text-sm font-semibold text-red-600">View all donors</a>
            </div>
            <div class="mt-5 space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $latestDonors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="rounded-[1.25rem] border border-slate-200 px-4 py-3 dark:border-slate-700">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <p class="font-semibold text-slate-900 dark:text-white"><?php echo e($donor->name); ?></p>
                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-300"><?php echo e($donor->email); ?></p>
                            </div>
                            <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700 dark:bg-emerald-950/70 dark:text-emerald-200"><?php echo e($donor->blood_group ?? 'Unknown'); ?></span>
                        </div>
                        <div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-slate-500 dark:text-slate-300">
                            <span><?php echo e($donor->city ?? 'Unknown city'); ?></span>
                            <span aria-hidden="true">•</span>
                            <span><?php echo e(optional($donor->created_at)->diffForHumans() ?? 'just now'); ?></span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-slate-500 dark:text-slate-300">No new donor activity yet.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Latest request activity</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">The most recent emergency requests and their current status.</p>
                </div>
                <a href="<?php echo e(route('admin.requests.index')); ?>" class="text-sm font-semibold text-red-600">Review requests</a>
            </div>
            <div class="mt-5 space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="rounded-[1.25rem] border border-slate-200 px-4 py-3 dark:border-slate-700">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <p class="font-semibold text-slate-900 dark:text-white"><?php echo e($request->patient_name ?? 'Anonymous patient'); ?></p>
                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-300"><?php echo e(optional($request->user)->email ?? 'Requester unavailable'); ?></p>
                            </div>
                            <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-slate-700 dark:bg-slate-800 dark:text-slate-100"><?php echo e($request->status ?? 'Pending'); ?></span>
                        </div>
                        <div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-slate-500 dark:text-slate-300">
                            <span><?php echo e($request->blood_group ?? 'Unknown'); ?></span>
                            <span aria-hidden="true">•</span>
                            <span><?php echo e($request->city ?? 'Unknown city'); ?></span>
                            <span aria-hidden="true">•</span>
                            <span><?php echo e(optional($request->updated_at)->diffForHumans() ?? 'just now'); ?></span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-slate-500 dark:text-slate-300">No recent request activity yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views\admin\home.blade.php ENDPATH**/ ?>