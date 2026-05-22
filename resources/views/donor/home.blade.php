@extends('layouts.app')

@section('content')

<div class="space-y-8">

    <section class="rounded-2xl bg-gradient-to-r from-red-600 to-rose-500 text-white p-6 sm:p-8 shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold break-words">Welcome back, {{ $user->name }}</h1>
                <p class="mt-2 text-sm opacity-90">Your donor profile is active. Keep availability up to date so patients can connect quickly.</p>
                <p class="mt-3 text-xs sm:text-sm italic">"Every donation creates a ripple of healing."</p>

                <div class="mt-4 flex flex-wrap gap-2 sm:gap-3">
                    <a href="/profile" class="inline-flex items-center gap-2 bg-white text-red-600 px-3 sm:px-4 py-2 rounded-full text-sm sm:text-base font-semibold shadow hover:opacity-95">Profile</a>
                    <a href="/profile/edit" class="inline-flex items-center gap-2 bg-white/20 text-white px-3 sm:px-4 py-2 rounded-full text-sm sm:text-base font-semibold border border-white/30 hover:opacity-95">Edit Details</a>
                    <a href="/toggle-status" class="inline-flex items-center gap-2 bg-white/20 text-white px-3 sm:px-4 py-2 rounded-full text-sm sm:text-base font-semibold border border-white/30 hover:opacity-95">Toggle Availability</a>
                </div>
            </div>

            <div class="flex items-center gap-3 sm:gap-4 flex-shrink-0">
                <div class="w-20 h-20 sm:w-28 sm:h-28 rounded-full overflow-hidden border-4 border-white flex-shrink-0">
                    @if(isset($user->profile_image) && $user->profile_image)
                        <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}" alt="Profile" class="w-full h-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=fff&color=dc2626&size=256" alt="avatar" class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="text-sm sm:text-base">
                    <div class="font-semibold">Blood Group</div>
                    <div class="text-lg sm:text-xl font-bold">{{ $user->blood_group ?? 'N/A' }}</div>
                    <div class="mt-2 text-xs sm:text-sm">City: {{ $user->city ?? '—' }}</div>
                    <div class="mt-2">
                        <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-medium {{ $user->available === 'yes' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">{{ $user->available === 'yes' ? 'Available' : 'Unavailable' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
            <p class="text-sm text-gray-500">Joined</p>
            <p class="text-2xl font-bold text-red-600">{{ optional($user->created_at)->format('M Y') ?? 'N/A' }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
            <p class="text-sm text-gray-500">Contact</p>
            <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $user->phone ?? 'Not added' }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
            <p class="text-sm text-gray-500">Location</p>
            <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $user->city ?? 'Not added' }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Donor actions</h3>
            <span class="text-sm text-gray-500">Manage your profile and availability</span>
        </div>
        <div class="grid gap-3 sm:grid-cols-3">
            <a href="/profile" class="block rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-center text-sm font-semibold text-red-600 hover:bg-red-100 transition">View Profile</a>
            <a href="/profile/edit" class="block rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-center text-sm font-semibold text-slate-900 hover:bg-slate-100 transition">Edit Details</a>
            <a href="/toggle-status" class="block rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-center text-sm font-semibold text-slate-900 hover:bg-slate-100 transition">Toggle Availability</a>
        </div>
    </div>

</div>

@endsection
