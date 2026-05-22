@extends('layouts.app')

@section('content')

<!-- Heading -->

<div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-10">

    <h1 class="text-5xl font-bold text-red-600">

        Admin Dashboard

    </h1>

    <div class="flex gap-4">

        <a href="/admin/export-excel"
           class="bg-green-600 text-white
                  px-6 py-3 rounded-xl
                  hover:bg-green-700 transition">

            Export Excel

        </a>

        <a href="/admin/export-pdf"
           class="bg-red-600 text-white
                  px-6 py-3 rounded-xl
                  hover:bg-red-700 transition">

            Export PDF

        </a>

    </div>

</div>

<!-- Stats -->

<div class="grid md:grid-cols-3 gap-6 mb-10">

    <!-- Total Donors -->

    <div class="card-panel dark:card-panel-dark transition hover:-translate-y-0.5 duration-300">

        <h2 class="text-2xl font-bold mb-4">
            Total Donors
        </h2>

        <p class="text-5xl font-extrabold text-red-600">
            {{ $totalDonors }}
        </p>

    </div>

    <!-- Available Donors -->

    <div class="card-panel dark:card-panel-dark transition hover:-translate-y-0.5 duration-300">

        <h2 class="text-2xl font-bold mb-4">

            Available Donors

        </h2>

        <p class="text-5xl font-extrabold text-green-600">

            {{ $availableDonors }}

        </p>

    </div>

    <!-- Blood Requests -->

    <div class="card-panel dark:card-panel-dark transition hover:-translate-y-0.5 duration-300">

        <h2 class="text-2xl font-bold mb-4">

            Blood Requests

        </h2>

        <p class="text-5xl font-extrabold text-blue-600">

            {{ $bloodRequests }}

        </p>

    </div>

</div>

<!-- Request Analytics -->

<div class="grid md:grid-cols-4 gap-6 mb-10">

    <div class="card-panel dark:card-panel-dark">
        <h3 class="text-sm text-slate-500 dark:text-slate-400">Pending</h3>
        <p class="text-3xl font-bold text-yellow-500">{{ $pendingRequests ?? 0 }}</p>
    </div>

    <div class="card-panel dark:card-panel-dark">
        <h3 class="text-sm text-slate-500 dark:text-slate-400">Approved</h3>
        <p class="text-3xl font-bold text-blue-500">{{ $approvedRequests ?? 0 }}</p>
    </div>

    <div class="card-panel dark:card-panel-dark">
        <h3 class="text-sm text-slate-500 dark:text-slate-400">Completed</h3>
        <p class="text-3xl font-bold text-green-500">{{ $completedRequests ?? 0 }}</p>
    </div>

    <div class="card-panel dark:card-panel-dark">
        <h3 class="text-sm text-slate-500 dark:text-slate-400">Rejected</h3>
        <p class="text-3xl font-bold text-red-500">{{ $rejectedRequests ?? 0 }}</p>
    </div>

</div>

<!-- Request Management CTA -->

<div class="grid gap-6 xl:grid-cols-3 mb-10">
    <div class="card-panel dark:card-panel-dark hover:shadow-red-200/20 transition duration-300">
        <h2 class="text-2xl font-bold mb-2">Manage Requests</h2>
        <p class="text-slate-500 dark:text-slate-300 mb-6">All emergency blood requests are now managed on a dedicated request page.</p>
        <a href="/admin/requests" class="btn-primary inline-flex items-center gap-2">
            Go to Requests
            <span>→</span>
        </a>
    </div>

    <div class="card-panel dark:card-panel-dark hover:shadow-slate-200/20 transition duration-300">
        <h2 class="text-2xl font-bold mb-2">Total Donors</h2>
        <p class="text-4xl font-extrabold text-red-600">{{ $totalDonors }}</p>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-3">Donor base size for the platform.</p>
    </div>

    <div class="card-panel dark:card-panel-dark hover:shadow-slate-200/20 transition duration-300">
        <h2 class="text-2xl font-bold mb-2">Available Donors</h2>
        <p class="text-4xl font-extrabold text-green-600">{{ $availableDonors }}</p>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-3">Donors marked ready for emergency matches.</p>
    </div>
</div>

<!-- Recent Donors -->

<div class="card-panel dark:card-panel-dark mb-10">
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold">Latest Donor Registrations</h2>
            <p class="text-slate-500 dark:text-slate-400">Recent donors joining the network.</p>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @foreach($recentDonors as $donor)
            <div class="card-panel dark:card-panel-dark">
                <p class="font-semibold text-slate-900 dark:text-slate-100">{{ $donor->name }}</p>
                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $donor->email }}</p>
                <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">{{ $donor->blood_group ?? 'Unknown' }} • {{ $donor->city ?? 'No city' }}</p>
            </div>
        @endforeach
    </div>
</div>

</div>

<!-- Charts -->

<div class="grid md:grid-cols-2 gap-8 mb-10">

    <!-- Blood Group Analytics -->

    <div class="card-panel dark:card-panel-dark">

        <h2 class="text-2xl font-bold mb-6">

            Blood Group Analytics

        </h2>

        <div class="h-72">

            <canvas id="bloodChart"></canvas>

        </div>

    </div>

    <!-- City-wise Donor Distribution -->

    <div class="card-panel dark:card-panel-dark">

        <h2 class="text-2xl font-bold mb-6">

            City-wise Donor Distribution

        </h2>

        <div class="h-72">

            <canvas id="cityChart"></canvas>

        </div>

    </div>

</div>

<!-- Charts Script -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    /*
    |--------------------------------------------------------------------------
    | Blood Group Chart
    |--------------------------------------------------------------------------
    */

    const createBloodChart = () => {
        const ctx = document.getElementById('bloodChart');
        if (!ctx) return null;

        const color = getComputedStyle(document.documentElement).getPropertyValue('--color-accent') || '#ef4444';

        return new Chart(ctx, {
            type: 'bar',
                data: {
                labels: ['A+','A-','B+','B-','O+','O-','AB+','AB-'],
                datasets: [{
                    label: 'Donors',
                    data: @json($bloodGroupData ?? []),
                    backgroundColor: color.trim() || '#ef4444',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });
    };
    /*
    |--------------------------------------------------------------------------
    | City Chart
    |--------------------------------------------------------------------------
    */

    const createCityChart = () => {
        const cityCtx = document.getElementById('cityChart');
        if (!cityCtx) return null;

        return new Chart(cityCtx, {
            type: 'pie',
                data: {
                labels: @json($cityLabels ?? []),
                datasets: [{
                    data: @json($cityData ?? []),
                    backgroundColor: [
                        '#ef4444','#f97316','#f59e0b','#84cc16','#10b981','#06b6d4','#3b82f6','#8b5cf6'
                    ]
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    };

    // Create charts and re-render on theme change
    let bloodChart = createBloodChart();
    let cityChart = createCityChart();

    window.addEventListener('themeChanged', () => {
        if (bloodChart) bloodChart.destroy();
        if (cityChart) cityChart.destroy();
        bloodChart = createBloodChart();
        cityChart = createCityChart();
    });

</script>

@endsection