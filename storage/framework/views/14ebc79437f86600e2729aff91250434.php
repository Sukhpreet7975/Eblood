

<?php $__env->startSection('content'); ?>

<div class="space-y-8">
    <section class="hero-panel">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-3xl">
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-rose-100">Donor performance dashboard</p>
                <h1 class="mt-4 text-3xl font-bold tracking-tight sm:text-4xl">Welcome back, <?php echo e($user->name); ?>.</h1>
                <p class="mt-4 max-w-2xl text-sm leading-7 text-rose-50/90 sm:text-base">
                    Your donor profile is curated for fast matching. Keep your details current, stay available, and respond quickly when urgent requests arise.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="/profile" class="btn-primary">View profile</a>
                    <a href="/profile/edit" class="inline-flex items-center justify-center rounded-full border border-white/25 bg-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/20">Edit profile</a>
                </div>
            </div>

            <div class="w-full max-w-sm rounded-[1.75rem] border border-white/10 bg-slate-950/70 p-5 shadow-2xl shadow-black/30 backdrop-blur-xl">
                <div class="flex items-center gap-4">
                    <div class="h-16 w-16 overflow-hidden rounded-[1.25rem] border-2 border-white/70 bg-white">
                        <?php if(!empty($user->profile_image)): ?>
                            <img src="<?php echo e(asset('storage/profile_images/' . $user->profile_image)); ?>" alt="<?php echo e($user->name); ?>" class="h-full w-full object-cover">
                        <?php else: ?>
                            <div class="flex h-full w-full items-center justify-center bg-red-50 text-lg font-bold text-red-600"><?php echo e(strtoupper(substr($user->name, 0, 1))); ?></div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p class="text-sm text-rose-100/80">Blood group</p>
                        <p class="mt-2 text-2xl font-bold text-white"><?php echo e($user->blood_group ?? 'N/A'); ?></p>
                        <p class="mt-2 text-sm text-rose-50/85"><?php echo e($user->city ?? 'City not added'); ?></p>
                    </div>
                </div>
                <div class="mt-5 rounded-[1.5rem] bg-white/10 px-4 py-3">
                    <p class="text-xs uppercase tracking-[0.2em] text-rose-100/80">Activity status</p>
                    <p class="mt-2 text-sm font-semibold text-white"><?php echo e($activityStatus); ?></p>
                    <p class="mt-1 text-xs text-rose-50/80">Last updated <?php echo e(optional($user->updated_at)->diffForHumans() ?? 'just now'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <div class="grid gap-4 xl:grid-cols-4">
        <?php if (isset($component)) { $__componentOriginal6d74059c34730cb2c742dae13948a701 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6d74059c34730cb2c742dae13948a701 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.metric-card','data' => ['label' => 'Profile completion','value' => ''.e($profileCompletion).'%','caption' => 'Keep your phone, address, and profile image current to improve trust.','icon' => `<svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 4v5c0 5-3.5 8.4-7 9-3.5-.6-7-4-7-9V7l7-4Z"/><path d="m9.5 12 1.7 1.8 3.3-3.6"/></svg>`]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('metric-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Profile completion','value' => ''.e($profileCompletion).'%','caption' => 'Keep your phone, address, and profile image current to improve trust.','icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(`<svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 4v5c0 5-3.5 8.4-7 9-3.5-.6-7-4-7-9V7l7-4Z"/><path d="m9.5 12 1.7 1.8 3.3-3.6"/></svg>`)]); ?>
            <div class="h-2 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                <div class="h-full rounded-full bg-gradient-to-r from-red-500 to-rose-400" style="width: <?php echo e($profileCompletion); ?>%"></div>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6d74059c34730cb2c742dae13948a701)): ?>
