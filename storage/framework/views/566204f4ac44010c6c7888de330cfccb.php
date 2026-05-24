

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

    <div class="grid gap-6 xl:grid-cols-[1.05fr_0.95fr]">
        <div class="card-panel dark:card-panel-dark">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-red-600">Free donor toolkit</p>
                    <h2 class="mt-2 text-xl font-bold text-slate-900 dark:text-white">Emergency readiness checklist</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-300">Track the essentials you need before a request comes in and keep a ready-to-send response prepared.</p>
                </div>
                <span id="readiness-status" class="rounded-full bg-amber-100 px-3 py-1 text-sm font-semibold text-amber-700 dark:bg-amber-950/60 dark:text-amber-200">0 steps ready</span>
            </div>

            <div class="mt-5 h-2 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                <div id="readiness-progress-fill" class="h-full rounded-full bg-gradient-to-r from-red-500 to-rose-400" style="width: 0%"></div>
            </div>
            <p id="readiness-progress" class="mt-2 text-sm text-slate-500 dark:text-slate-300">0% ready</p>

            <div class="mt-5 space-y-3">
                <label class="flex items-start gap-3 rounded-[1.25rem] border border-slate-200 bg-slate-50 px-4 py-3 dark:border-slate-700 dark:bg-slate-900/80">
                    <input type="checkbox" class="mt-1 h-4 w-4 rounded border-slate-300 text-red-600 focus:ring-red-500" data-readiness-item="hydration">
                    <span>
                        <span class="block text-sm font-semibold text-slate-900 dark:text-white">Hydrated and fed</span>
                        <span class="mt-1 block text-sm text-slate-500 dark:text-slate-300">Stay hydrated and have a light meal before responding to a donation request.</span>
                    </span>
                </label>

                <label class="flex items-start gap-3 rounded-[1.25rem] border border-slate-200 bg-slate-50 px-4 py-3 dark:border-slate-700 dark:bg-slate-900/80">
                    <input type="checkbox" class="mt-1 h-4 w-4 rounded border-slate-300 text-red-600 focus:ring-red-500" data-readiness-item="contact">
                    <span>
                        <span class="block text-sm font-semibold text-slate-900 dark:text-white">Phone and contact details are current</span>
                        <span class="mt-1 block text-sm text-slate-500 dark:text-slate-300">Keep your phone number, city, and emergency contacts updated in your profile.</span>
                    </span>
                </label>

                <label class="flex items-start gap-3 rounded-[1.25rem] border border-slate-200 bg-slate-50 px-4 py-3 dark:border-slate-700 dark:bg-slate-900/80">
                    <input type="checkbox" class="mt-1 h-4 w-4 rounded border-slate-300 text-red-600 focus:ring-red-500" data-readiness-item="availability">
                    <span>
                        <span class="block text-sm font-semibold text-slate-900 dark:text-white">Availability is turned on</span>
                        <span class="mt-1 block text-sm text-slate-500 dark:text-slate-300">Stay visible to patients by keeping your availability status active.</span>
                    </span>
                </label>

                <label class="flex items-start gap-3 rounded-[1.25rem] border border-slate-200 bg-slate-50 px-4 py-3 dark:border-slate-700 dark:bg-slate-900/80">
                    <input type="checkbox" class="mt-1 h-4 w-4 rounded border-slate-300 text-red-600 focus:ring-red-500" data-readiness-item="profile">
                    <span>
                        <span class="block text-sm font-semibold text-slate-900 dark:text-white">Profile is complete</span>
                        <span class="mt-1 block text-sm text-slate-500 dark:text-slate-300">Add your city, blood group, and address so matches are more accurate and trustworthy.</span>
                    </span>
                </label>
            </div>

            <div class="mt-6 rounded-[1.5rem] border border-slate-200 bg-slate-50 px-4 py-4 dark:border-slate-700 dark:bg-slate-900/70">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">Quick response template</p>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">Copy a short message you can send when a donation request needs urgent help.</p>
                    </div>
                    <button id="copy-ready-message" type="button" class="rounded-full bg-red-600 px-4 py-2 text-sm font-semibold text-white">Copy message</button>
                </div>

                <textarea id="ready-message-template" class="mt-4 min-h-[120px] w-full rounded-[1.25rem] border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-red-400 focus:outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-white" spellcheck="false">I am available to donate in <?php echo e($user->city ?? 'my city'); ?>. Please contact me on <?php echo e($user->phone ?? 'my phone number'); ?> if a blood donation request needs urgent help.</textarea>

                <div class="mt-3 flex flex-wrap gap-3">
                    <button id="reset-ready-message" type="button" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 dark:border-slate-700 dark:text-slate-100">Reset</button>
                    <button id="city-template-button" type="button" class="rounded-full border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 dark:border-red-900/70 dark:bg-red-950/40 dark:text-red-100">Use my city</button>
                </div>

                <p id="copy-status" class="mt-3 text-sm text-slate-500 dark:text-slate-300">Ready to copy when you need it.</p>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card-panel dark:card-panel-dark">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-red-600">Browser alerts</p>
                <h2 class="mt-2 text-xl font-bold text-slate-900 dark:text-white">Free local notifications</h2>
                <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-300">Enable browser alerts to get quick reminders for new urgent requests and dashboard updates without any paid SMS service.</p>

                <div class="mt-4 flex items-center justify-between gap-4 rounded-[1.25rem] bg-slate-50 px-4 py-3 dark:bg-slate-900/70">
                    <div>
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">Local alerts</p>
                        <p id="alerts-label" class="mt-1 text-sm text-slate-500 dark:text-slate-300">Currently disabled</p>
                    </div>
                    <button id="local-alert-toggle" type="button" class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white dark:bg-white dark:text-slate-900">Enable</button>
                </div>

                <div class="mt-4 rounded-[1.25rem] bg-gradient-to-r from-rose-50 to-red-50 px-4 py-3 dark:from-rose-950/40 dark:to-red-950/20">
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">What this helps with</p>
                    <ul class="mt-3 space-y-2 text-sm text-slate-600 dark:text-slate-200">
                        <li>• Notify you when a nearby urgent request appears.</li>
                        <li>• Help you respond faster during peak demand hours.</li>
                        <li>• Keep your process fully free of paid messaging tools.</li>
                    </ul>
                </div>
            </div>

            <div class="card-panel dark:card-panel-dark">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-red-600">Fast next steps</p>
                <h2 class="mt-2 text-xl font-bold text-slate-900 dark:text-white">Action checklist</h2>
                <ul class="mt-4 space-y-3 text-sm text-slate-600 dark:text-slate-200">
                    <li>• Update your availability status when you are ready to donate.</li>
                    <li>• Keep your city and phone number current for faster matching.</li>
                    <li>• Review your profile completion to build trust with requesters.</li>
                    <li>• Use the quick response template when an urgent request lands.</li>
                </ul>
            </div>
        </div>
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
            <div id="achievements" class="card-panel dark:card-panel-dark">
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
    window.__ebloodDynamicNotificationData = {
        role: 'donor',
        available: <?php echo e($user->available === 'yes' ? 'true' : 'false'); ?>,
        profileCompletion: <?php echo e($profileCompletion); ?>,
        nearbyRequests: <?php echo e($nearbyRequests); ?>,
        cityDemand: <?php echo e($cityDemand); ?>,
        city: <?php echo json_encode($user->city ?? 'your city', 15, 512) ?>,
        bloodGroup: <?php echo json_encode($user->blood_group ?? 'your blood group', 15, 512) ?>,
    };

    (() => {
        const storageKey = 'eblood-readiness-toolkit';
        const defaultTemplate = `I am available to donate in <?php echo e($user->city ?? 'my city'); ?>. Please contact me on <?php echo e($user->phone ?? 'my phone number'); ?> if a blood donation request needs urgent help.`;
        const progressFill = document.getElementById('readiness-progress-fill');
        const progressText = document.getElementById('readiness-progress');
        const statusBadge = document.getElementById('readiness-status');
        const boxes = Array.from(document.querySelectorAll('[data-readiness-item]'));
        const templateInput = document.getElementById('ready-message-template');
        const copyButton = document.getElementById('copy-ready-message');
        const resetButton = document.getElementById('reset-ready-message');
        const cityTemplateButton = document.getElementById('city-template-button');
        const copyStatus = document.getElementById('copy-status');
        const alertToggle = document.getElementById('local-alert-toggle');
        const alertsLabel = document.getElementById('alerts-label');

        const loadState = () => {
            try {
                return JSON.parse(localStorage.getItem(storageKey) || '{}');
            } catch (error) {
                return {};
            }
        };

        const saveState = (state) => {
            localStorage.setItem(storageKey, JSON.stringify(state));
        };

        const updateReadiness = () => {
            const state = loadState();
            let checked = 0;

            boxes.forEach((box) => {
                box.checked = Boolean(state[box.dataset.readinessItem]);
                if (box.checked) {
                    checked += 1;
                }
            });

            const total = boxes.length;
            const percent = total ? Math.round((checked / total) * 100) : 0;
            const remaining = total - checked;

            progressFill.style.width = `${percent}%`;
            progressText.textContent = `${percent}% ready`;
            statusBadge.textContent = remaining === 0 ? 'Ready to respond' : `${remaining} step${remaining > 1 ? 's' : ''} left`;
            statusBadge.className = remaining === 0
                ? 'rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-200'
                : 'rounded-full bg-amber-100 px-3 py-1 text-sm font-semibold text-amber-700 dark:bg-amber-950/60 dark:text-amber-200';
        };

        boxes.forEach((box) => {
            box.addEventListener('change', () => {
                const state = loadState();
                state[box.dataset.readinessItem] = box.checked;
                saveState(state);
                updateReadiness();
            });
        });

        if (copyButton && templateInput && copyStatus) {
            copyButton.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(templateInput.value);
                    copyStatus.textContent = 'Copied to clipboard. Send it when you are ready to respond.';
                } catch (error) {
                    copyStatus.textContent = 'Clipboard access is unavailable, so copy this text manually.';
                }
            });
        }

        if (resetButton && templateInput) {
            resetButton.addEventListener('click', () => {
                templateInput.value = defaultTemplate;
                copyStatus.textContent = 'Template reset to the default quick response.';
            });
        }

        if (cityTemplateButton && templateInput) {
            cityTemplateButton.addEventListener('click', () => {
                templateInput.value = `I am available to donate in <?php echo e($user->city ?? 'my city'); ?>. Please contact me on <?php echo e($user->phone ?? 'my phone number'); ?> if a blood donation request needs urgent help.`;
                copyStatus.textContent = 'Updated the template with your current city and contact details.';
            });
        }

        if (alertToggle && alertsLabel) {
            const alertStateKey = 'eblood-alerts-preference';
            const syncAlertState = () => {
                const enabled = localStorage.getItem(alertStateKey) === 'enabled';
                alertToggle.textContent = enabled ? 'Disable' : 'Enable';
                alertsLabel.textContent = enabled ? 'Enabled for local browser alerts' : 'Currently disabled';
                alertToggle.className = enabled
                    ? 'rounded-full bg-emerald-600 px-4 py-2 text-sm font-semibold text-white'
                    : 'rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white dark:bg-white dark:text-slate-900';
            };

            alertToggle.addEventListener('click', async () => {
                const currentlyEnabled = localStorage.getItem(alertStateKey) === 'enabled';
                const nextState = currentlyEnabled ? 'disabled' : 'enabled';

                localStorage.setItem(alertStateKey, nextState);

                if (!currentlyEnabled && typeof window.eBloodSmart?.requestNotificationPermission === 'function') {
                    await window.eBloodSmart.requestNotificationPermission();
                }

                syncAlertState();
            });

            syncAlertState();
        }

        updateReadiness();
    })();
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.donor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views\donor\home.blade.php ENDPATH**/ ?>