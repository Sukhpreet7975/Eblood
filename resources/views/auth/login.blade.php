@extends('layouts.app')

@section('content')

<div class="max-w-sm mx-auto mt-8">

    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-6">

        <!-- Heading -->
        <div class="text-center mb-5">
            <h1 class="text-3xl font-extrabold text-red-600">
                Welcome Back
            </h1>

            <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                Login to continue
            </p>
        </div>

        <div id="login-error" class="hidden bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded-lg mb-4 text-sm"></div>

        <form method="POST" action="{{ route('login') }}" id="login-form">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-sm">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full border p-3 rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-red-500"
                    placeholder="Enter email">
                @error('email')
                <p class="text-red-500 mt-1 text-xs">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-sm">
                    Password
                </label>

                <div class="relative">
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="w-full border p-3 rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Enter password">

                    <button
                        type="button"
                        onclick="togglePassword()"
                        class="absolute right-3 top-3 text-gray-500 hover:text-red-600 transition">
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
                @error('password')
                <p class="text-red-500 mt-1 text-xs">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Remember -->
            <div class="flex items-center mb-4 text-sm">
                <input
                    type="checkbox"
                    name="remember"
                    class="mr-2">
                <label>
                    Remember Me
                </label>
            </div>

            <button id="login-btn" class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition duration-300">
                Login
            </button>
        </form>

        <div id="forgot-password-badge" class="hidden mt-4">
            <div class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-red-50 px-4 py-2 text-sm text-red-700">
                <span>Need help?</span>
                <button
                    type="button"
                    id="forgot-password-button"
                    class="font-semibold text-red-600 hover:text-red-700 transition">
                    Forgot Password?
                </button>
            </div>
        </div>

        <p class="text-center mt-5 text-sm text-gray-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-red-600 font-semibold">
                Register
            </a>
        </p>
    </div>
</div>

<div id="modal-overlay" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-lg space-y-6">

        <div id="email-modal" class="hidden bg-white dark:bg-gray-900 rounded-3xl shadow-2xl p-6 border border-gray-200 dark:border-gray-700 transition-transform duration-300">
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
                    <input id="verify-email" type="email" name="email" class="w-full border p-3 rounded-xl dark:bg-gray-800 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Enter your email address" required>
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

        <div id="reset-modal" class="hidden bg-white dark:bg-gray-900 rounded-3xl shadow-2xl p-6 border border-gray-200 dark:border-gray-700 transition-transform duration-300">
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
                        <input id="new-password" type="password" name="password" class="w-full border p-3 rounded-xl dark:bg-gray-800 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Enter new password" required>
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
                        <input id="confirm-password" type="password" name="password_confirmation" class="w-full border p-3 rounded-xl dark:bg-gray-800 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Confirm new password" required>
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
    const forgotPasswordBadge = document.getElementById('forgot-password-badge');
    const loginError = document.getElementById('login-error');
    const loginForm = document.getElementById('login-form');
    const loginButton = document.getElementById('login-btn');
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

        const response = await fetch('{{ route('password.verify-email') }}', {
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
            verifyEmailError.innerHTML += ' <a href="{{ route('register') }}" class="font-semibold text-red-600 hover:text-red-700">Create an account</a>';
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

        const response = await fetch('{{ route('password.reset.direct') }}', {
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
            forgotPasswordBadge?.classList.add('hidden');
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

    loginForm.addEventListener('submit', async (event) => {
        event.preventDefault();

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
        if (failedAttempts >= 2) {
            forgotPasswordBadge?.classList.remove('hidden');
        }

        loginError.textContent = data?.message || 'Invalid credentials. Please try again.';
        loginError.classList.remove('hidden');
        loginButton.innerHTML = 'Login';
        loginButton.disabled = false;
        loginButton.classList.remove('opacity-50');
    });

    function togglePassword() {
        const password = document.getElementById('password');
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

@endsection