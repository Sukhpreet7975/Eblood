@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-4xl font-bold text-slate-900 dark:text-slate-100">Emergency Requests</h1>
            <p class="mt-2 text-slate-600 dark:text-slate-300">Manage all incoming blood requests, filter by status, and search by patient or donor email.</p>
        </div>
        <a href="/admin/home" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-red-600 px-5 py-3 text-sm font-semibold text-white hover:bg-red-700 transition duration-200">Back to Admin Home</a>
    </div>

    <div class="grid gap-4 lg:grid-cols-4 mb-6">
        <div class="lg:col-span-3 rounded-3xl bg-white dark:bg-slate-900 p-6 shadow-sm border border-slate-200 dark:border-slate-700">
            <form method="GET" action="{{ route('admin.requests.index') }}" class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Patient Name</label>
                    <input type="text" name="patient_name" value="{{ request('patient_name') }}" placeholder="Search patient" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition duration-200 focus:border-red-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Donor Email</label>
                    <input type="text" name="donor_email" value="{{ request('donor_email') }}" placeholder="Search donor email" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition duration-200 focus:border-red-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Blood Group</label>
                    <select name="blood_group" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition duration-200 focus:border-red-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                        <option value="">All Groups</option>
                        @foreach($bloodGroups as $group)
                            <option value="{{ $group }}" {{ request('blood_group') === $group ? 'selected' : '' }}>{{ $group }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
                    <select name="status" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition duration-200 focus:border-red-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                        <option value="">All Statuses</option>
                        @foreach($statusOptions as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-3 xl:col-span-4">
                    <button type="submit" class="inline-flex h-12 items-center justify-center rounded-2xl bg-red-600 px-6 text-sm font-semibold text-white transition duration-200 hover:bg-red-700">Apply Filters</button>
                    <a href="{{ route('admin.requests.index') }}" class="inline-flex h-12 items-center justify-center rounded-2xl bg-slate-100 px-6 text-sm font-semibold text-slate-700 transition duration-200 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">Reset</a>
                </div>
            </form>
        </div>
    </div>

    @if($requests->isEmpty())
        <div class="rounded-3xl border border-dashed border-slate-300 bg-white py-12 text-center shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <p class="text-xl font-semibold text-slate-900 dark:text-slate-100">No requests found.</p>
            <p class="mt-2 text-slate-500 dark:text-slate-400">Try adjusting your filters or check back later when more emergency requests arrive.</p>
        </div>
    @else
        <div class="overflow-x-auto rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <table class="min-w-[900px] w-full text-left">
                <thead class="bg-slate-100 text-sm uppercase tracking-[0.12em] text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                    <tr>
                        <th class="px-5 py-4">Patient</th>
                        <th class="px-5 py-4">Donor Email</th>
                        <th class="px-5 py-4">Blood Group</th>
                        <th class="px-5 py-4">Hospital</th>
                        <th class="px-5 py-4">City</th>
                        <th class="px-5 py-4">Phone</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4">Created</th>
                        <th class="px-5 py-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition duration-200 dark:border-slate-700 dark:hover:bg-slate-800">
                            <td class="px-5 py-4">
                                <div class="font-semibold text-slate-900 dark:text-slate-100">{{ $request->patient_name }}</div>
                            </td>
                            <td class="px-5 py-4 text-slate-600 dark:text-slate-300">{{ optional($request->user)->email ?? 'Unknown' }}</td>
                            <td class="px-5 py-4 text-slate-600 dark:text-slate-300">{{ $request->blood_group }}</td>
                            <td class="px-5 py-4 text-slate-600 dark:text-slate-300">{{ $request->hospital }}</td>
                            <td class="px-5 py-4 text-slate-600 dark:text-slate-300">{{ $request->city }}</td>
                            <td class="px-5 py-4 text-slate-600 dark:text-slate-300">{{ $request->phone }}</td>
                            <td class="px-5 py-4">
                                @php
                                    $statusClass = match($request->status) {
                                        'Pending' => 'bg-amber-100 text-amber-700',
                                        'Approved' => 'bg-blue-100 text-blue-700',
                                        'Completed' => 'bg-emerald-100 text-emerald-700',
                                        'Rejected' => 'bg-red-100 text-red-700',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] {{ $statusClass }}">{{ $request->status }}</span>
                            </td>
                            <td class="px-5 py-4 text-slate-600 dark:text-slate-300">{{ optional($request->created_at)->format('Y-m-d') }}</td>
                            <td class="px-5 py-4 space-y-2">
                                <a href="{{ route('admin.requests.show', $request->_id) }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition duration-200 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">View</a>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" data-request-id="{{ $request->_id }}" data-status="Approved" data-title="Approve Request" data-required-message="false" class="js-open-status-modal inline-flex items-center justify-center rounded-2xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition duration-200 hover:bg-blue-700">Approve</button>
                                    <button type="button" data-request-id="{{ $request->_id }}" data-status="Rejected" data-title="Reject Request" data-required-message="true" class="js-open-status-modal inline-flex items-center justify-center rounded-2xl bg-red-600 px-4 py-2 text-sm font-semibold text-white transition duration-200 hover:bg-red-700">Reject</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $requests->links() }}
        </div>

        <div id="status-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm">
            <div class="w-full max-w-2xl rounded-3xl bg-white shadow-2xl dark:bg-slate-900">
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5 dark:border-slate-700">
                    <div>
                        <h2 id="modal-title" class="text-xl font-semibold text-slate-900 dark:text-slate-100">Update Request Status</h2>
                        <p id="modal-subtitle" class="mt-1 text-sm text-slate-500 dark:text-slate-400">Add an optional message before saving the change.</p>
                    </div>
                    <button type="button" class="js-close-status-modal text-slate-500 transition hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-100">✕</button>
                </div>
                <form id="status-form" method="POST" class="px-6 py-6">
                    @csrf
                    <input type="hidden" id="modal-request-id" name="request_id" value="">
                    <input type="hidden" id="modal-status" name="status" value="">

                    <div class="grid gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
                            <input type="text" id="modal-status-label" readonly class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-100 px-4 py-3 text-sm text-slate-900 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Admin Response</label>
                            <textarea id="modal-admin-message" name="admin_message" rows="4" class="mt-2 w-full rounded-3xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition duration-200 focus:border-red-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" placeholder="Write an optional approval message or enter a rejection reason."></textarea>
                            <p id="modal-requirement" class="mt-2 text-sm text-slate-500 dark:text-slate-400">Approval message is optional. Rejection reason is required.</p>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-wrap items-center gap-3 justify-end">
                        <button type="button" class="js-close-status-modal inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition duration-200 hover:border-slate-400 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:hover:bg-slate-800">Cancel</button>
                        <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition duration-200 hover:bg-red-700">Save Change</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('status-modal');
                const form = document.getElementById('status-form');
                const requestId = document.getElementById('modal-request-id');
                const statusInput = document.getElementById('modal-status');
                const statusLabel = document.getElementById('modal-status-label');
                const adminMessage = document.getElementById('modal-admin-message');
                const requirement = document.getElementById('modal-requirement');
                const openButtons = document.querySelectorAll('.js-open-status-modal');
                const closeButtons = document.querySelectorAll('.js-close-status-modal');

                openButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const id = button.dataset.requestId;
                        const status = button.dataset.status;
                        const title = button.dataset.title;
                        const requireMessage = button.dataset.requiredMessage === 'true';

                        requestId.value = id;
                        statusInput.value = status;
                        statusLabel.value = status;
                        adminMessage.value = '';
                        requirement.textContent = requireMessage ? 'Rejection reason is required.' : 'Approval message is optional. Rejection reason is required.';
                        adminMessage.required = requireMessage;
                        document.getElementById('modal-title').textContent = title;
                        document.getElementById('modal-subtitle').textContent = requireMessage ? 'Write a reason for rejecting this request.' : 'Write an optional approval message.';
                        form.action = '/admin/requests/' + id + '/status';
                        modal.classList.remove('hidden');
                    });
                });

                closeButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        modal.classList.add('hidden');
                    });
                });

                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        modal.classList.add('hidden');
                    }
                });
            });
        </script>
    @endif
</div>
@endsection
