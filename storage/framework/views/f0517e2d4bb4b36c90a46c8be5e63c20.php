

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex items-start justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl sm:text-4xl font-semibold text-slate-900 dark:text-slate-100">Emergency Requests</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Manage incoming blood requests — filter, review, and act quickly.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="/admin/home" class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200">Back to Admin Home</a>
            <a href="<?php echo e(route('admin.requests.index')); ?>" class="inline-flex items-center gap-2 rounded-full bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Refresh</a>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-12">
        <aside class="lg:col-span-3">
            <div class="card-panel dark:card-panel-dark sticky top-24">
                <h3 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Filters</h3>
                <form method="GET" action="<?php echo e(route('admin.requests.index')); ?>" class="mt-4 space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400">Patient Name</label>
                        <input type="text" name="patient_name" value="<?php echo e(request('patient_name')); ?>" placeholder="e.g. John Doe" class="form-field dark:form-field-dark mt-1" />
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400">Donor Email</label>
                        <input type="text" name="donor_email" value="<?php echo e(request('donor_email')); ?>" placeholder="donor@example.com" class="form-field dark:form-field-dark mt-1" />
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400">Blood Group</label>
                        <select name="blood_group" class="form-field dark:form-field-dark mt-1">
                            <option value="">All Groups</option>
                            <?php $__currentLoopData = $bloodGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($group); ?>" <?php echo e(request('blood_group') === $group ? 'selected' : ''); ?>><?php echo e($group); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400">Status</label>
                        <select name="status" class="form-field dark:form-field-dark mt-1">
                            <option value="">All Statuses</option>
                            <?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($status); ?>" <?php echo e(request('status') === $status ? 'selected' : ''); ?>><?php echo e($status); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">Apply</button>
                        <a href="<?php echo e(route('admin.requests.index')); ?>" class="inline-flex items-center justify-center rounded-2xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200">Reset</a>
                    </div>
                </form>
            </div>

            <div class="mt-4 hidden sm:block">
                <div class="card-panel dark:card-panel-dark">
                    <h4 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Quick Stats</h4>
                    <div class="mt-3 space-y-2 text-sm text-slate-600 dark:text-slate-400">
                        <div class="flex items-center justify-between"><span>Total</span><span class="font-semibold text-slate-900 dark:text-slate-100"><?php echo e($requests->total()); ?></span></div>
                        <div class="flex items-center justify-between"><span>Pending</span><span class="font-semibold text-amber-600"><?php echo e($pendingRequests ?? 0); ?></span></div>
                        <div class="flex items-center justify-between"><span>Approved</span><span class="font-semibold text-blue-600"><?php echo e($approvedRequests ?? 0); ?></span></div>
                    </div>
                </div>
            </div>
        </aside>

        <main class="lg:col-span-9">
            <?php if($requests->isEmpty()): ?>
                <div class="card-panel dark:card-panel-dark border-dashed border-slate-300 dark:border-slate-700">
                    <p class="text-lg font-semibold text-slate-900 dark:text-slate-100">No requests found</p>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Adjust your filters or come back later.</p>
                </div>
            <?php else: ?>
                <div class="card-panel dark:card-panel-dark overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full w-full table-auto">
                            <thead class="bg-slate-50 dark:bg-slate-800">
                                <tr class="text-sm text-slate-600 dark:text-slate-400">
                                    <th class="px-4 py-3 text-left">Patient</th>
                                    <th class="px-4 py-3 text-left hidden md:table-cell">Donor</th>
                                    <th class="px-4 py-3 text-left">Blood</th>
                                    <th class="px-4 py-3 text-left hidden lg:table-cell">Hospital</th>
                                    <th class="px-4 py-3 text-left hidden lg:table-cell">City</th>
                                    <th class="px-4 py-3 text-left hidden md:table-cell">Phone</th>
                                    <th class="px-4 py-3 text-left">Status</th>
                                    <th class="px-4 py-3 text-left hidden lg:table-cell">Created</th>
                                    <th class="px-4 py-3 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-slate-700">
                                <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                                        <td class="px-4 py-4">
                                            <div class="font-semibold text-slate-900 dark:text-slate-100"><?php echo e($request->patient_name); ?></div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 hidden sm:block"><?php echo e(Str::limit($request->message ?? '-', 60)); ?></div>
                                        </td>
                                        <td class="px-4 py-4 hidden md:table-cell text-slate-600 dark:text-slate-300"><?php echo e(optional($request->user)->email ?? 'Unknown'); ?></td>
                                        <td class="px-4 py-4 text-slate-700 dark:text-slate-200"><?php echo e($request->blood_group); ?></td>
                                        <td class="px-4 py-4 hidden lg:table-cell text-slate-600 dark:text-slate-300"><?php echo e($request->hospital); ?></td>
                                        <td class="px-4 py-4 hidden lg:table-cell text-slate-600 dark:text-slate-300"><?php echo e($request->city); ?></td>
                                        <td class="px-4 py-4 hidden md:table-cell text-slate-600 dark:text-slate-300"><?php echo e($request->phone); ?></td>
                                        <td class="px-4 py-4">
                                            <?php
                                                $statusClass = match($request->status) {
                                                    'Pending' => 'bg-amber-100 text-amber-700',
                                                    'Approved' => 'bg-blue-100 text-blue-700',
                                                    'Completed' => 'bg-emerald-100 text-emerald-700',
                                                    'Rejected' => 'bg-red-100 text-red-700',
                                                    default => 'bg-slate-100 text-slate-700',
                                                };
                                            ?>
                                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold uppercase <?php echo e($statusClass); ?>">
                                                <span class="w-2 h-2 rounded-full" style="background: currentColor; opacity: .7"></span>
                                                <?php echo e($request->status); ?>

                                            </span>
                                        </td>
                                        <td class="px-4 py-4 hidden lg:table-cell text-slate-600 dark:text-slate-300"><?php echo e(optional($request->created_at)->format('Y-m-d')); ?></td>
                                        <td class="px-4 py-4">
                                            <div class="flex items-center gap-2">
                                                <a href="<?php echo e(route('admin.requests.show', $request->_id)); ?>" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:shadow-sm">View</a>
                                                <button type="button" data-request-id="<?php echo e($request->_id); ?>" data-status="Approved" data-title="Approve Request" data-required-message="false" class="js-open-status-modal inline-flex items-center gap-2 rounded-full bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700">Approve</button>
                                                <button type="button" data-request-id="<?php echo e($request->_id); ?>" data-status="Rejected" data-title="Reject Request" data-required-message="true" class="js-open-status-modal inline-flex items-center gap-2 rounded-full bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700">Reject</button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="px-4 py-4 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between">
                        <div class="text-sm text-slate-500">Showing <span class="font-medium text-slate-700"><?php echo e($requests->firstItem()); ?></span> to <span class="font-medium text-slate-700"><?php echo e($requests->lastItem()); ?></span> of <span class="font-medium text-slate-700"><?php echo e($requests->total()); ?></span> requests</div>
                        <div>
                            <?php echo e($requests->links()); ?>

                        </div>
                    </div>

                </div>
            <?php endif; ?>
        </main>
    </div>

    <div id="status-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm">
        <div class="w-full max-w-2xl card-panel dark:card-panel-dark">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5 dark:border-slate-700">
                <div>
                    <h2 id="modal-title" class="text-xl font-semibold text-slate-900 dark:text-slate-100">Update Request Status</h2>
                    <p id="modal-subtitle" class="mt-1 text-sm text-slate-500 dark:text-slate-400">Add an optional message before saving the change.</p>
                </div>
                <button type="button" class="js-close-status-modal text-slate-500 transition hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-100">✕</button>
            </div>
            <form id="status-form" method="POST" class="px-6 py-6">
                <?php echo csrf_field(); ?>
                <input type="hidden" id="modal-request-id" name="request_id" value="">
                <input type="hidden" id="modal-status" name="status" value="">

                <div class="grid gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
                        <input type="text" id="modal-status-label" readonly class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-100 px-4 py-3 text-sm text-slate-900 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Admin Response</label>
                        <textarea id="modal-admin-message" name="admin_message" rows="4" class="form-field dark:form-field-dark" placeholder="Write an optional approval message or enter a rejection reason."></textarea>
                        <p id="modal-requirement" class="mt-2 text-sm text-slate-500 dark:text-slate-400">Approval message is optional. Rejection reason is required.</p>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap items-center gap-3 justify-end">
                    <button type="button" class="btn-secondary js-close-status-modal">Cancel</button>
                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition duration-200 hover:bg-red-700">Save Change</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('status-modal');
            const form = document.getElementById('status-form');
            const requestId = document.getElementById('modal-request-id');
            const statusInput = document.getElementById('modal-status');
            const statusLabel = document.getElementById('modal-status-label');
            const adminMessage = document.getElementById('modal-admin-message');
            const requirement = document.getElementById('modal-requirement');
            const openButtons = document.querySelectorAll('.js-open-status-modal');
            const closeButtons = document.querySelectorAll('.js-close-status-modal');

            openButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.dataset.requestId;
                    const status = button.dataset.status;
                    const title = button.dataset.title;
                    const requireMessage = button.dataset.requiredMessage === 'true';

                    requestId.value = id;
                    statusInput.value = status;
                    statusLabel.value = status;
                    adminMessage.value = '';
                    requirement.textContent = requireMessage ? 'Rejection reason is required.' : 'Approval message is optional. Rejection reason is required.';
                    adminMessage.required = requireMessage;
                    document.getElementById('modal-title').textContent = title;
                    document.getElementById('modal-subtitle').textContent = requireMessage ? 'Write a reason for rejecting this request.' : 'Write an optional approval message.';
                    form.action = '/admin/requests/' + id + '/status';
                    modal.classList.remove('hidden');
                });
            });

            closeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
            });

            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views/admin/requests.blade.php ENDPATH**/ ?>