

<?php $__env->startSection('content'); ?>

<div class="container mx-auto p-6">

    <h1 class="text-3xl font-bold mb-6 text-red-600">My Requests</h1>

    <?php if(session('success')): ?>
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-4"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if($requests->count() == 0): ?>
        <div class="card-panel dark:card-panel-dark text-center">
            <h2 class="text-xl font-semibold">No requests yet</h2>
            <p class="text-gray-500 mt-2">You haven't submitted any emergency requests. Use the button below to create one.</p>
            <a href="<?php echo e(route('requester.requests.create')); ?>" class="mt-4 inline-block bg-red-600 text-white px-6 py-2 rounded-lg">Create Request</a>
        </div>
    <?php else: ?>

        <div class="grid gap-4">
            <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card-panel dark:card-panel-dark flex flex-col md:flex-row justify-between gap-4">
                    <div>
                        <h3 class="font-semibold text-lg"><?php echo e($request->patient_name); ?></h3>
                        <p class="text-gray-500"><?php echo e($request->blood_group); ?> • <?php echo e($request->hospital); ?> • <?php echo e($request->city); ?></p>
                        <p class="mt-2 text-sm text-gray-700 dark:text-gray-300"><?php echo e($request->message ?? '-'); ?></p>
                        <p class="mt-2 text-xs text-gray-400">Submitted: <?php echo e(optional($request->created_at)->format('Y-m-d H:i')); ?></p>
                    </div>

                    <div class="flex flex-col items-start md:items-end gap-2">
                        <?php $status = $request->status ?? 'Pending'; ?>
                        <?php if($status == 'Pending'): ?>
                            <span class="bg-yellow-400 text-black px-3 py-1 rounded-full">Pending</span>
                        <?php elseif($status == 'Approved'): ?>
                            <span class="bg-blue-500 text-white px-3 py-1 rounded-full">Approved</span>
                        <?php elseif($status == 'Completed'): ?>
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full">Completed</span>
                        <?php else: ?>
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full">Rejected</span>
                        <?php endif; ?>

                        <?php if($request->admin_message): ?>
                            <div class="mt-3 w-full card-panel dark:card-panel-dark text-sm text-slate-700 dark:text-slate-200">
                                <p class="font-semibold">Admin Response</p>
                                <p class="mt-2 whitespace-pre-line"><?php echo e($request->admin_message); ?></p>
                                <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Updated <?php echo e(optional($request->status_updated_at)->format('Y-m-d H:i')); ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="flex gap-2 mt-2">
                            <a href="<?php echo e(route('requester.requests.show', $request->_id)); ?>" class="text-sm text-red-600 hover:underline">View</a>
                            <form method="POST" action="<?php echo e(route('requester.requests.cancel', $request->_id)); ?>" onsubmit="return confirm('Cancel this request?')">
                                <?php echo csrf_field(); ?>
                                <button class="text-sm text-gray-600 hover:underline">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-6"><?php echo e($requests->links()); ?></div>

    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views/my-requests.blade.php ENDPATH**/ ?>