@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-4xl font-bold text-slate-900 dark:text-slate-100">Request Details</h1>
            <p class="mt-2 text-slate-600 dark:text-slate-300">Review the selected emergency request and update its status.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.requests.index') }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-900 transition duration-200 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-100 dark:hover:bg-slate-700">Back to Requests</a>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-5 text-emerald-900 dark:border-emerald-700 dark:bg-emerald-950 dark:text-emerald-100 mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <div class="space-y-6">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Patient Name</h2>
                    <p class="mt-2 text-slate-600 dark:text-slate-300">{{ $request->patient_name }}</p>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Donor Email</h2>
                    <p class="mt-2 text-slate-600 dark:text-slate-300">{{ optional($request->user)->email ?? 'Unknown' }}</p>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Blood Group</h2>
                        <p class="mt-2 text-slate-600 dark:text-slate-300">{{ $request->blood_group }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Hospital</h2>
                        <p class="mt-2 text-slate-600 dark:text-slate-300">{{ $request->hospital }}</p>
                    </div>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">City</h2>
                        <p class="mt-2 text-slate-600 dark:text-slate-300">{{ $request->city }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Phone</h2>
                        <p class="mt-2 text-slate-600 dark:text-slate-300">{{ $request->phone }}</p>
                    </div>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Request Message</h2>
                    <p class="mt-2 whitespace-pre-line rounded-3xl border border-slate-200 bg-slate-50 p-4 text-slate-700 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200">{{ $request->message ?? 'No message provided.' }}</p>
                </div>
                @if($request->admin_message)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-700 dark:bg-slate-950">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Admin Response</h2>
                        <p class="mt-3 text-slate-700 dark:text-slate-200 whitespace-pre-line">{{ $request->admin_message }}</p>
                        <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">Updated {{ optional($request->status_updated_at)->format('Y-m-d H:i') }}</p>
                    </div>
                @endif
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Created Date</h2>
                        <p class="mt-2 text-slate-600 dark:text-slate-300">{{ optional($request->created_at)->format('Y-m-d H:i') }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Current Status</h2>
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
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Update Request Status</h2>
            <div class="mt-6 flex flex-col gap-4">
                <button type="button" data-status="Approved" data-title="Approve Request" data-required-message="false" class="js-open-status-modal inline-flex w-full items-center justify-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition duration-200 hover:bg-blue-700">Approve</button>
                <button type="button" data-status="Rejected" data-title="Reject Request" data-required-message="true" class="js-open-status-modal inline-flex w-full items-center justify-center rounded-2xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition duration-200 hover:bg-red-700">Reject</button>
            </div>
        </div>

        <div id="status-modal-detail" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm">
            <div class="w-full max-w-2xl rounded-3xl bg-white shadow-2xl dark:bg-slate-900">
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5 dark:border-slate-700">
                    <div>
                        <h2 id="modal-title-detail" class="text-xl font-semibold text-slate-900 dark:text-slate-100">Update Request Status</h2>
                        <p id="modal-subtitle-detail" class="mt-1 text-sm text-slate-500 dark:text-slate-400">Add an optional message before saving the change.</p>
                    </div>
                    <button type="button" class="js-close-status-modal-detail text-slate-500 transition hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-100">✕</button>
                </div>
                <form id="status-form-detail" method="POST" class="px-6 py-6">
                    @csrf
                    <input type="hidden" id="modal-status-detail" name="status" value="">

                    <div class="grid gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
                            <input type="text" id="modal-status-label-detail" readonly class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-100 px-4 py-3 text-sm text-slate-900 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Admin Response</label>
                            <textarea id="modal-admin-message-detail" name="admin_message" rows="4" class="mt-2 w-full rounded-3xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition duration-200 focus:border-red-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" placeholder="Write an optional approval message or enter a rejection reason."></textarea>
                            <p id="modal-requirement-detail" class="mt-2 text-sm text-slate-500 dark:text-slate-400">Approval message is optional. Rejection reason is required.</p>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-wrap items-center gap-3 justify-end">
                        <button type="button" class="js-close-status-modal-detail inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition duration-200 hover:border-slate-400 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:hover:bg-slate-800">Cancel</button>
                        <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition duration-200 hover:bg-red-700">Save Change</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('status-modal-detail');
                const form = document.getElementById('status-form-detail');
                const statusInput = document.getElementById('modal-status-detail');
                const statusLabel = document.getElementById('modal-status-label-detail');
                const adminMessage = document.getElementById('modal-admin-message-detail');
                const requirement = document.getElementById('modal-requirement-detail');
                const openButtons = document.querySelectorAll('.js-open-status-modal');
                const closeButtons = document.querySelectorAll('.js-close-status-modal-detail');

                openButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const status = button.dataset.status;
                        const title = button.dataset.title;
                        const requireMessage = button.dataset.requiredMessage === 'true';

                        statusInput.value = status;
                        statusLabel.value = status;
                        adminMessage.value = '';
                        adminMessage.required = requireMessage;
                        requirement.textContent = requireMessage ? 'Rejection reason is required.' : 'Approval message is optional. Rejection reason is required.';
                        document.getElementById('modal-title-detail').textContent = title;
                        document.getElementById('modal-subtitle-detail').textContent = requireMessage ? 'Write a reason for rejecting this request.' : 'Write an optional approval message.';
                        form.action = '/admin/requests/{{ $request->_id }}/status';
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
    </div>
</div>
@endsection
