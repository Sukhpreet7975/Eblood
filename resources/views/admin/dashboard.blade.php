@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-red-600">Admin analytics</p>
            <h1 class="mt-3 text-3xl font-bold text-slate-900 dark:text-white sm:text-4xl">Community blood support dashboard</h1>
            <p class="mt-3 max-w-2xl text-sm text-slate-600 dark:text-slate-300">
                Monitor donor availability, requester activity, and current emergency demand from one place.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.export-excel') }}" class="rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700">Export Excel</a>
            <a href="{{ route('admin.export-pdf') }}" class="rounded-2xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700">Export PDF</a>
            <a href="{{ route('admin.requests.index') }}" class="rounded-2xl border border-red-200 px-5 py-3 text-sm font-semibold text-red-700 transition hover:border-red-300 hover:bg-red-50 dark:border-red-900/60 dark:text-red-200 dark:hover:bg-red-950/40">Manage requests</a>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-300">Total donors</p>
            <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">{{ $totalDonors }}</p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Registered donor profiles</p>
        </div>

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-300">Available donors</p>
            <p class="mt-3 text-3xl font-bold text-emerald-600">{{ $availableDonors }}</p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Ready for emergency matching</p>
        </div>

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-300">Requesters</p>
            <p class="mt-3 text-3xl font-bold text-sky-600">{{ $totalRequesters }}</p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Active requester accounts</p>
        </div>

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-300">Requests this period</p>
            <p class="mt-3 text-3xl font-bold text-amber-500">{{ $bloodRequests }}</p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Average {{ $requestsPerRequester }} per requester</p>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-300">Pending</p>
            <p class="mt-3 text-2xl font-bold text-amber-500">{{ $pendingRequests }}</p>
        </div>
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-300">Approved</p>
            <p class="mt-3 text-2xl font-bold text-sky-600">{{ $approvedRequests }}</p>
        </div>
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-300">Completed</p>
            <p class="mt-3 text-2xl font-bold text-emerald-600">{{ $completedRequests }}</p>
        </div>
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-300">Rejected</p>
            <p class="mt-3 text-2xl font-bold text-rose-600">{{ $rejectedRequests }}</p>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-2">
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">Donor inventory</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">Blood group distribution for current donor records.</p>
            </div>
            <div class="mt-5 h-72">
                <canvas id="bloodChart"></canvas>
            </div>
        </div>

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">Donor coverage</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">Availability versus unavailable donors.</p>
            </div>
            <div class="mt-5 h-72">
                <canvas id="availabilityChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-2">
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">Donor city spread</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">Top donor concentrations by city.</p>
            </div>
            <div class="mt-5 h-72">
                <canvas id="donorCityChart"></canvas>
            </div>
        </div>

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">Requester demand</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">Requester activity and request hotspots by city.</p>
            </div>
            <div class="mt-5 h-72">
                <canvas id="requesterCityChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-2">
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Latest donors</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">New donor profiles added to the network.</p>
                </div>
                <a href="{{ route('admin.donors.index') }}" class="text-sm font-semibold text-red-600">View donors</a>
            </div>
            <div class="mt-5 space-y-3">
                @forelse($recentDonors as $donor)
                    <div class="rounded-2xl border border-slate-200 px-4 py-3 dark:border-slate-700">
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $donor->name }}</p>
                        <div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-slate-500 dark:text-slate-300">
                            <span>{{ $donor->email }}</span>
                            <span aria-hidden="true">•</span>
                            <span class="inline-flex rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700 dark:bg-rose-950/60 dark:text-rose-200">{{ $donor->blood_group ?? 'Unknown' }}</span>
                            <span aria-hidden="true">•</span>
                            <span>{{ $donor->city ?? 'Unknown city' }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 dark:text-slate-300">No donor records available yet.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Recent requests</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">Most recent emergency requests submitted by requesters.</p>
                </div>
                <a href="{{ route('admin.requests.index') }}" class="text-sm font-semibold text-red-600">Open requests</a>
            </div>
            <div class="mt-5 space-y-3">
                @forelse($latestRequests as $request)
                    <div class="rounded-2xl border border-slate-200 px-4 py-3 dark:border-slate-700">
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $request->patient_name ?? 'Anonymous patient' }}</p>
                        <div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-slate-500 dark:text-slate-300">
                            <span class="inline-flex rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700 dark:bg-rose-950/60 dark:text-rose-200">{{ $request->blood_group ?? 'Unknown' }}</span>
                            <span aria-hidden="true">•</span>
                            <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-100">{{ $request->status ?? 'Pending' }}</span>
                            <span aria-hidden="true">•</span>
                            <span>{{ $request->city ?? 'Unknown city' }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 dark:text-slate-300">No requests have been submitted yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const baseColors = ['#ef4444', '#f97316', '#f59e0b', '#84cc16', '#10b981', '#06b6d4', '#3b82f6', '#8b5cf6'];
    let bloodChart = null;
    let availabilityChart = null;
    let donorCityChart = null;
    let requesterCityChart = null;

    const renderCharts = () => {
        if (bloodChart) bloodChart.destroy();
        if (availabilityChart) availabilityChart.destroy();
        if (donorCityChart) donorCityChart.destroy();
        if (requesterCityChart) requesterCityChart.destroy();

        const bloodCtx = document.getElementById('bloodChart');
        const availabilityCtx = document.getElementById('availabilityChart');
        const donorCityCtx = document.getElementById('donorCityChart');
        const requesterCityCtx = document.getElementById('requesterCityChart');

        if (bloodCtx) {
            bloodChart = new Chart(bloodCtx, {
                type: 'bar',
                data: {
                    labels: @json($donorBloodGroups ?? []),
                    datasets: [{
                        label: 'Donors',
                        data: @json($bloodGroupData ?? []),
                        backgroundColor: '#ef4444',
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }

        if (availabilityCtx) {
            availabilityChart = new Chart(availabilityCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Available', 'Unavailable'],
                    datasets: [{
                        data: @json($donorAvailabilityData ?? []),
                        backgroundColor: ['#10b981', '#cbd5e1']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }

        if (donorCityCtx) {
            donorCityChart = new Chart(donorCityCtx, {
                type: 'pie',
                data: {
                    labels: @json($donorCityLabels ?? []),
                    datasets: [{
                        data: @json($donorCityData ?? []),
                        backgroundColor: baseColors
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }

        if (requesterCityCtx) {
            requesterCityChart = new Chart(requesterCityCtx, {
                type: 'pie',
                data: {
                    labels: @json($requesterCityLabels ?? []),
                    datasets: [{
                        data: @json($requesterCityData ?? []),
                        backgroundColor: baseColors
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }
    };

    renderCharts();
    window.addEventListener('themeChanged', renderCharts);
</script>
@endpush
