@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-red-600">Admin insights</p>
            <h1 class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">Donor & user analytics</h1>
            <p class="mt-2 max-w-2xl text-sm text-slate-600 dark:text-slate-300">Explore donor capacity, user coverage, and emergency request demand in one place.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-red-300 hover:text-red-600 dark:border-slate-700 dark:text-slate-100">Back to dashboard</a>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-300">Total users</p>
            <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">{{ $totalUsers ?? 0 }}</p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">All non-admin accounts.</p>
        </div>
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-300">Donor-enabled</p>
            <p class="mt-3 text-3xl font-bold text-red-600">{{ $totalDonors ?? 0 }}</p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Users able to receive requests.</p>
        </div>
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-300">Available donors</p>
            <p class="mt-3 text-3xl font-bold text-emerald-600">{{ $availableDonors ?? 0 }}</p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Ready for emergency matching.</p>
        </div>
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-300">Emergency requests</p>
            <p class="mt-3 text-3xl font-bold text-amber-500">{{ $bloodRequests ?? 0 }}</p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Total requests in the system.</p>
        </div>
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-300">Pending review</p>
            <p class="mt-3 text-3xl font-bold text-rose-600">{{ $pendingRequests ?? 0 }}</p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Requests awaiting admin action.</p>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-2">
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">Blood group distribution</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">How donors are distributed by blood type.</p>
            </div>
            <div class="mt-5 h-72">
                <canvas id="bloodGroupChart"></canvas>
            </div>
        </div>

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">Donor availability</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">Available vs unavailable donor-enabled users.</p>
            </div>
            <div class="mt-5 h-72">
                <canvas id="donorAvailabilityChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-2">
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">Donor city spread</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">Top cities with donor-enabled users.</p>
            </div>
            <div class="mt-5 h-72">
                <canvas id="donorCityChart"></canvas>
            </div>
        </div>
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">Request hotspots</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">Cities with the highest emergency demand.</p>
            </div>
            <div class="mt-5 h-72">
                <canvas id="requestHotspotsChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const analyticsColors = ['#ef4444', '#f97316', '#f59e0b', '#84cc16', '#10b981', '#06b6d4', '#3b82f6', '#8b5cf6'];
    let bloodGroupChart = null;
    let donorAvailabilityChart = null;
    let donorCityChart = null;
    let requestHotspotsChart = null;

    const renderAnalyticsCharts = () => {
        if (bloodGroupChart) bloodGroupChart.destroy();
        if (donorAvailabilityChart) donorAvailabilityChart.destroy();
        if (donorCityChart) donorCityChart.destroy();
        if (requestHotspotsChart) requestHotspotsChart.destroy();

        const bloodCtx = document.getElementById('bloodGroupChart');
        const availabilityCtx = document.getElementById('donorAvailabilityChart');
        const donorCityCtx = document.getElementById('donorCityChart');
        const requestHotspotsCtx = document.getElementById('requestHotspotsChart');

        if (bloodCtx) {
            bloodGroupChart = new Chart(bloodCtx, {
                type: 'bar',
                data: {
                    labels: @json($donorBloodGroups ?? []),
                    datasets: [{
                        label: 'Donor count',
                        data: @json($bloodGroupData ?? []),
                        backgroundColor: '#ef4444',
                        borderRadius: 10,
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
            donorAvailabilityChart = new Chart(availabilityCtx, {
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
                        backgroundColor: analyticsColors
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }

        if (requestHotspotsCtx) {
            requestHotspotsChart = new Chart(requestHotspotsCtx, {
                type: 'pie',
                data: {
                    labels: @json($requestsByCityLabels ?? []),
                    datasets: [{
                        data: @json($requestsByCityData ?? []),
                        backgroundColor: analyticsColors
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

    renderAnalyticsCharts();
    window.addEventListener('themeChanged', renderAnalyticsCharts);
</script>
@endpush
