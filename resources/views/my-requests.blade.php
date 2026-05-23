@extends('layouts.app')

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

    @if($requests->count() == 0)
        <x-empty-state
            title="No requests yet"
            description="You have not submitted any emergency requests yet. Create one to start helping patients in your area."
            button-text="Create emergency request"
            button-href="{{ route('requester.requests.create') }}"
        >
            <svg viewBox="0 0 24 24" class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 8v8"/>
                <path d="M8 12h8"/>
                <path d="M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18Z"/>
            </svg>
        </x-empty-state>
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
                                <a href="{{ route('requester.requests.show', $request->_id) }}" class="btn-primary">View details</a>
                                @if($status === 'Pending')
                                    <form method="POST" action="{{ route('requester.requests.cancel', $request->_id) }}" onsubmit="return confirm('Cancel this request?')">
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
        {
            id: 'pending-review',
            title: 'Request review',
            message: 'Your requests are being tracked in the request timeline and can be reviewed anytime.',
            type: 'announcement',
            read: false,
        },
    ];
</script>
@endpush

@endsection
