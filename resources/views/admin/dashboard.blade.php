@extends('layouts.app')

@section('content')

<!-- Heading -->

<div class="flex flex-col md:flex-row
            justify-between items-center
            gap-4 mb-10">

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

    <div class="bg-white dark:bg-gray-800
                p-8 rounded-3xl shadow-xl
                hover:scale-105
                transition-all duration-300">

        <h2 class="text-2xl font-bold mb-4">

            Total Donors

        </h2>

        <p class="text-5xl font-extrabold text-red-600">

            {{ $totalDonors }}

        </p>

    </div>

    <!-- Available Donors -->

    <div class="bg-white dark:bg-gray-800
                p-8 rounded-3xl shadow-xl
                hover:scale-105
                transition-all duration-300">

        <h2 class="text-2xl font-bold mb-4">

            Available Donors

        </h2>

        <p class="text-5xl font-extrabold text-green-600">

            {{ $availableDonors }}

        </p>

    </div>

    <!-- Blood Requests -->

    <div class="bg-white dark:bg-gray-800
                p-8 rounded-3xl shadow-xl
                hover:scale-105
                transition-all duration-300">

        <h2 class="text-2xl font-bold mb-4">

            Blood Requests

        </h2>

        <p class="text-5xl font-extrabold text-blue-600">

            {{ $bloodRequests }}

        </p>

    </div>

</div>

<!-- Search -->

<div class="bg-white dark:bg-gray-800
            p-6 rounded-3xl shadow-xl mb-10">

    <form method="GET" action="/admin">

        <div class="flex flex-col md:flex-row gap-4">

            <input
                type="text"
                name="search"
                placeholder="Search donors by name, city, blood group..."
                value="{{ request('search') }}"
                class="w-full border p-3 rounded-xl
                       dark:bg-gray-700
                       dark:border-gray-600">

            <button
                class="bg-red-600 text-white
                       px-8 py-3 rounded-xl
                       hover:bg-red-700 transition">

                Search

            </button>

        </div>

    </form>

</div>

<!-- Donors Table -->

<div class="bg-white dark:bg-gray-800
            rounded-3xl shadow-xl
            overflow-hidden mb-10">

    <div class="p-6 border-b dark:border-gray-700">

        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold">All Donors</h2>
            <div class="text-sm text-gray-500">{{ $users->total() }} results</div>
        </div>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-100 dark:bg-gray-700">

                <tr>
                    <th class="p-4 text-left">#</th>
                    <th class="p-4 text-left">Donor</th>
                    <th class="p-4 text-left">Email</th>
                    <th class="p-4 text-left">Blood Group</th>
                    <th class="p-4 text-left">City</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Joined</th>
                    <th class="p-4 text-left">Action</th>
                </tr>

            </thead>

            <tbody>

                @foreach($users as $user)

                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900 transition">

                    <td class="p-4">
                        {{ $loop->iteration + ($users->firstItem() - 1) }}
                    </td>

                    <td class="p-4 flex items-center gap-3">
                        @if($user->profile_image)
                            <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}" class="w-10 h-10 rounded-full object-cover" alt="avatar">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600">{{ strtoupper(substr($user->name,0,1)) }}</div>
                        @endif
                        <div>
                            <div class="font-semibold">{{ $user->name }}</div>
                        </div>
                    </td>

                    <td class="p-4">{{ $user->email }}</td>

                    <td class="p-4">{{ $user->blood_group ?? '-' }}</td>

                    <td class="p-4">{{ $user->city ?? '-' }}</td>

                    <td class="p-4">
                        @if($user->available == 'yes')
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full">Available</span>
                        @else
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full">Unavailable</span>
                        @endif
                    </td>

                    <td class="p-4">{{ optional($user->created_at)->format('Y-m-d') ?? '-' }}</td>

                    <td class="p-4">
                        <a href="/admin/delete-user/{{ $user->_id }}" onclick="return confirm('Are you sure you want to delete this donor?')" class="bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-700 transition">Delete</a>
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

<!-- Pagination -->

<div class="mt-10 mb-10">

    {{ $users->links() }}

</div>

<!-- Emergency Blood Requests -->

