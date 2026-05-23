<?php $__env->startSection('content'); ?>

<div class="min-h-screen flex items-center justify-center px-4 py-10 sm:px-6 bg-slate-50 dark:bg-slate-950">
    <div class="w-full max-w-6xl grid gap-8 lg:grid-cols-[1.2fr_0.9fr]">
        <div class="hidden overflow-hidden rounded-[2rem] bg-gradient-to-br from-red-600 via-rose-500 to-pink-500 p-10 text-white shadow-2xl lg:flex lg:flex-col lg:justify-between">
            <div class="space-y-6">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.26em] text-white/90">
                    E-Blood Secure Access
                </div>

                <div class="space-y-4">
                    <h2 class="text-4xl font-extrabold tracking-tight text-white">
                        Professional login for donors, requesters and admins
                    </h2>
                    <p class="max-w-xl text-sm text-white/80">
                        Sign in with confidence to manage blood requests, view status updates, and help patients faster.
                    </p>
                </div>

                <div class="space-y-4 text-sm text-white/90">
                    <div class="inline-flex items-center gap-3 rounded-3xl bg-white/10 px-4 py-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/20 text-white">
                            ✓
                        </span>
                        <span>Secure, role-based access</span>
                    </div>
                    <div class="inline-flex items-center gap-3 rounded-3xl bg-white/10 px-4 py-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/20 text-white">
                            ✓
                        </span>
                        <span>Fast access to your dashboard</span>
                    </div>
                    <div class="inline-flex items-center gap-3 rounded-3xl bg-white/10 px-4 py-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/20 text-white">
                            ✓
                        </span>
                        <span>24/7 support for critical requests</span>
                    </div>
                </div>
            </div>

            <div class="rounded-[1.5rem] border border-white/20 bg-white/10 p-5 text-sm text-white/85">
                <p class="font-semibold">Need help signing in?</p>
                <p class="mt-2 leading-6 text-white/80">If you have trouble logging in, ask your organization administrator or use the forgot password flow.</p>
            </div>
        </div>

        <div class="glass-card dark:glass-card-dark overflow-hidden">
            <div class="px-6 py-8 sm:px-10 sm:py-10">
                <div class="mb-8 text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-red-600">Secure sign in</p>
                    <h1 class="mt-4 text-3xl font-extrabold text-slate-900 dark:text-white">Welcome back</h1>
                    <p class="mx-auto mt-2 max-w-md text-sm text-slate-500 dark:text-slate-400">
                        Login to continue to your E-Blood dashboard and support urgent requests.
                    </p>
                </div>

                <div id="login-error" class="hidden rounded-3xl border border-red-200 bg-red-50 px-4 py-3 text-red-700 text-sm shadow-sm mb-5"></div>

                <form method="POST" action="<?php echo e(route('login')); ?>" id="login-form">
                    <?php echo csrf_field(); ?>

                    <div class="grid gap-5">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                                Email address
                            </label>
                            <input
                                id="login-email"
                                type="email"
                                name="email"
                                value="<?php echo e(old('email')); ?>"
                                class="form-field dark:form-field-dark"
                                placeholder="name@example.com">
                            <p id="email-field-error" class="mt-2 hidden text-xs text-red-500"></p>
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
                                    id="login-password"
                                    type="password"
                                    name="password"
                                    class="form-field dark:form-field-dark"
                                    placeholder="Enter password">
                                <button
                                    type="button"
                                    onclick="togglePassword()"
                                    class="absolute right-3 top-3 text-slate-400 hover:text-red-600 transition">
                                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7 -1.274 4.057-5.065 7 -9.542 7-4.477 0 -8.268-2.943-9.542-7z" />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                            <p id="password-field-error" class="mt-2 hidden text-xs text-red-500"></p>
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
                            <p class="mb-3 text-sm font-semibold uppercase tracking-[0.18em] text-slate-500 dark:text-slate-400">Login type</p>
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
                                    <input id="role-admin" type="radio" name="role" value="admin" <?php echo e(old('role') === 'admin' ? 'checked' : ''); ?> class="peer sr-only" required>
                                    <label for="role-admin" class="block cursor-pointer rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-center text-sm font-medium text-slate-700 transition hover:border-red-400 hover:text-red-700 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 peer-checked:border-red-600 peer-checked:bg-red-50 peer-checked:text-red-700">
                                        Admin
                                    </label>
                                </div>
                            </div>
                            <p id="role-field-error" class="mt-2 hidden text-xs text-red-500"></p>
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

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between text-sm text-slate-600 dark:text-slate-400">
                            <label class="inline-flex items-center gap-2">
                                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-red-600 focus:ring-red-500">
                                Remember me
                            </label>
                            <button type="button" id="forgot-password-button" class="font-semibold text-red-600 hover:text-red-700 transition">
                                Forgot password?
                            </button>
                        </div>
                    </div>

                    <button id="login-btn" type="submit" class="mt-6 w-full rounded-3xl bg-red-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-red-500/20 transition hover:bg-red-700">
                        Login
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">
                    Don’t have an account? <a href="<?php echo e(route('register')); ?>" class="font-semibold text-red-600 hover:text-red-700">Register</a>
                </p>
            </div>
        </div>
    </div>
