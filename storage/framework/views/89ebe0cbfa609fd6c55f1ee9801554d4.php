<?php $__env->startSection('content'); ?>

<div class="min-h-screen flex items-center justify-center px-4 py-10 sm:px-6 bg-slate-50 dark:bg-slate-950">
    <div class="w-full max-w-6xl grid gap-8 lg:grid-cols-[1.2fr_0.9fr]">
        <div class="hidden overflow-hidden rounded-[2rem] bg-gradient-to-br from-red-600 via-rose-500 to-pink-500 p-10 text-white shadow-2xl lg:flex lg:flex-col lg:justify-between">
            <div class="space-y-6">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.26em] text-white/90">
                    E-Blood Registration
                </div>

                <div class="space-y-4">
                    <h2 class="text-4xl font-extrabold tracking-tight text-white">
                        Join the E-Blood community
                    </h2>
                    <p class="max-w-xl text-sm text-white/80">
                        Create your account and start managing requests, tracking donations, and supporting urgent patient needs with confidence.
                    </p>
                </div>

                <div class="space-y-4 text-sm text-white/90">
                    <div class="inline-flex items-center gap-3 rounded-3xl bg-white/10 px-4 py-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/20 text-white">
                            ✓
                        </span>
                        <span>Professional, secure experience</span>
                    </div>
                    <div class="inline-flex items-center gap-3 rounded-3xl bg-white/10 px-4 py-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/20 text-white">
                            ✓
                        </span>
                        <span>Easy role-based registration</span>
                    </div>
                    <div class="inline-flex items-center gap-3 rounded-3xl bg-white/10 px-4 py-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/20 text-white">
                            ✓
                        </span>
                        <span>Fast access to patient support tools</span>
                    </div>
                </div>
            </div>

            <div class="rounded-[1.5rem] border border-white/20 bg-white/10 p-5 text-sm text-white/85">
                <p class="font-semibold">Role descriptions</p>

                <ul class="mt-3 space-y-2 text-sm leading-6 text-white/80">
                    <li>
                        <strong>Donor:</strong> Offer blood donations, manage your availability, view donation history, and receive donation requests.
                    </li>
                    <li>
                        <strong>Requester:</strong> Create and manage blood requests for patients, track request status, and coordinate with donors and hospitals.
                    </li>
                    <li>
                        <strong>Admin:</strong> Oversee the platform — approve or reject requests, manage users and roles, and access system settings. Admin registration may be restricted.
                    </li>
                </ul>
            </div>
        </div>

        <div class="glass-card dark:glass-card-dark overflow-hidden">
            <div class="px-6 py-8 sm:px-10 sm:py-10">
                <div class="mb-8 text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-red-600">Create account</p>
                    <h1 class="mt-4 text-3xl font-extrabold text-slate-900 dark:text-white">Register with E-Blood</h1>
                    <p class="mx-auto mt-2 max-w-md text-sm text-slate-500 dark:text-slate-400">
                        Join donors, requesters, or admins with a secure account that gives you access to the E-Blood portal.
                    </p>
                </div>

                <?php if($errors->any()): ?>
                    <div class="rounded-3xl border border-red-200 bg-red-50 px-4 py-3 text-red-700 text-sm shadow-sm mb-6">
                        <ul class="list-disc list-inside space-y-2">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('register')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="grid gap-5">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                                Full name
                            </label>
                            <input
                                type="text"
                                name="name"
                                value="<?php echo e(old('name')); ?>"
                                required
                                class="form-field dark:form-field-dark"
                                placeholder="Jane Doe">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-xs text-red-500"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                                Email address
                            </label>
                            <input
                                type="email"
                                name="email"
                                value="<?php echo e(old('email')); ?>"
                                required
                                class="form-field dark:form-field-dark"
                                placeholder="name@example.com">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-xs text-red-500"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                                Password
                            </label>
                            <div class="relative">
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    minlength="8"
                                    required
                                    class="form-field dark:form-field-dark"
                                    autocomplete="new-password"
                                    placeholder="Enter password">
                                <button type="button" onclick="togglePassword('password', 'passwordToggleIcon')" class="absolute right-3 top-3 text-slate-400 hover:text-red-600 transition">
                                    <svg id="passwordToggleIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-xs text-red-500"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                                Confirm password
                            </label>
                            <div class="relative">
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="confirm_password"
                                    minlength="8"
                                    required
                                    class="form-field dark:form-field-dark"
                                    autocomplete="new-password"
                                    placeholder="Confirm password">
                                <button type="button" onclick="togglePassword('confirm_password', 'confirmPasswordToggleIcon')" class="absolute right-3 top-3 text-slate-400 hover:text-red-600 transition">
                                    <svg id="confirmPasswordToggleIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                            <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-xs text-red-500"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <p class="mb-3 text-sm font-semibold uppercase tracking-[0.18em] text-slate-500 dark:text-slate-400">Register as</p>
                            <div class="grid gap-3 sm:grid-cols-3">
                                <div>
                                    <input id="role-donor" type="radio" name="role" value="donor" <?php echo e(old('role', 'donor') === 'donor' ? 'checked' : ''); ?> class="peer sr-only" required>
                                    <label for="role-donor" class="block cursor-pointer rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-center text-sm font-medium text-slate-700 transition hover:border-red-400 hover:text-red-700 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 peer-checked:border-red-600 peer-checked:bg-red-50 peer-checked:text-red-700">
                                        Donor
                                    </label>
                                </div>
                                <div>
                                    <input id="role-requester" type="radio" name="role" value="requester" <?php echo e(old('role') === 'requester' ? 'checked' : ''); ?> class="peer sr-only" required>
                                    <label for="role-requester" class="block cursor-pointer rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-center text-sm font-medium text-slate-700 transition hover:border-red-400 hover:text-red-700 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 peer-checked:border-red-600 peer-checked:bg-red-50 peer-checked:text-red-700">
                                        Requester
                                    </label>
                                </div>
                                <div>
                                    <input id="role-admin" type="radio" name="role" value="admin" <?php echo e((isset($adminExists) && $adminExists) ? 'disabled' : ''); ?> <?php echo e(old('role') === 'admin' ? 'checked' : ''); ?> class="peer sr-only" required>
                                    <label for="role-admin" class="block cursor-pointer rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-center text-sm font-medium text-slate-700 transition hover:border-red-400 hover:text-red-700 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 peer-checked:border-red-600 peer-checked:bg-red-50 peer-checked:text-red-700">
                                        Admin
                                    </label>
                                </div>
                            </div>
                            <?php if(isset($adminExists) && $adminExists): ?>
                                <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Admin registration is disabled because an admin account already exists.</p>
                            <?php endif; ?>
                            <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-xs text-red-500"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <button type="submit" class="mt-2 w-full rounded-3xl bg-red-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-red-500/20 transition hover:bg-red-700">
                            Register
                        </button>
                    </div>
                </form>

                <p class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">
                    Already have an account? <a href="<?php echo e(route('login')); ?>" class="font-semibold text-red-600 hover:text-red-700">Login</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.477 10.482a3 3 0 004.243 4.243M9.88 5.09A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.132 5.411M6.228 6.228A9.956 9.956 0 002.458 12c1.274 4.057 5.064 7 9.542 7 1.61 0 3.13-.308 4.523-.868" />
        `;
    } else {
        input.type = 'password';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        `;
    }
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views/auth/register.blade.php ENDPATH**/ ?>