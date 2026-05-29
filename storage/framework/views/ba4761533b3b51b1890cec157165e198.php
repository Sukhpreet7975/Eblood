

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-red-600">Admin</p>
            <h1 class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">Manage users</h1>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Review accounts, enable donor mode, or suspend users.</p>
        </div>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-red-300 hover:text-red-600 dark:border-slate-700 dark:text-slate-100">Back to dashboard</a>
    </div>

    <div class="grid gap-4 md:grid-cols-[1fr_260px] items-end">
        <form method="GET" action="<?php echo e(route('admin.users.index')); ?>" class="grid gap-3 sm:grid-cols-[1fr_auto] items-end">
            <div>
                <label for="search" class="sr-only">Search users</label>
                <input id="search" name="search" value="<?php echo e($search ?? ''); ?>" placeholder="Search by name, email, or city" class="form-field dark:form-field-dark w-full" type="search">
            </div>
            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-red-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-red-700">Search</button>
        </form>

        <form method="GET" action="<?php echo e(route('admin.users.index')); ?>" class="flex items-center gap-3">
            <input type="hidden" name="search" value="<?php echo e($search ?? ''); ?>">
            <label for="filter" class="text-sm font-semibold text-slate-700 dark:text-slate-300">Filter</label>
            <select id="filter" name="filter" onchange="this.form.submit()" class="form-field dark:form-field-dark rounded-full px-4 py-3 text-sm">
                <?php $__currentLoopData = ['all' => 'All users', 'donors' => 'Donor-enabled', 'non-donors' => 'Non-donor users']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($k); ?>" <?php if(($filter ?? 'all') == $k): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <label for="per_page" class="text-sm font-semibold text-slate-700 dark:text-slate-300">Show</label>
            <select id="per_page" name="per_page" onchange="this.form.submit()" class="form-field dark:form-field-dark rounded-full px-4 py-3 text-sm">
                <?php $__currentLoopData = [12,25,50,100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($size); ?>" <?php if(($perPage ?? 25) == $size): echo 'selected'; endif; ?>><?php echo e($size); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </form>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 dark:border-slate-700 dark:bg-slate-950/30 dark:text-slate-300">
        Showing <?php echo e($users->firstItem() ?? 0); ?> to <?php echo e($users->lastItem() ?? 0); ?> of <?php echo e($users->total()); ?> users.
    </div>

    <div class="overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-950/80">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700 dark:text-slate-100">Name</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700 dark:text-slate-100">Email</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700 dark:text-slate-100">City</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700 dark:text-slate-100">Donor</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700 dark:text-slate-100">Requests</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700 dark:text-slate-100">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-4 py-4 text-sm text-slate-900 dark:text-white"><?php echo e($user->name ?? 'Unknown'); ?></td>
                            <td class="px-4 py-4 text-sm text-slate-600 dark:text-slate-300"><?php echo e($user->email ?? 'No email'); ?></td>
                            <td class="px-4 py-4 text-sm text-slate-600 dark:text-slate-300"><?php echo e($user->city ?? 'Unknown city'); ?></td>
                            <td class="px-4 py-4 text-sm text-slate-600 dark:text-slate-300"><?php echo e($user->is_donor ? 'Yes' : 'No'); ?></td>
                            <td class="px-4 py-4 text-sm text-slate-600 dark:text-slate-300"><?php echo e($user->requests()->count()); ?></td>
                            <td class="px-4 py-4 text-sm">
                                <form method="POST" action="<?php echo e(route('admin.users.toggle-donor', $user->_id)); ?>" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button class="mr-3 text-sm font-semibold text-sky-600 hover:text-sky-700"><?php echo e($user->is_donor ? 'Disable donor' : 'Enable donor'); ?></button>
                                </form>

                                <form method="POST" action="<?php echo e(route('admin.users.suspend', $user->_id)); ?>" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button class="mr-3 text-sm font-semibold text-amber-600 hover:text-amber-700"><?php echo e($user->suspended ? 'Unsuspend' : 'Suspend'); ?></button>
                                </form>

                                <a href="<?php echo e(route('admin.delete-user', $user->_id)); ?>" class="font-semibold text-rose-600 hover:text-rose-700" onclick="return confirm('Delete this user account?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-sm text-slate-500 dark:text-slate-300">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-200 px-4 py-4 dark:border-slate-700">
            <?php echo e($users->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views/admin/manage-users.blade.php ENDPATH**/ ?>