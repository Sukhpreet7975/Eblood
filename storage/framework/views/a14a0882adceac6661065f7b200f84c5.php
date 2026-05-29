

<?php $__env->startSection('content'); ?>

<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
        <div class="space-y-6">
            <div class="card-panel dark:card-panel-dark">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-red-600">Availability</p>
                        <h1 class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">Manage when patients can reach you</h1>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-600 dark:text-slate-300">
                            Keep your donor status current so patients and requesters can see when you’re ready to help.
                        </p>
                    </div>
                    <div class="rounded-2xl bg-red-50 px-4 py-3 text-sm font-semibold text-red-700 dark:bg-red-950/50 dark:text-red-100">
                        Status control center
                    </div>
                </div>

                <div class="mt-6 rounded-[2rem] border border-slate-200 bg-slate-50 p-5 dark:border-slate-700 dark:bg-slate-900/70">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold text-slate-500 dark:text-slate-300">Current status</p>
                            <div class="mt-2 flex flex-wrap items-center gap-3">
                                <span id="availability-badge" class="inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold <?php echo e($user->available == 'yes' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    <?php echo e($user->available == 'yes' ? 'Available' : 'Unavailable'); ?>

                                </span>
                                <span class="inline-flex items-center rounded-full bg-white px-3 py-1 text-sm font-semibold text-slate-700 shadow-sm dark:bg-slate-950 dark:text-slate-100">
                                    <?php echo e($user->blood_group ?? 'N/A'); ?>

                                </span>
                            </div>
                        </div>

                        <form id="availability-form" method="POST" action="<?php echo e(route('toggle.availability')); ?>">
                            <?php echo csrf_field(); ?>
                            <button id="toggle-availability-btn" type="button" class="rounded-full px-5 py-3 text-sm font-semibold shadow-lg transition <?php echo e($user->available == 'yes' ? 'bg-red-600 text-white hover:bg-red-700' : 'bg-emerald-600 text-white hover:bg-emerald-700'); ?>">
                                <?php echo e($user->available == 'yes' ? 'Set as Unavailable' : 'Set as Available'); ?>

                            </button>
                        </form>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl bg-white px-4 py-3 shadow-sm dark:bg-slate-950">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-300">Blood group</p>
                            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white"><?php echo e($user->blood_group ?? 'Not added'); ?></p>
                        </div>
                        <div class="rounded-2xl bg-white px-4 py-3 shadow-sm dark:bg-slate-950">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-300">City</p>
                            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white"><?php echo e($user->city ?? 'Not added'); ?></p>
                        </div>
                        <div class="rounded-2xl bg-white px-4 py-3 shadow-sm dark:bg-slate-950">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-300">Phone</p>
                            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white"><?php echo e($user->phone ?? 'Not added'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-panel dark:card-panel-dark">
                <div class="flex items-center gap-3">
                    <div class="rounded-full bg-rose-100 px-3 py-1 text-sm font-semibold text-rose-700 dark:bg-rose-950/50 dark:text-rose-100">Quick guidance</div>
                    <p class="text-sm text-slate-500 dark:text-slate-300">Update your status only when you are ready to donate.</p>
                </div>

                <div class="mt-5 grid gap-4 md:grid-cols-3">
                    <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-900/70">
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">Ready to help</p>
                        <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">Turn availability on when you can respond quickly to urgent requests.</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-900/70">
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">Stay accurate</p>
                        <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">Switch it off when your schedule changes so patients are not contacted incorrectly.</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-900/70">
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">Protect privacy</p>
                        <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">Your contact details stay private until a request is approved.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card-panel dark:card-panel-dark">
                <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Why this matters</h2>
                <div class="mt-4 space-y-3 text-sm leading-6 text-slate-600 dark:text-slate-300">
                    <div class="rounded-2xl bg-red-50 px-4 py-3 dark:bg-red-950/40">
                        <p class="font-semibold text-red-700">Patients can discover you faster</p>
                        <p class="mt-1">When you’re available, your profile is easier to match with urgent requests in your city.</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-900/70">
                        <p class="font-semibold text-slate-900 dark:text-white">Keep updates accurate</p>
                        <p class="mt-1">If your schedule changes, update the status so people don’t contact you at the wrong time.</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-900/70">
                        <p class="font-semibold text-slate-900 dark:text-white">Stay privacy-safe</p>
                        <p class="mt-1">Your contact details are only shared after a request is approved.</p>
                    </div>
                </div>
            </div>

            <div class="card-panel dark:card-panel-dark">
                <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Profile link</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-300">
                    Need to change your city, phone, or address? Update those details on your profile page and keep this page focused on your current availability.
                </p>
                <a href="<?php echo e(route('profile')); ?>" class="mt-4 inline-flex items-center rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">
                    Go to Profile
                </a>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggle-availability-btn');
        const badge = document.getElementById('availability-badge');

        if (!toggleBtn || !badge) {
            return;
        }

        toggleBtn.addEventListener('click', async function () {
            toggleBtn.disabled = true;
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            try {
                const response = await fetch('<?php echo e(route('toggle.availability')); ?>', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    const isAvailable = data.available === 'yes';
                    badge.textContent = isAvailable ? 'Available' : 'Unavailable';
                    badge.className = isAvailable
                        ? 'inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold bg-green-100 text-green-800'
                        : 'inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold bg-red-100 text-red-800';

                    toggleBtn.textContent = isAvailable ? 'Set as Unavailable' : 'Set as Available';
                    toggleBtn.className = isAvailable
                        ? 'rounded-full px-5 py-3 text-sm font-semibold shadow-lg transition bg-red-600 text-white hover:bg-red-700'
                        : 'rounded-full px-5 py-3 text-sm font-semibold shadow-lg transition bg-emerald-600 text-white hover:bg-emerald-700';
                } else {
                    alert(data.message || 'Could not update availability');
                }
            } catch (error) {
                alert('Network error');
            } finally {
                toggleBtn.disabled = false;
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.donor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views/availability.blade.php ENDPATH**/ ?>