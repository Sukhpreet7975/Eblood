@extends('layouts.requester')

@section('content')

<div class="space-y-8">
    <section class="hero-panel">
        <div class="max-w-3xl">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-rose-100">Request dashboard</p>
            <h1 class="mt-4 text-4xl font-bold tracking-tight">Track every emergency request with clarity.</h1>
            <p class="mt-4 max-w-2xl text-sm leading-7 text-rose-50/90 sm:text-base">
                Keep an eye on approvals, pending review, and completed follow-up all in one polished place.
            </p>
        </div>
    </section>

    @if(session('success'))
        <div class="rounded-[1.5rem] border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-100">{{ session('success') }}</div>
    @endif

    <div class="card-panel dark:card-panel-dark">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl">
                <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">Find the right request quickly</p>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Search by patient, hospital, city, or blood group, and narrow the list by status.</p>
            </div>
            <div class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-200">
                {{ $requests->total() }} total
            </div>
        </div>

        <form method="GET" action="{{ route('requests.index') }}" class="mt-5 grid gap-4 lg:grid-cols-[1.4fr_1fr_1fr_auto]">
            <div>
                <label for="search" class="block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Search</label>
                <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Patient, hospital, city, or blood group" class="form-field dark:form-field-dark mt-2" />
            </div>

            <div>
                <label for="status" class="block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Status</label>
                <select id="status" name="status" class="form-field dark:form-field-dark mt-2">
                    <option value="">All statuses</option>
                    @foreach(['Pending', 'Approved', 'Completed', 'Rejected'] as $statusOption)
                        <option value="{{ $statusOption }}" {{ request('status') === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="blood_group" class="block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Blood group</label>
                <select id="blood_group" name="blood_group" class="form-field dark:form-field-dark mt-2">
                    <option value="">All groups</option>
                    @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $group)
                        <option value="{{ $group }}" {{ request('blood_group') === $group ? 'selected' : '' }}>{{ $group }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-3">
                <button type="submit" class="btn-primary">Apply filters</button>
                <a href="{{ route('requests.index') }}" class="btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    @if($requests->isEmpty())
        <div class="card-panel dark:card-panel-dark border border-dashed border-slate-300 dark:border-slate-700">
            <p class="text-xl font-semibold text-slate-900 dark:text-slate-100">No requests found</p>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Try a different search term or clear the filters to see your emergency requests again.</p>
        </div>
    @else
        <div class="grid gap-4">
            @foreach($requests as $request)
                @php
                    $status = $request->status ?? 'Pending';
                    $statusTone = match($status) {
                        'Pending' => 'bg-amber-100 text-amber-800 dark:bg-amber-950/40 dark:text-amber-200',
                        'Approved' => 'bg-blue-100 text-blue-800 dark:bg-blue-950/40 dark:text-blue-200',
                        'Completed' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-200',
                        'Rejected' => 'bg-rose-100 text-rose-800 dark:bg-rose-950/40 dark:text-rose-200',
                        default => 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-100',
                    };

                    $timelineTone = match($status) {
                        'Pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-200',
                        'Approved' => 'bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-200',
                        'Completed' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-200',
                        'Rejected' => 'bg-rose-100 text-rose-700 dark:bg-rose-950/40 dark:text-rose-200',
                        default => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-100',
                    };
                @endphp

                <article class="card-panel dark:card-panel-dark">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                        <div class="max-w-2xl">
                            <div class="flex flex-wrap items-center gap-3">
                                <h2 class="text-xl font-semibold text-slate-900 dark:text-white">{{ $request->patient_name }}</h2>
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusTone }}">{{ $status }}</span>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-slate-500 dark:text-slate-300">
                                {{ $request->blood_group }} � {{ $request->hospital }} � {{ $request->city }}
                            </p>
                            <p class="mt-4 text-sm leading-6 text-slate-700 dark:text-slate-200">
                                {{ \Illuminate\Support\Str::limit($request->message ?? 'No message was provided for this request.', 140) }}
                            </p>

                            @if($request->admin_message)
                                <div class="mt-4 rounded-[1.5rem] border border-slate-200 bg-slate-50 px-4 py-3 dark:border-slate-700 dark:bg-slate-900/80">
                                    <p class="text-sm font-semibold text-slate-900 dark:text-white">Admin response</p>
                                    <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-200">{{ $request->admin_message }}</p>
                                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Updated {{ optional($request->status_updated_at)->format('M d, Y � H:i') }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="w-full max-w-sm">
                            <div class="rounded-[1.5rem] bg-slate-50 p-4 dark:bg-slate-900/70">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900 dark:text-white">Progress</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-300">Request timeline</p>
                                    </div>
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $timelineTone }}">{{ $status }}</span>
                                </div>

                                <ul class="mt-4 space-y-1">
                                    @php
                                        $timeline = [
                                            ['label' => 'Request Created', 'time' => optional($request->created_at)->format('M d, Y � H:i'), 'done' => true, 'active' => false],
                                            ['label' => 'Under Review', 'time' => $status === 'Pending' ? 'Waiting for review' : optional($request->status_updated_at)->format('M d, Y � H:i'), 'done' => in_array($status, ['Approved', 'Completed', 'Rejected']), 'active' => $status === 'Pending'],
                                            ['label' => 'Approved', 'time' => $status === 'Approved' ? 'Approved and ready' : ($status === 'Completed' ? 'Completed after approval' : ($status === 'Rejected' ? 'Rejected' : 'Pending')), 'done' => in_array($status, ['Approved', 'Completed']), 'active' => $status === 'Approved'],
                                            ['label' => 'Donors Contacted', 'time' => $status === 'Completed' ? 'Contacted and fulfilled' : 'Awaiting donor outreach', 'done' => $status === 'Completed', 'active' => $status === 'Completed'],
                                            ['label' => 'Completed', 'time' => $status === 'Completed' ? 'Support complete' : 'In progress', 'done' => $status === 'Completed', 'active' => $status === 'Completed'],
                                        ];
                                    @endphp

                                    @foreach($timeline as $item)
                                        <x-timeline-step
                                            :label="$item['label']"
                                            :time="$item['time']"
                                            :done="$item['done']"
                                            :active="$item['active']"
                                            status="{{ $status === 'Rejected' && $loop->index === 2 ? 'Needs attention' : 'Live tracking' }}"
                                        />
                                    @endforeach
                                </ul>
                            </div>

                            <div class="mt-4 flex flex-wrap gap-3">
                                <a href="{{ route('requests.show', $request->_id) }}" class="btn-primary">View details</a>
                                @if($status === 'Pending')
                                    <form method="POST" action="{{ route('requests.cancel', $request->_id) }}" onsubmit="return confirm('Cancel this request?')">
                                        @csrf
                                        <button type="submit" class="btn-secondary">Cancel request</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-6">{{ $requests->links() }}</div>
    @endif
