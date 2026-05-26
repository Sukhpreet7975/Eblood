@extends('layouts.app')

@section('title', 'Dashboard - E-Blood')

@section('content')
<div class="mx-auto max-w-7xl px-4 pb-6 pt-4 sm:px-6 lg:px-8">
    <div class="grid gap-5 xl:grid-cols-[1.05fr_1.35fr]">
        <div class="space-y-5">
            <div class="hero-panel rounded-[2rem] px-5 py-7 sm:px-8 sm:py-8">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-2xl">
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-white/85">Welcome back</p>
                        <h1 class="mt-3 text-2xl font-bold leading-tight sm:text-3xl">Hello, {{ $user->name }}</h1>
                        <p class="mt-3 text-sm leading-6 text-white/90 sm:text-base">
                            Review your request activity, update your profile, and keep your emergency response ready.
                        </p>
                    </div>

                    <div class="flex w-full flex-wrap items-stretch gap-2 sm:w-auto sm:justify-end">
                        <span class="w-full rounded-full bg-white/20 px-3 py-2 text-center text-sm font-semibold text-white backdrop-blur-sm sm:w-auto sm:px-4">
                            Blood: {{ $user->blood_group ?? 'N/A' }}
                        </span>
                        <span class="w-full rounded-full bg-white/20 px-3 py-2 text-center text-sm font-semibold text-white backdrop-blur-sm sm:w-auto sm:px-4">
                            City: {{ $user->city ?? 'N/A' }}
                        </span>
                        <span id="availability-badge" class="w-full rounded-full px-3 py-2 text-center text-sm font-bold backdrop-blur-sm sm:w-auto sm:px-4 {{ $user->isDonor() && $user->available == 'yes' ? 'bg-emerald-100 text-emerald-900' : 'bg-rose-100 text-rose-900' }}">
                            {{ $user->isDonor() ? ($user->available == 'yes' ? 'Available' : 'Unavailable') : 'Donor mode off' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="card-panel dark:card-panel-dark">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Requests</p>
                    <p class="mt-2 text-2xl font-bold tracking-tight text-red-600 sm:text-3xl">{{ $totalRequests ?? 0 }}</p>
                </div>
                <div class="card-panel dark:card-panel-dark">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Approved</p>
                    <p class="mt-2 text-2xl font-bold tracking-tight text-sky-600 sm:text-3xl">{{ $approvedRequests ?? 0 }}</p>
                </div>
                <div class="card-panel dark:card-panel-dark">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Completed</p>
                    <p class="mt-2 text-2xl font-bold tracking-tight text-emerald-600 sm:text-3xl">{{ $completedRequests ?? 0 }}</p>
                </div>
                <div class="card-panel dark:card-panel-dark">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Donor mode</p>
                    <p class="mt-2 text-base font-bold tracking-tight text-slate-900 dark:text-white sm:text-lg">{{ $user->isDonor() ? 'Enabled' : 'Not enabled' }}</p>
                </div>
            </div>

            <div class="card-panel dark:card-panel-dark">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-red-600">Quick actions</p>
                        <h2 class="mt-1 text-xl font-bold tracking-tight text-slate-900 dark:text-white">Keep your dashboard moving</h2>
                    </div>
                    <p class="text-sm leading-6 text-slate-500 dark:text-slate-400">Jump to the next step in your support workflow.</p>
                </div>

                <div class="mt-5 grid gap-3 grid-cols-1 sm:grid-cols-2">
                    <a href="{{ route('profile.edit') }}" class="btn-primary min-h-[3.2rem] w-full">Edit Profile</a>
                    <a href="{{ route('requests.create') }}" class="btn-secondary min-h-[3.2rem] w-full">Create Request</a>
                    <a href="{{ route('requests.index') }}" class="btn-secondary min-h-[3.2rem] w-full">View My Requests</a>

                    @if($user->isDonor())
                        <button id="toggle-availability-btn" data-url="{{ route('toggle.availability') }}" class="btn-secondary inline-flex min-h-[3.2rem] w-full items-center justify-center gap-2">
                            <span id="toggle-spinner" class="hidden h-4 w-4 animate-spin rounded-full border-2 border-transparent border-t-slate-700"></span>
                            Toggle Availability
                        </button>
                    @else
                        <a href="{{ route('donor.become') }}" class="btn-secondary inline-flex min-h-[3.2rem] w-full items-center justify-center">
                            Become a Donor
                        </a>
                    @endif
                </div>
            </div>

            <div class="card-panel dark:card-panel-dark">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-red-600">Helpful reminders</p>
                        <h2 class="mt-1 text-xl font-bold tracking-tight text-slate-900 dark:text-white">Stay ready to help</h2>
                    </div>
                    <span class="rounded-full bg-red-50 px-3 py-1 text-sm font-semibold text-red-700 dark:bg-rose-950 dark:text-rose-100">care first</span>
                </div>

                <div class="mt-5 grid gap-4 grid-cols-1 md:grid-cols-3">
                    <div class="rounded-[1.5rem] border border-amber-200 bg-amber-50 p-4 dark:border-amber-900/60 dark:bg-amber-950/60">
                        <h3 class="font-semibold text-slate-900 dark:text-white">Why donate?</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">Donating blood saves lives and strengthens community resilience.</p>
                    </div>
                    <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-900/60">
                        <h3 class="font-semibold text-slate-900 dark:text-white">Tips</h3>
                        <ul class="mt-2 space-y-2 text-sm leading-6 text-slate-600 dark:text-slate-300">
                            <li>Stay hydrated before donation.</li>
                            <li>Eat a healthy meal and avoid fatty foods.</li>
                            <li>Bring ID and rest after donation.</li>
                        </ul>
                    </div>
                    <div class="rounded-[1.5rem] border border-rose-200 bg-rose-50 p-4 dark:border-rose-900/60 dark:bg-rose-950/60">
                        <h3 class="font-semibold text-slate-900 dark:text-white">Eligibility</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">Most healthy adults can donate. Check local guidelines if you’re unsure.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-5">
            <div class="card-panel dark:card-panel-dark">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-red-600">My requests</p>
                        <h2 class="mt-1 text-xl font-bold tracking-tight text-slate-900 dark:text-white">Recent emergency activity</h2>
                    </div>
                    <a href="{{ route('requests.index') }}" class="text-sm font-semibold text-red-600 hover:underline">View all</a>
                </div>

                @if($requests && $requests->count())
                    <div class="mt-5 space-y-3">
                        @foreach($requests as $req)
                            @php
                                $status = $req->status ?? 'Pending';
                            @endphp
                            <div class="rounded-[1.5rem] border border-slate-200 bg-white/85 p-4 shadow-sm dark:border-slate-700 dark:bg-slate-950/60">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                    <div>
                                        <p class="font-semibold leading-snug text-slate-900 dark:text-white">{{ $req->patient_name }}</p>
                                        <p class="mt-1 text-sm leading-6 text-slate-500 dark:text-slate-300">{{ $req->hospital }} • {{ $req->city }}</p>
                                        <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-300">Blood group: <span class="font-semibold text-slate-900 dark:text-white">{{ $req->blood_group }}</span></p>
                                    </div>
                                    <div class="text-left sm:text-right">
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold
                                            {{ $status == 'Pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                            {{ $status == 'Approved' ? 'bg-sky-100 text-sky-800' : '' }}
                                            {{ $status == 'Completed' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                            {{ $status == 'Rejected' ? 'bg-rose-100 text-rose-800' : '' }}">
                                            {{ $status }}
                                        </span>
                                        <p class="mt-2 text-xs text-slate-400">{{ optional($req->created_at)->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5">
                        {{ $requests->links() }}
                    </div>
                @else
                    <div class="mt-4 rounded-[1.5rem] border border-dashed border-slate-300 px-4 py-10 text-center dark:border-slate-700 dark:bg-slate-950/60">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-50 text-red-600 dark:bg-rose-950 dark:text-rose-100">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12A9 9 0 1112 3a9 9 0 019 9z"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900 dark:text-white">No requests yet</h3>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Create your first emergency request to help patients in need.</p>
                        <a href="{{ route('requests.create') }}" class="btn-primary mt-4">Create Emergency Request</a>
                    </div>
                @endif
            </div>

            <div class="card-panel dark:card-panel-dark">
                <div>
                    <p class="text-sm font-semibold text-red-600">Recent activity</p>
                    <h2 class="mt-1 text-xl font-bold tracking-tight text-slate-900 dark:text-white">What happened recently</h2>
                </div>

                @if($recentActivity && $recentActivity->count())
                    <div class="mt-5 space-y-3">
                        @foreach($recentActivity as $act)
                            <div class="flex items-start gap-3 rounded-[1.25rem] border border-slate-200 bg-white/80 px-4 py-3 dark:border-slate-700 dark:bg-slate-950/60">
                                <span class="mt-1 h-2.5 w-2.5 rounded-full bg-red-500"></span>
                                <div>
                                    <p class="text-sm font-semibold leading-6 text-slate-900 dark:text-white">
                                        Request for <span class="text-red-600">{{ $act->patient_name }}</span>
                                    </p>
                                    <p class="mt-1 text-sm leading-6 text-slate-500 dark:text-slate-300">{{ $act->hospital }}, {{ $act->city }}</p>
                                    <p class="mt-1 text-xs text-slate-400">{{ optional($act->created_at)->diffForHumans() }} • Status: {{ $act->status }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="mt-5 text-sm leading-6 text-slate-500 dark:text-slate-300">No recent activity yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('toggle-availability-btn');
        const badge = document.getElementById('availability-badge');
        const spinner = document.getElementById('toggle-spinner');

        if (!btn) {
            return;
        }

        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        btn.addEventListener('click', async function (e) {
            e.preventDefault();
            if (btn.disabled) {
                return;
            }

            btn.disabled = true;
            spinner.classList.remove('hidden');

            try {
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

                if (res.ok && data.success) {
                    const avail = data.available;
                    if (badge) {
                        badge.textContent = avail === 'yes' ? 'Available' : 'Unavailable';
                        badge.className = avail === 'yes'
                            ? 'rounded-full px-4 py-2 text-sm font-bold backdrop-blur-sm bg-emerald-100 text-emerald-900'
                            : 'rounded-full px-4 py-2 text-sm font-bold backdrop-blur-sm bg-rose-100 text-rose-900';
                    }
                    showAlert('Availability updated', 'success');
                } else {
                    showAlert(data.message || 'Update failed', 'error');
                }
            } catch (error) {
                showAlert('Network error', 'error');
            } finally {
                btn.disabled = false;
                spinner.classList.add('hidden');
            }
        });

        function showAlert(msg, type) {
            const existing = document.getElementById('ajax-alert');
            if (existing) {
                existing.remove();
            }

            const div = document.createElement('div');
            div.id = 'ajax-alert';
            div.style.zIndex = 9999;
            div.className = type === 'success'
                ? 'fixed top-6 right-6 rounded-lg border border-emerald-300 bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-800 shadow-lg'
                : 'fixed top-6 right-6 rounded-lg border border-rose-300 bg-rose-100 px-4 py-2 text-sm font-semibold text-rose-800 shadow-lg';
            div.textContent = msg;
            document.body.appendChild(div);
            setTimeout(() => div.remove(), 3000);
        }
    });
</script>
@endpush