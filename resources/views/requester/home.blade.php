@extends('layouts.app')

@section('content')

<div class="space-y-8">

    <section class="rounded-2xl bg-gradient-to-r from-red-600 to-rose-500 text-white p-6 sm:p-8 shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold break-words">Hello {{ $user->name }},</h1>
                <p class="mt-2 text-sm opacity-90">Your requester dashboard gives you fast access to emergency requests and status updates.</p>
                <p class="mt-3 text-xs sm:text-sm italic">"Help is closer when you make your needs visible."</p>

                <div class="mt-4 flex flex-wrap gap-2 sm:gap-3">
                    <a href="{{ route('requester.requests.create') }}" class="inline-flex items-center gap-2 bg-white text-red-600 px-3 sm:px-4 py-2 rounded-full text-sm sm:text-base font-semibold shadow hover:opacity-95">New Request</a>
                    <a href="{{ route('requester.requests.index') }}" class="inline-flex items-center gap-2 bg-white/20 text-white px-3 sm:px-4 py-2 rounded-full text-sm sm:text-base font-semibold border border-white/30 hover:opacity-95">My Requests</a>
                </div>
            </div>

            <div class="flex items-center gap-3 sm:gap-4 flex-shrink-0">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden border-4 border-white flex-shrink-0">
                    @if(isset($user->profile_image) && $user->profile_image)
                        <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}" alt="Profile" class="w-full h-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=fff&color=dc2626&size=256" alt="avatar" class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="text-sm sm:text-base">
                    <div class="font-semibold">Request Status</div>
                    <div class="text-lg sm:text-xl font-bold">{{ $totalRequests }}</div>
                    <div class="mt-2 text-xs sm:text-sm">Requests made</div>
                </div>
            </div>
        </div>
    </section>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm text-slate-500 dark:text-slate-400">Total Requests</p>
            <p class="text-2xl font-bold text-red-600">{{ $totalRequests }}</p>
        </div>
        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm text-slate-500 dark:text-slate-400">Pending</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $pendingRequests }}</p>
        </div>
        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm text-slate-500 dark:text-slate-400">Approved</p>
            <p class="text-2xl font-bold text-blue-600">{{ $approvedRequests }}</p>
        </div>
        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm text-slate-500 dark:text-slate-400">Completed</p>
            <p class="text-2xl font-bold text-green-600">{{ $completedRequests }}</p>
        </div>
    </div>

    <div class="card-panel dark:card-panel-dark">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Recent Requests</h3>
            <a href="{{ route('requester.requests.index') }}" class="text-sm text-blue-600 hover:underline">View all</a>
            <div class="space-y-4">
                @forelse($recentRequests as $request)
                    <div class="card-panel dark:card-panel-dark">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div>
                                <h4 class="text-lg font-semibold">{{ $request->patient_name }}</h4>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $request->blood_group }} • {{ $request->hospital }}, {{ $request->city }}</p>
                            </div>
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $request->status === 'Approved' ? 'bg-blue-100 text-blue-800' : ($request->status === 'Completed' ? 'bg-green-100 text-green-800' : ($request->status === 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')) }}">{{ $request->status ?? 'Pending' }}</span>
                        </div>
                        @if($request->admin_message)
                            <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">Admin message: {{ $request->admin_message }}</p>
                        @endif
                        <p class="mt-3 text-xs text-slate-400">Submitted {{ optional($request->created_at)->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-slate-500">No recent requests yet. Start by creating a new emergency request.</p>
                @endforelse
            </div>
    </div>

</div>

@endsection