<?php $attributes = $__attributesOriginal6d74059c34730cb2c742dae13948a701; ?>
<?php unset($__attributesOriginal6d74059c34730cb2c742dae13948a701); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6d74059c34730cb2c742dae13948a701)): ?>
<?php $component = $__componentOriginal6d74059c34730cb2c742dae13948a701; ?>
<?php unset($__componentOriginal6d74059c34730cb2c742dae13948a701); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal6d74059c34730cb2c742dae13948a701 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6d74059c34730cb2c742dae13948a701 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.metric-card','data' => ['label' => 'Availability','value' => ''.e($user->available === 'yes' ? 'Available' : 'Unavailable').'','caption' => 'Patients can see your current status during urgent search moments.','icon' => `<svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v2"/><path d="M12 20v2"/><path d="M4.93 4.93l1.41 1.41"/><path d="M17.66 17.66l1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="M4.93 19.07l1.41-1.41"/><path d="M17.66 6.34l1.41-1.41"/><circle cx="12" cy="12" r="4"/></svg>`]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('metric-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Availability','value' => ''.e($user->available === 'yes' ? 'Available' : 'Unavailable').'','caption' => 'Patients can see your current status during urgent search moments.','icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(`<svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v2"/><path d="M12 20v2"/><path d="M4.93 4.93l1.41 1.41"/><path d="M17.66 17.66l1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="M4.93 19.07l1.41-1.41"/><path d="M17.66 6.34l1.41-1.41"/><circle cx="12" cy="12" r="4"/></svg>`)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6d74059c34730cb2c742dae13948a701)): ?>
<?php $attributes = $__attributesOriginal6d74059c34730cb2c742dae13948a701; ?>
<?php unset($__attributesOriginal6d74059c34730cb2c742dae13948a701); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6d74059c34730cb2c742dae13948a701)): ?>
<?php $component = $__componentOriginal6d74059c34730cb2c742dae13948a701; ?>
<?php unset($__componentOriginal6d74059c34730cb2c742dae13948a701); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal6d74059c34730cb2c742dae13948a701 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6d74059c34730cb2c742dae13948a701 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.metric-card','data' => ['label' => 'Nearby emergency requests','value' => ''.e($nearbyRequests).'','caption' => 'The request count is based on your city and current active set.','icon' => `<svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21c4.2 0 7-3.1 7-7 0-3.8-2.7-5.6-5.1-8-1.4-1.4-1.9-2.8-1.9-4h0c0-.8-.7-1.5-1.5-1.5S9 1.2 9 2v.1c0 1.2-.5 2.6-1.9 4C5.7 8.4 3 10.2 3 14c0 3.9 2.8 7 9 7Z"/></svg>`]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('metric-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Nearby emergency requests','value' => ''.e($nearbyRequests).'','caption' => 'The request count is based on your city and current active set.','icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(`<svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21c4.2 0 7-3.1 7-7 0-3.8-2.7-5.6-5.1-8-1.4-1.4-1.9-2.8-1.9-4h0c0-.8-.7-1.5-1.5-1.5S9 1.2 9 2v.1c0 1.2-.5 2.6-1.9 4C5.7 8.4 3 10.2 3 14c0 3.9 2.8 7 9 7Z"/></svg>`)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6d74059c34730cb2c742dae13948a701)): ?>
<?php $attributes = $__attributesOriginal6d74059c34730cb2c742dae13948a701; ?>
<?php unset($__attributesOriginal6d74059c34730cb2c742dae13948a701); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6d74059c34730cb2c742dae13948a701)): ?>
<?php $component = $__componentOriginal6d74059c34730cb2c742dae13948a701; ?>
<?php unset($__componentOriginal6d74059c34730cb2c742dae13948a701); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal6d74059c34730cb2c742dae13948a701 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6d74059c34730cb2c742dae13948a701 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.metric-card','data' => ['label' => 'Blood demand in city','value' => ''.e($cityDemand).'','caption' => 'Higher demand means your blood group is especially relevant in your area.','icon' => `<svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-6-4.4-6-10a6 6 0 1 1 12 0c0 5.6-6 10-6 10Z"/><circle cx="12" cy="11" r="2"/></svg>`]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('metric-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Blood demand in city','value' => ''.e($cityDemand).'','caption' => 'Higher demand means your blood group is especially relevant in your area.','icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(`<svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-6-4.4-6-10a6 6 0 1 1 12 0c0 5.6-6 10-6 10Z"/><circle cx="12" cy="11" r="2"/></svg>`)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6d74059c34730cb2c742dae13948a701)): ?>
<?php $attributes = $__attributesOriginal6d74059c34730cb2c742dae13948a701; ?>
<?php unset($__attributesOriginal6d74059c34730cb2c742dae13948a701); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6d74059c34730cb2c742dae13948a701)): ?>
<?php $component = $__componentOriginal6d74059c34730cb2c742dae13948a701; ?>
<?php unset($__componentOriginal6d74059c34730cb2c742dae13948a701); ?>
<?php endif; ?>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
        <div class="card-panel dark:card-panel-dark">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-red-600">Insights</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">Smart recommendations</h2>
                </div>
                <span class="rounded-full bg-red-50 px-3 py-1 text-sm font-semibold text-red-700 dark:bg-red-950/40 dark:text-red-200">Local logic</span>
            </div>

            <div class="mt-5 space-y-3">
                <?php $__currentLoopData = $recommendations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recommendation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="rounded-[1.5rem] border border-slate-200/80 bg-slate-50 px-4 py-4 dark:border-slate-700/80 dark:bg-slate-900/70">
                        <p class="text-sm leading-6 text-slate-700 dark:text-slate-200"><?php echo e($recommendation); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-[1.5rem] bg-slate-50 p-4 dark:bg-slate-900/70">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Care actions</p>
                    <p class="mt-3 text-sm leading-6 text-slate-700 dark:text-slate-200">Keep your profile current, confirm your city, and remain available during urgent windows.</p>
                </div>
                <div class="rounded-[1.5rem] bg-slate-50 p-4 dark:bg-slate-900/70">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Match confidence</p>
                    <p class="mt-3 text-sm leading-6 text-slate-700 dark:text-slate-200">Higher scores are given to donors with compatible blood groups, active status, and local availability.</p>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card-panel dark:card-panel-dark">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-red-600">Achievements</p>
                        <h2 class="mt-2 text-xl font-bold text-slate-900 dark:text-white">Badges earned</h2>
                    </div>
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-200"><?php echo e($badges->count()); ?> unlocked</span>
                </div>

                <?php if($badges->isNotEmpty()): ?>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <?php $__currentLoopData = $badges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $badge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="rounded-full border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 dark:border-red-900/70 dark:bg-red-950/40 dark:text-red-100"><?php echo e($badge); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'No achievements yet','description' => 'Complete your profile and stay active to unlock badges like New Donor, Active Donor, and Life Saver.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No achievements yet','description' => 'Complete your profile and stay active to unlock badges like New Donor, Active Donor, and Life Saver.']); ?>
                        <svg viewBox="0 0 24 24" class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 4v5c0 5-3.5 8.4-7 9-3.5-.6-7-4-7-9V7l7-4Z"/><path d="m9.5 12 1.7 1.8 3.3-3.6"/></svg>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="card-panel dark:card-panel-dark">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-red-600">Leaderboard</p>
                        <h2 class="mt-2 text-xl font-bold text-slate-900 dark:text-white">Top active donors</h2>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-100">City ranking</span>
                </div>

                <?php if($leaderboard->isNotEmpty()): ?>
                    <div class="mt-4 space-y-3">
                        <?php $__currentLoopData = $leaderboard; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between gap-4 rounded-[1.5rem] bg-slate-50 px-4 py-3 dark:bg-slate-900/70">
                                <div>
                                    <p class="text-sm font-semibold text-slate-900 dark:text-white"><?php echo e($entry->name); ?></p>
                                    <p class="text-xs text-slate-500 dark:text-slate-300"><?php echo e($entry->city ?? 'City not listed'); ?> • <?php echo e($entry->blood_group ?? 'N/A'); ?></p>
                                </div>
                                <span class="rounded-full px-3 py-1 text-xs font-semibold <?php echo e($entry->available === 'yes' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-200' : 'bg-slate-200 text-slate-700 dark:bg-slate-800 dark:text-slate-100'); ?>">
                                    <?php echo e($entry->available === 'yes' ? 'Active' : 'Away'); ?>

                                </span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'No local leaderboard yet','description' => 'Add more donor profiles in your city to show a leaderboard and city-wide activity.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No local leaderboard yet','description' => 'Add more donor profiles in your city to show a leaderboard and city-wide activity.']); ?>
                        <svg viewBox="0 0 24 24" class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 21V8"/><path d="M12 21V5"/><path d="M19 21v-7"/></svg>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    window.__ebloodNotificationsSeed = [
        {
            id: 'availability-reminder',
            title: 'Availability reminder',
            message: 'Keep your donor status updated so patients in your city can contact you quickly.',
            type: 'reminder',
            read: false,
        },
        {
            id: 'critical-request',
            title: 'New critical request',
            message: '<?php echo e($nearbyRequests > 0 ? "There are " . $nearbyRequests . " urgent request(s) in your city right now." : "No active urgent requests are visible in your current city."); ?>',
            type: '<?php echo e($nearbyRequests > 0 ? "critical" : "announcement"); ?>',
            read: false,
        },
        {
            id: 'admin-announcement',
            title: 'Admin announcement',
            message: 'Use the dashboard insights to stay prepared and keep your profile current for the next emergency match.',
            type: 'announcement',
            read: false,
        }
    ];
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views/donor/home.blade.php ENDPATH**/ ?>