<div class="bg-white dark:bg-gray-800
            rounded-3xl shadow-xl
            overflow-hidden mb-10">

    <div class="p-6 border-b dark:border-gray-700">

        <h2 class="text-3xl font-bold">

            Emergency Blood Requests

        </h2>

    </div>

    <div class="p-6 border-b dark:border-gray-700 flex items-center justify-between gap-4">
        <div>
            <form method="GET" action="/admin">
                <div class="flex items-center gap-3">
                    <label class="text-sm">Filter:</label>
                    <select name="status" class="border p-2 rounded-lg">
                        <option value="">All</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    <button class="bg-red-600 text-white px-3 py-2 rounded-lg">Apply</button>
                </div>
            </form>
        </div>

        <div class="text-sm text-gray-500">Total Requests: {{ $totalRequests ?? 0 }}</div>
    </div>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-100 dark:bg-gray-700">

                <tr>

                    <th class="p-4 text-left">Patient</th>
                    <th class="p-4 text-left">Phone</th>
                    <th class="p-4 text-left">Blood Group</th>
                    <th class="p-4 text-left">Hospital</th>
                    <th class="p-4 text-left">City</th>
                    <th class="p-4 text-left">Message</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse($requests as $request)

                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900 transition">

                    <td class="p-4">{{ $request->patient_name }}</td>
                    <td class="p-4">{{ $request->phone }}</td>
                    <td class="p-4">{{ $request->blood_group }}</td>
                    <td class="p-4">{{ $request->hospital }}</td>
                    <td class="p-4">{{ $request->city }}</td>
                    <td class="p-4">{{ $request->message ?? '-' }}</td>
                    <td class="p-4">
                        @php
                            $status = $request->status ?? 'Pending';
                        @endphp
                        @if($status == 'Pending')
                            <span class="bg-yellow-400 text-black px-3 py-1 rounded-full">Pending</span>
                        @elseif($status == 'Approved')
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full">Approved</span>
                        @elseif($status == 'Completed')
                            <span class="bg-blue-500 text-white px-3 py-1 rounded-full">Completed</span>
                        @else
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full">Rejected</span>
                        @endif
                    </td>
                    <td class="p-4">
                        <form method="POST" action="{{ route('admin.request-status', $request->_id) }}" class="flex items-center gap-2">
                            @csrf
                            <select name="status" class="border p-2 rounded-lg">
                                <option value="Pending" {{ ($request->status ?? 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Approved" {{ ($request->status ?? '') == 'Approved' ? 'selected' : '' }}>Approved</option>
                                <option value="Completed" {{ ($request->status ?? '') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Rejected" {{ ($request->status ?? '') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            <button class="bg-blue-600 text-white px-3 py-2 rounded-lg">Save</button>
                        </form>
                    </td>

                </tr>

                @empty
                    <tr>
                        <td class="p-6 text-center" colspan="8">No emergency requests found.</td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-6 p-6">
        {{ $requests->withQueryString()->links() }}
    </div>

</div>

<!-- Charts -->

<div class="grid md:grid-cols-2 gap-8 mb-10">

    <!-- Blood Group Analytics -->

    <div class="bg-white dark:bg-gray-800
                rounded-3xl shadow-xl p-6">

        <h2 class="text-2xl font-bold mb-6">

            Blood Group Analytics

        </h2>

        <div class="h-72">

            <canvas id="bloodChart"></canvas>

        </div>

    </div>

    <!-- City-wise Donor Distribution -->

    <div class="bg-white dark:bg-gray-800
                rounded-3xl shadow-xl p-6">

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

    const ctx =
        document.getElementById('bloodChart');

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: [
                'A+',
                'A-',
                'B+',
                'B-',
                'O+',
                'O-',
                'AB+',
                'AB-'
            ],

            datasets: [{

                label: 'Donors',

                data: @json($bloodGroupData),

                borderWidth: 1

            }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            scales: {

                y: {
                    beginAtZero: true
                }

            }

        }

    });

    /*
    |--------------------------------------------------------------------------
    | City Chart
    |--------------------------------------------------------------------------
    */

    const cityCtx =
        document.getElementById('cityChart');

    new Chart(cityCtx, {

        type: 'pie',

        data: {

            labels: @json($cityLabels),

            datasets: [{

                data: @json($cityData),

                borderWidth: 1

            }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false

        }

    });

</script>

@endsection