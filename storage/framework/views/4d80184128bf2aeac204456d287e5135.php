<?php $__env->startSection('content'); ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Left Column: Profile + Stats -->
    <div class="space-y-6">

        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-red-500 to-pink-500 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full overflow-hidden border-4 border-white flex-shrink-0">
                    <?php if(isset($user->profile_image) && $user->profile_image): ?>
                        <img src="<?php echo e(asset('storage/profile_images/' . $user->profile_image)); ?>" alt="Profile" class="w-full h-full object-cover">
                    <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name)); ?>&background=fff&color=dc2626&size=128" alt="avatar" class="w-full h-full object-cover">
                    <?php endif; ?>
                </div>

                <div class="flex-1 min-w-0">
                    <h2 class="text-xl sm:text-2xl font-bold break-words">Hello, <?php echo e($user->name); ?></h2>
                    <p class="mt-1 text-xs sm:text-sm opacity-90">Good to see you — thank you for helping save lives.</p>

                    <div class="mt-3 flex flex-wrap gap-2 items-center text-xs sm:text-sm">
                        <span class="bg-white bg-opacity-20 px-2 sm:px-3 py-1 rounded-full whitespace-nowrap">Blood: <strong class="ml-1"><?php echo e($user->blood_group ?? 'N/A'); ?></strong></span>
                        <span class="bg-white bg-opacity-20 px-2 sm:px-3 py-1 rounded-full whitespace-nowrap">City: <strong class="ml-1"><?php echo e($user->city ?? 'N/A'); ?></strong></span>
                        <span id="availability-badge" class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-medium whitespace-nowrap <?php echo e($user->available == 'yes' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>"><?php echo e($user->available == 'yes' ? 'Available' : 'Unavailable'); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="card-panel dark:card-panel-dark transition hover:-translate-y-0.5">
                <p class="text-sm text-slate-500 dark:text-slate-400">Total Requests</p>
                <p class="text-2xl font-bold text-red-600"><?php echo e($totalRequests ?? 0); ?></p>
            </div>

            <div class="card-panel dark:card-panel-dark transition hover:-translate-y-0.5">
                <p class="text-sm text-slate-500 dark:text-slate-400">Approved</p>
                <p class="text-2xl font-bold text-blue-600"><?php echo e($approvedRequests ?? 0); ?></p>
            </div>

            <div class="card-panel dark:card-panel-dark transition hover:-translate-y-0.5">
                <p class="text-sm text-slate-500 dark:text-slate-400">Completed</p>
                <p class="text-2xl font-bold text-green-600"><?php echo e($completedRequests ?? 0); ?></p>
            </div>

            <div class="card-panel dark:card-panel-dark transition hover:-translate-y-0.5">
                <p class="text-sm text-slate-500 dark:text-slate-400">Availability</p>
                <p class="text-2xl font-bold"><?php echo e($user->available == 'yes' ? 'Available' : 'Unavailable'); ?></p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card-panel dark:card-panel-dark">
            <h3 class="font-semibold mb-3">Quick Actions</h3>

                <div class="grid grid-cols-2 gap-3">
                <a href="/profile/edit" class="btn-primary">Edit Profile</a>
                <a href="<?php echo e(route('requester.requests.create')); ?>" class="btn-secondary">Create Request</a>
                <a href="<?php echo e(route('requester.requests.index')); ?>" class="btn-secondary">View My Requests</a>
                <button id="toggle-availability-btn" data-url="<?php echo e(route('toggle.availability')); ?>" class="btn-secondary inline-flex items-center justify-center gap-2">
                    <span id="toggle-spinner" class="hidden w-4 h-4 border-2 border-transparent border-t-gray-700 rounded-full animate-spin"></span>
                    Toggle Availability
                </button>
            </div>
        </div>

        <!-- Donation Awareness -->
        <div class="space-y-3">
            <div class="bg-gradient-to-r from-yellow-200 via-red-100 to-pink-50 p-4 rounded-xl shadow">
                <h4 class="font-semibold">Why Donate?</h4>
                <p class="text-sm mt-2">Donating blood saves lives. It also improves your health and community resilience.</p>
            </div>

            <div class="card-panel dark:card-panel-dark transition hover:-translate-y-0.5">
                <h4 class="font-semibold">Tips</h4>
                <ul class="mt-2 text-sm list-disc list-inside">
                    <li>Stay hydrated before donation.</li>
                    <li>Eat a healthy meal and avoid fatty foods.</li>
                    <li>Bring ID and rest after donation.</li>
                </ul>
            </div>

            <div class="card-panel dark:card-panel-dark transition hover:-translate-y-0.5">
                <h4 class="font-semibold">Eligibility</h4>
                <p class="text-sm mt-2">Most healthy adults can donate. Check local guidelines or contact support if unsure.</p>
            </div>
        </div>

    </div>

    <!-- Right Column: My Requests + Recent Activity -->
    <div class="lg:col-span-2 space-y-6">

        <!-- My Requests -->
        <div class="card-panel dark:card-panel-dark">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">My Requests</h3>
                <a href="/my-requests" class="text-sm text-blue-600 hover:underline">View all</a>
            </div>

            <?php if($requests && $requests->count()): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <div>
                                <div class="flex items-center gap-3">
                                    <div class="font-semibold"><?php echo e($req->patient_name); ?></div>
                                    <div class="text-sm text-gray-500">• <?php echo e($req->hospital); ?></div>
                                    <div class="text-sm text-gray-500">• <?php echo e($req->city); ?></div>
                                </div>
                                <div class="text-sm text-gray-500 mt-1">Blood: <strong><?php echo e($req->blood_group); ?></strong></div>
                            </div>

                            <div class="text-right">
                                <?php
                                    $status = $req->status ?? 'Pending';
                                ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    <?php echo e($status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : ''); ?>

                                    <?php echo e($status == 'Approved' ? 'bg-blue-100 text-blue-800' : ''); ?>

                                    <?php echo e($status == 'Completed' ? 'bg-green-100 text-green-800' : ''); ?>

                                    <?php echo e($status == 'Rejected' ? 'bg-red-100 text-red-800' : ''); ?>

                                ">
                                    <?php echo e($status); ?>

                                </span>
                                <div class="text-xs text-gray-400 mt-2"><?php echo e(optional($req->created_at)->diffForHumans()); ?></div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="mt-4">
                    <?php echo e($requests->links()); ?>

                </div>
            <?php else: ?>
                <div class="py-12 text-center text-gray-500">
                    <svg class="mx-auto mb-6 w-20 h-20 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12A9 9 0 1112 3a9 9 0 019 9z"></path></svg>
                    <h4 class="text-lg font-semibold mb-2">No requests yet</h4>
                    <p class="text-sm text-gray-400 mb-4">Create your first emergency request to help patients in need.</p>
                    <a href="<?php echo e(route('requester.requests.create')); ?>" class="inline-flex items-center gap-2 bg-red-600 text-white px-4 py-2 rounded-lg">Create Emergency Request</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Recent Activity -->
        <div class="card-panel dark:card-panel-dark">
            <h3 class="text-lg font-semibold mb-3">Recent Activity</h3>

            <?php if($recentActivity && $recentActivity->count()): ?>
                <ul class="space-y-3">
                    <?php $__currentLoopData = $recentActivity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $act): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex items-start gap-3">
                            <div class="w-2 h-2 mt-2 rounded-full bg-red-500"></div>
                            <div>
                                <div class="text-sm font-medium">Request for <strong><?php echo e($act->patient_name); ?></strong> — <span class="text-gray-500"><?php echo e($act->hospital); ?>, <?php echo e($act->city); ?></span></div>
                                <div class="text-xs text-gray-400"><?php echo e(optional($act->created_at)->diffForHumans()); ?> • Status: <?php echo e($act->status); ?></div>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php else: ?>
                <div class="text-sm text-gray-500">No recent activity.</div>
            <?php endif; ?>
        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    const btn = document.getElementById('toggle-availability-btn');
    const badge = document.getElementById('availability-badge');
    const spinner = document.getElementById('toggle-spinner');
    if(!btn) return;

    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    btn.addEventListener('click', async function(e){
        e.preventDefault();
        if(btn.disabled) return;
        btn.disabled = true;
        spinner.classList.remove('hidden');
        try{
            const res = await fetch(btn.dataset.url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            });

            const data = await res.json();

            if(res.ok && data.success){
                const avail = data.available;
                if(badge){
                    badge.textContent = avail === 'yes' ? 'Available' : 'Unavailable';
                    badge.className = avail === 'yes' ? 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800' : 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800';
                }
                showAlert('Availability updated', 'success');
            } else {
                showAlert(data.message || 'Update failed', 'error');
            }

        } catch(err){
            showAlert('Network error', 'error');
        } finally {
            btn.disabled = false;
            spinner.classList.add('hidden');
        }
    });

    function showAlert(msg, type){
        const existing = document.getElementById('ajax-alert');
        if(existing) existing.remove();
        const div = document.createElement('div');
        div.id = 'ajax-alert';
        div.style.zIndex = 9999;
        div.className = type === 'success' ? 'fixed top-6 right-6 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-lg shadow' : 'fixed top-6 right-6 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-lg shadow';
        div.textContent = msg;
        document.body.appendChild(div);
        setTimeout(()=>{ div.remove(); }, 3000);
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views\dashboard.blade.php ENDPATH**/ ?>