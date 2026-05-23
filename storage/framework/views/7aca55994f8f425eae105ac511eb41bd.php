

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <?php
        $collection = $requests->getCollection();
        $pendingCount = $collection->where('status', 'Pending')->count();
        $approvedCount = $collection->where('status', 'Approved')->count();
        $completedCount = $collection->where('status', 'Completed')->count();
        $rejectedCount = $collection->where('status', 'Rejected')->count();
    ?>

    <div class="hero-panel mb-8">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-white/90">
                    <span class="h-2 w-2 rounded-full bg-white"></span>
                    Emergency operations
                </div>
                <h1 class="mt-4 text-3xl font-bold tracking-tight sm:text-4xl">Emergency Requests</h1>
                <p class="mt-3 text-sm leading-7 text-white/90 sm:text-base">
                    Review every requester submission, validate the details, and respond with a professional approval or rejection workflow.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="/admin/home" class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-2 text-sm font-semibold text-white ring-1 ring-white/20 backdrop-blur-sm hover:bg-white/25">
                    Back to Admin Home
                </a>
                <a href="<?php echo e(route('admin.requests.index')); ?>" class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-red-700 shadow-lg shadow-red-950/20 hover:bg-slate-100">
                    Refresh
                </a>
            </div>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-8">
        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Requests</p>
            <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-slate-100"><?php echo e($requests->total()); ?></p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">All emergency requests currently in the queue.</p>
        </div>
        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm font-medium text-amber-600">Pending</p>
            <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-slate-100"><?php echo e($pendingCount); ?></p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Requests awaiting review and action.</p>
        </div>
        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm font-medium text-blue-600">Approved</p>
            <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-slate-100"><?php echo e($approvedCount); ?></p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Requests approved and ready for follow-up.</p>
        </div>
        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm font-medium text-emerald-600">Completed</p>
            <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-slate-100"><?php echo e($completedCount); ?></p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Requests successfully closed after action.</p>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-12">
        <aside class="xl:col-span-4">
            <div class="card-panel dark:card-panel-dark sticky top-24">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">Filters</p>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Narrow requests by patient, requester, blood group, or status.</p>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-200">Live</span>
                </div>

                <form method="GET" action="<?php echo e(route('admin.requests.index')); ?>" class="mt-5 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Patient Name</label>
                        <input type="text" name="patient_name" value="<?php echo e(request('patient_name')); ?>" placeholder="e.g. John Doe" class="form-field dark:form-field-dark mt-2" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Requester Email</label>
                        <input type="text" name="requester_email" value="<?php echo e(request('requester_email') ?? request('donor_email')); ?>" placeholder="requester@example.com" class="form-field dark:form-field-dark mt-2" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Blood Group</label>
                        <select name="blood_group" class="form-field dark:form-field-dark mt-2">
                            <option value="">All Groups</option>
                            <?php $__currentLoopData = $bloodGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($group); ?>" <?php echo e(request('blood_group') === $group ? 'selected' : ''); ?>><?php echo e($group); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Status</label>
                        <select name="status" class="form-field dark:form-field-dark mt-2">
                            <option value="">All Statuses</option>
                            <?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($status); ?>" <?php echo e(request('status') === $status ? 'selected' : ''); ?>><?php echo e($status); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="flex items-center gap-3 pt-1">
                        <button type="submit" class="btn-primary">Apply Filters</button>
                        <a href="<?php echo e(route('admin.requests.index')); ?>" class="btn-secondary">Reset</a>
                    </div>
                </form>
            </div>

            <div class="mt-4 card-panel dark:card-panel-dark">
                <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">Workflow Notes</p>
                <ul class="mt-3 space-y-2 text-sm text-slate-500 dark:text-slate-400">
                    <li>• Review each request carefully before approving or rejecting.</li>
                    <li>• The request message stays hidden until you open the details page.</li>
                    <li>• Rejections require a clear reason before the save action is allowed.</li>
                </ul>
            </div>
        </aside>

        <main class="xl:col-span-8">
            <?php if($requests->isEmpty()): ?>
                <div class="card-panel dark:card-panel-dark border border-dashed border-slate-300 dark:border-slate-700">
                    <p class="text-xl font-semibold text-slate-900 dark:text-slate-100">No requests found</p>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Adjust your filters or return later when new emergency requests arrive.</p>
                </div>
            <?php else: ?>
                <div class="card-panel dark:card-panel-dark overflow-hidden">
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 pb-4 dark:border-slate-700">
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">Recent emergency requests</p>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">A clean list of all active and closed requests, with actions available in one place.</p>
                        </div>
                        <div class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-200">
                            <?php echo e($requests->total()); ?> total
                        </div>
                    </div>

                    <div class="space-y-3">
                        <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $statusClass = match($request->status) {
                                    'Pending' => 'bg-amber-100 text-amber-700 ring-amber-200',
                                    'Approved' => 'bg-blue-100 text-blue-700 ring-blue-200',
                                    'Completed' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
                                    'Rejected' => 'bg-red-100 text-red-700 ring-red-200',
                                    default => 'bg-slate-100 text-slate-700 ring-slate-200',
                                };
                            ?>

                            <article class="rounded-[1.5rem] border border-slate-200 bg-white p-4 shadow-sm transition hover:border-slate-300 hover:shadow-md dark:border-slate-700 dark:bg-slate-900">
                                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                    <div class="flex-1">
                                        <div class="flex flex-wrap items-start gap-3">
                                            <div>
                                                <p class="text-base font-semibold text-slate-900 dark:text-slate-100"><?php echo e($request->patient_name); ?></p>
                                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Requester: <?php echo e(optional($request->user)->email ?? 'Unknown'); ?></p>
                                            </div>
                                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[11px] font-semibold uppercase ring-1 <?php echo e($statusClass); ?>">
                                                <span class="h-2 w-2 rounded-full" style="background: currentColor; opacity: .75"></span>
                                                <?php echo e($request->status); ?>

                                            </span>
                                        </div>

                                        <div class="mt-4 grid gap-3 text-sm text-slate-600 dark:text-slate-300 sm:grid-cols-2 xl:grid-cols-4">
                                            <div>
                                                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Blood group</p>
                                                <p class="mt-1 font-medium text-slate-900 dark:text-slate-100"><?php echo e($request->blood_group); ?></p>
                                            </div>
                                            <div>
                                                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Hospital</p>
                                                <p class="mt-1 font-medium text-slate-900 dark:text-slate-100"><?php echo e($request->hospital); ?></p>
                                            </div>
                                            <div>
                                                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">City</p>
                                                <p class="mt-1 font-medium text-slate-900 dark:text-slate-100"><?php echo e($request->city); ?></p>
                                            </div>
                                            <div>
                                                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Phone</p>
                                                <p class="mt-1 font-medium text-slate-900 dark:text-slate-100"><?php echo e($request->phone); ?></p>
                                            </div>
                                        </div>

                                        <div class="mt-4 flex flex-wrap items-center gap-3 text-sm text-slate-500 dark:text-slate-400">
                                            <span class="rounded-full bg-slate-100 px-3 py-1 dark:bg-slate-800">Created <?php echo e(optional($request->created_at)->format('M d, Y')); ?></span>
                                            <span class="rounded-full bg-slate-100 px-3 py-1 dark:bg-slate-800">Message available on View</span>
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap items-center gap-2 lg:flex-col lg:items-stretch lg:min-w-[180px]">
                                        <a href="<?php echo e(route('admin.requests.show', $request->_id)); ?>" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:hover:bg-slate-700">
                                            View details
                                        </a>
                                        <button type="button" data-request-id="<?php echo e($request->_id); ?>" data-status="Approved" data-title="Approve Request" data-required-message="false" class="js-open-status-modal inline-flex items-center justify-center rounded-full bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                                            Approve
                                        </button>
                                        <button type="button" data-request-id="<?php echo e($request->_id); ?>" data-status="Rejected" data-title="Reject Request" data-required-message="true" class="js-open-status-modal inline-flex items-center justify-center rounded-full bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700">
                                            Reject
                                        </button>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="mt-5 flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 px-1 pt-4 dark:border-slate-700">
                        <div class="text-sm text-slate-500 dark:text-slate-400">
                            Showing <span class="font-semibold text-slate-700 dark:text-slate-200"><?php echo e($requests->firstItem()); ?></span> to <span class="font-semibold text-slate-700 dark:text-slate-200"><?php echo e($requests->lastItem()); ?></span> of <span class="font-semibold text-slate-700 dark:text-slate-200"><?php echo e($requests->total()); ?></span> requests
                        </div>
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views\admin\requests.blade.php ENDPATH**/ ?>