</div>

<div id="modal-overlay" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm px-4 py-8">
    <div class="flex min-h-full items-center justify-center w-full">
        <div class="w-full max-w-lg space-y-6">

        <div id="email-modal" class="hidden card-panel dark:card-panel-dark transition-transform duration-300">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Forgot Password
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Enter the email for your account to continue.
                    </p>
                </div>

                <button type="button" onclick="closeModal()" class="text-gray-500 hover:text-red-600 transition">×</button>
            </div>

            <div id="verify-email-error" class="hidden bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-4 text-sm"></div>

            <form id="verify-email-form" class="space-y-4">
                <div>
                    <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">Email address</label>
                    <input id="verify-email" type="email" name="email" class="form-field dark:form-field-dark" placeholder="Enter your email address" required>
                </div>

                <div class="flex items-center justify-between gap-3">
                    <button type="button" onclick="closeModal()" class="w-full border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-200 rounded-xl py-3 hover:bg-gray-100 transition">
                        Cancel
                    </button>
                    <button type="submit" class="w-full bg-red-600 text-white rounded-xl py-3 font-semibold hover:bg-red-700 transition">
                        Continue
                    </button>
                </div>
            </form>
        </div>

        <div id="reset-modal" class="hidden card-panel dark:card-panel-dark transition-transform duration-300">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Reset Password
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Choose a new password for your account.
                    </p>
                </div>

                <button type="button" onclick="closeModal()" class="text-gray-500 hover:text-red-600 transition">×</button>
            </div>

            <div id="reset-password-error" class="hidden bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-4 text-sm"></div>
            <div id="reset-password-success" class="hidden bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-4 text-sm"></div>

            <form id="reset-password-form" class="space-y-4">
                <input type="hidden" id="reset-email" name="email">

                <div>
                    <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">New Password</label>
                    <div class="relative">
                        <input id="new-password" type="password" name="password" minlength="8" class="form-field dark:form-field-dark" placeholder="Enter new password" required>
                        <button type="button" onclick="toggleResetPassword('new-password', 'new-eye-icon')" class="absolute right-3 top-3 text-gray-500 hover:text-red-600 transition">
                            <svg id="new-eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7 -1.274 4.057-5.065 7 -9.542 7-4.477 0 -8.268-2.943-9.542-7z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">Confirm Password</label>
                    <div class="relative">
                        <input id="confirm-password" type="password" name="password_confirmation" minlength="8" class="form-field dark:form-field-dark" placeholder="Confirm new password" required>
                        <button type="button" onclick="toggleResetPassword('confirm-password', 'confirm-eye-icon')" class="absolute right-3 top-3 text-gray-500 hover:text-red-600 transition">
                            <svg id="confirm-eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7 -1.274 4.057-5.065 7 -9.542 7-4.477 0 -8.268-2.943-9.542-7z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <p id="password-feedback" class="text-sm text-gray-500 dark:text-gray-400"></p>

                <div class="flex items-center justify-between gap-3">
                    <button type="button" onclick="closeModal()" class="w-full border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-200 rounded-xl py-3 hover:bg-gray-100 transition">
                        Cancel
                    </button>
                    <button id="reset-submit" type="submit" class="w-full bg-red-600 text-white rounded-xl py-3 font-semibold hover:bg-red-700 transition disabled:opacity-50" disabled>
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="popup-success" class="hidden max-w-sm mx-auto mt-4 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-2xl text-sm"></div>