</div>

@push('scripts')
<script>
    const pendingCount = {{ $requests->where('status', 'Pending')->count() }};
    const approvedCount = {{ $requests->where('status', 'Approved')->count() }};
    const rejectedCount = {{ $requests->where('status', 'Rejected')->count() }};
    const completedCount = {{ $requests->where('status', 'Completed')->count() }};

    window.__ebloodNotificationsSeed = [
        @if($requests->where('status', 'Approved')->count() > 0)
            {
                id: 'approved-request',
                title: 'Request approved',
                message: 'One of your requests has been approved and is moving forward.',
                type: 'approved',
                read: false,
            },
        @endif
        @if($requests->where('status', 'Rejected')->count() > 0)
            {
                id: 'rejected-request',
                title: 'Request rejected',
                message: 'One of your requests was rejected by an admin. Review the response for next steps.',
                type: 'rejected',
                read: false,
            },
        @endif
        @if($requests->where('status', 'Completed')->count() > 0)
            {
                id: 'completed-request',
                title: 'Request completed',
                message: 'Your completed requests are now marked as fulfilled and ready for review.',
                type: 'approved',
                read: false,
            },
        @endif
        {
            id: 'pending-review',
            title: 'Request review',
            message: pendingCount > 0
                ? `You have ${pendingCount} pending request${pendingCount === 1 ? '' : 's'} that need attention.`
                : 'Your requests are being tracked in the request timeline and can be reviewed anytime.',
            type: pendingCount > 0 ? 'reminder' : 'announcement',
            read: false,
        },
        {
            id: 'status-summary',
            title: 'Status snapshot',
            message: `Approved: ${approvedCount} • Rejected: ${rejectedCount} • Completed: ${completedCount}`,
            type: 'announcement',
            read: false,
        },
    ];
</script>
@endpush

@endsection
