@extends('layouts.app')

@section('content')

<div class="flex justify-center items-center min-h-[80vh]">
    <div class="bg-white shadow-2xl rounded-2xl p-10 w-full max-w-lg">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-red-600">
                Register
            </h1>
            <p class="text-gray-500 mt-2">
                Become part of the E-Blood Donation community
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            @if ($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Name -->
            <div class="mb-5">
                <label class="block mb-2 font-semibold">
                    Full Name
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-red-500">
                @error('name')
                <p class="text-red-500 mt-1 text-xs">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-5">
                <label class="block mb-2 font-semibold">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-red-500">
                @error('email')
                <p class="text-red-500 mt-1 text-xs">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-5">
                <label class="block mb-2 font-semibold">
                    Password
                </label>
                <div class="relative">
                    <input
                        type="password"
                        name="password"
                        id="password"
                        minlength="8"
                        required
                        class="w-full border border-gray-300 rounded-lg p-3 pr-11 focus:outline-none focus:ring-2 focus:ring-red-500"
                        autocomplete="new-password"
                    >
                    <button type="button" onclick="togglePassword('password', 'passwordToggleIcon')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-red-600">
                        <svg id="passwordToggleIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
                @error('password')
                <p class="text-red-500 mt-1 text-xs">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-5">
                <label class="block mb-2 font-semibold">
                    Confirm Password
                </label>
                <div class="relative">
                    <input
                        type="password"
                        name="password_confirmation"
                        id="confirm_password"
                        minlength="8"
                        required
                        class="w-full border border-gray-300 rounded-lg p-3 pr-11 focus:outline-none focus:ring-2 focus:ring-red-500"
                        autocomplete="new-password"
                    >
                    <button type="button" onclick="togglePassword('confirm_password', 'confirmPasswordToggleIcon')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-red-600">
                        <svg id="confirmPasswordToggleIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
                @error('password_confirmation')
                <p class="text-red-500 mt-1 text-xs">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Role Selection -->
            <div class="mb-5">
                <label class="block mb-2 font-semibold">Register As</label>
                <div class="flex items-center gap-6">
                    <label class="inline-flex items-center">
                        <input type="radio" name="role" value="donor" {{ old('role', 'donor') == 'donor' ? 'checked' : '' }} class="form-radio" />
                        <span class="ml-2">Donor</span>
                    </label>

                    <label class="inline-flex items-center">
                        <input type="radio" name="role" value="admin" {{ (isset($adminExists) && $adminExists) ? 'disabled' : '' }} {{ old('role') == 'admin' ? 'checked' : '' }} class="form-radio" />
                        <span class="ml-2">Admin</span>
                    </label>
                </div>

                @if(isset($adminExists) && $adminExists)
                    <p class="text-xs text-gray-500 mt-2">An admin account already exists. Admin registration is disabled.</p>
                @endif

                @error('role')
                <p class="text-red-500 mt-1 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <!-- Register Button -->
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-lg font-bold transition">
                Register
            </button>
        </form>

        <!-- Login Link -->
        <p class="text-center mt-6 text-gray-600">
            Already have an account?
            <a href="/login" class="text-red-600 font-bold">
                Login
            </a>
        </p>
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

@endsection