<script>
    const forgotPasswordButton = document.getElementById('forgot-password-button');
    const modalOverlay = document.getElementById('modal-overlay');
    const emailModal = document.getElementById('email-modal');
    const resetModal = document.getElementById('reset-modal');
    const verifyForm = document.getElementById('verify-email-form');
    const resetForm = document.getElementById('reset-password-form');
    const verifyInput = document.getElementById('verify-email');
    const resetEmailInput = document.getElementById('reset-email');
    const newPasswordInput = document.getElementById('new-password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const resetSubmit = document.getElementById('reset-submit');
    const passwordFeedback = document.getElementById('password-feedback');
    const verifyEmailError = document.getElementById('verify-email-error');
    const resetPasswordError = document.getElementById('reset-password-error');
    const resetPasswordSuccess = document.getElementById('reset-password-success');
    const popupSuccess = document.getElementById('popup-success');
    const loginError = document.getElementById('login-error');
    const loginForm = document.getElementById('login-form');
    const loginButton = document.getElementById('login-btn');
    const emailFieldError = document.getElementById('email-field-error');
    const passwordFieldError = document.getElementById('password-field-error');
    const roleFieldError = document.getElementById('role-field-error');
    let failedAttempts = 0;

    function openModal(modalId) {
        modalOverlay.classList.remove('hidden');
        emailModal.classList.add('hidden');
        resetModal.classList.add('hidden');
        verifyEmailError.classList.add('hidden');
        resetPasswordError.classList.add('hidden');
        resetPasswordSuccess.classList.add('hidden');
        passwordFeedback.textContent = '';
        resetSubmit.disabled = true;
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal() {
        modalOverlay.classList.add('hidden');
        emailModal.classList.add('hidden');
        resetModal.classList.add('hidden');
    }

    if (forgotPasswordButton) {
        forgotPasswordButton.addEventListener('click', () => {
            openModal('email-modal');
            verifyInput.value = '';
            verifyInput.focus();
        });
    }

    modalOverlay.addEventListener('click', (event) => {
        if (event.target === modalOverlay) {
            closeModal();
        }
    });

    function getCsrfToken() {
        return document.querySelector('input[name="_token"]').value;
    }

    verifyForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        verifyEmailError.classList.add('hidden');
        verifyEmailError.textContent = '';

        const email = verifyInput.value.trim();
        if (!email) {
            verifyEmailError.textContent = 'Please enter your email address.';
            verifyEmailError.classList.remove('hidden');
            return;
        }

        const response = await fetch('<?php echo e(route('password.verify-email')); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ email }),
        });

        if (response.ok) {
            const data = await response.json();
            resetEmailInput.value = email;
            openModal('reset-modal');
            newPasswordInput.value = '';
            confirmPasswordInput.value = '';
            passwordFeedback.textContent = 'Create a secure password with at least 8 characters.';
            resetPasswordSuccess.classList.add('hidden');
            resetSubmit.disabled = true;
        } else {
            const data = await response.json().catch(() => null);
            verifyEmailError.textContent = data?.message || 'We couldn’t find an account with that email.';
            verifyEmailError.innerHTML += ' <a href="<?php echo e(route('register')); ?>" class="font-semibold text-red-600 hover:text-red-700">Create an account</a>';
            verifyEmailError.classList.remove('hidden');
        }
    });

    function updateResetValidation() {
        const password = newPasswordInput.value;
        const confirm = confirmPasswordInput.value;
        let message = '';
        let valid = true;

        if (password.length < 8) {
            message = 'Password must be at least 8 characters.';
            valid = false;
        } else if (confirm && password !== confirm) {
            message = 'Passwords do not match.';
            valid = false;
        } else if (!confirm) {
            message = 'Confirm your new password to continue.';
            valid = false;
        } else {
            message = 'Passwords match and meet the security requirements.';
        }

        passwordFeedback.textContent = message;
        passwordFeedback.classList.toggle('text-red-500', !valid);
        passwordFeedback.classList.toggle('text-green-600', valid);
        resetSubmit.disabled = !valid;
    }

    newPasswordInput.addEventListener('input', updateResetValidation);
    confirmPasswordInput.addEventListener('input', updateResetValidation);

    resetForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        resetPasswordError.classList.add('hidden');
        resetPasswordSuccess.classList.add('hidden');

        const email = resetEmailInput.value;
        const password = newPasswordInput.value;
        const passwordConfirmation = confirmPasswordInput.value;

        if (password.length < 8 || password !== passwordConfirmation) {
            resetPasswordError.textContent = 'Please resolve password issues before continuing.';
            resetPasswordError.classList.remove('hidden');
            return;
        }

        const response = await fetch('<?php echo e(route('password.reset.direct')); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({
                email,
                password,
                password_confirmation: passwordConfirmation,
            }),
        });

        const data = await response.json().catch(() => null);

        if (response.ok && data?.success) {
            failedAttempts = 0;
            loginError.classList.add('hidden');
            resetPasswordSuccess.textContent = data.message;
            resetPasswordSuccess.classList.remove('hidden');
            resetPasswordError.classList.add('hidden');
            resetSubmit.disabled = true;
            setTimeout(() => {
                closeModal();
                popupSuccess.textContent = data.message;
                popupSuccess.classList.remove('hidden');
                setTimeout(() => popupSuccess.classList.add('hidden'), 6000);
            }, 1400);
        } else {
            resetPasswordError.textContent = data?.message || 'Unable to reset password. Please try again.';
            resetPasswordError.classList.remove('hidden');
        }
    });

    function clearFieldErrors() {
        emailFieldError.classList.add('hidden');
        emailFieldError.textContent = '';
        passwordFieldError.classList.add('hidden');
        passwordFieldError.textContent = '';
        roleFieldError.classList.add('hidden');
        roleFieldError.textContent = '';
    }

    function setFieldError(element, message) {
        if (!element) {
            return;
        }

        element.textContent = message;
        element.classList.remove('hidden');
    }

    loginForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        clearFieldErrors();
        loginError.classList.add('hidden');
        loginError.textContent = '';
        loginButton.innerHTML = 'Logging in...';
        loginButton.disabled = true;
        loginButton.classList.add('opacity-50');

        const formData = new FormData(loginForm);
        const body = {
            email: formData.get('email'),
            password: formData.get('password'),
            remember: formData.get('remember') ? true : false,
            role: formData.get('role') || '',
        };

        const response = await fetch(loginForm.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify(body),
        });

        const data = await response.json().catch(() => null);

        if (response.ok && data?.success) {
            window.location.href = data.redirect;
            return;
        }

        failedAttempts += 1;

        const errors = data?.errors ?? {};

        if (errors.email?.[0]) {
            setFieldError(emailFieldError, errors.email[0]);
        }

        if (errors.password?.[0]) {
            setFieldError(passwordFieldError, errors.password[0]);
        }

        if (errors.role?.[0]) {
            setFieldError(roleFieldError, errors.role[0]);
        }

        if (!errors.email?.[0] && !errors.password?.[0] && !errors.role?.[0]) {
            loginError.textContent = data?.message || 'Invalid credentials. Please try again.';
            loginError.classList.remove('hidden');
        }

        loginButton.innerHTML = 'Login';
        loginButton.disabled = false;
        loginButton.classList.remove('opacity-50');
    });

    function togglePassword() {
        const password = document.getElementById('login-password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (password.type === 'password') {
            password.type = 'text';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.477 10.482a3 3 0 004.243 4.243M9.88 5.09A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.132 5.411M6.228 6.228A9.956 9.956 0 002.458 12c1.274 4.057 5.064 7 9.542 7 1.61 0 3.13-.308 4.523-.868" />`;
        } else {
            password.type = 'password';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />`;
        }
    }

    function toggleResetPassword(fieldId, iconId) {
        const input = document.getElementById(fieldId);
        const eyeIcon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.477 10.482a3 3 0 004.243 4.243M9.88 5.09A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.132 5.411M6.228 6.228A9.956 9.956 0 002.458 12c1.274 4.057 5.064 7 9.542 7 1.61 0 3.13-.308 4.523-.868" />`;
        } else {
            input.type = 'password';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />`;
        }
    }

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views\auth\login.blade.php ENDPATH**/ ?>