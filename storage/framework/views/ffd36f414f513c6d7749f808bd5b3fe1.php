

<?php $__env->startSection('content'); ?>

<div class="container mx-auto p-6">
    <div class="section-panel dark:section-panel-dark">
        <h1 class="text-3xl font-semibold mb-4 text-red-600">Request Details</h1>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <p><strong>Patient:</strong> <?php echo e($req->patient_name); ?></p>
                <p><strong>Phone:</strong> <?php echo e($req->phone); ?></p>
                <p><strong>Blood Group:</strong> <?php echo e($req->blood_group); ?></p>
                <p><strong>Hospital:</strong> <?php echo e($req->hospital); ?></p>
                <p><strong>City:</strong> <?php echo e($req->city); ?></p>
                <p class="mt-2"><strong>Message:</strong><br><?php echo e($req->message ?? '-'); ?></p>
            </div>

            <div>
                <p><strong>Submitted:</strong> <?php echo e(optional($req->created_at)->format('Y-m-d H:i')); ?></p>
                <p class="mt-4"><strong>Status:</strong></p>
                <?php $status = $req->status ?? 'Pending'; ?>
                <div class="mt-2">
                    <?php if($status == 'Pending'): ?>
                        <span class="bg-yellow-400 text-black px-3 py-1 rounded-full">Pending</span>
                    <?php elseif($status == 'Approved'): ?>
                        <span class="bg-blue-500 text-white px-3 py-1 rounded-full">Approved</span>
                    <?php elseif($status == 'Completed'): ?>
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full">Completed</span>
                    <?php else: ?>
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full">Rejected</span>
                    <?php endif; ?>
                </div>

                <?php if($req->admin_message): ?>
                    <div class="mt-6 rounded-3xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-950">
                        <p class="font-semibold text-slate-900 dark:text-slate-100">Admin Response</p>
                        <p class="mt-3 text-slate-700 dark:text-slate-200 whitespace-pre-line"><?php echo e($req->admin_message); ?></p>
                        <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">Status updated <?php echo e(optional($req->status_updated_at)->format('Y-m-d H:i')); ?></p>
                    </div>
                <?php endif; ?>

            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views/request-detail.blade.php ENDPATH**/ ?>