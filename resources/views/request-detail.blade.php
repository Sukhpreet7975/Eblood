@extends('layouts.app')

@section('content')

<div class="space-y-8">
    @php
        $status = $req->status ?? 'Pending';
        $statusTone = match($status) {
            'Pending' => 'bg-amber-100 text-amber-800 dark:bg-amber-950/40 dark:text-amber-200',
            'Approved' => 'bg-blue-100 text-blue-800 dark:bg-blue-950/40 dark:text-blue-200',
            'Completed' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-200',
            'Rejected' => 'bg-rose-100 text-rose-800 dark:bg-rose-950/40 dark:text-rose-200',
            default => 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-100',
        };
        $nextAction = match($status) {
            'Pending' => 'This request is waiting for admin review and next approval steps.',
            'Approved' => 'The request has been approved and is ready for donor coordination.',
            'Completed' => 'This request is complete and has been successfully fulfilled.',
            'Rejected' => 'This request was rejected. Review the admin response for any required follow-up.',
            default => 'No action is required right now.',
        };
    @endphp

    <section class="hero-panel">
        <div class="max-w-3xl">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-rose-100">Request detail</p>
            <h1 class="mt-4 text-3xl font-bold tracking-tight sm:text-4xl">{{ $req->patient_name }}</h1>
            <p class="mt-4 text-sm leading-7 text-rose-50/90 sm:text-base">{{ $nextAction }}</p>
        </div>
    </section>

    <div class="grid gap-6 xl:grid-cols-[1fr_0.9fr]">
        <div class="card-panel dark:card-panel-dark">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-red-600">Request overview</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">Critical care details</h2>
                </div>
                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $statusTone }}">{{ $status }}</span>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-[1.5rem] bg-slate-50 px-4 py-4 dark:bg-slate-900/70">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Patient</p>
                    <p class="mt-2 text-sm font-semibold text-slate-900 dark:text-white">{{ $req->patient_name }}</p>
                </div>
                <div class="rounded-[1.5rem] bg-slate-50 px-4 py-4 dark:bg-slate-900/70">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Blood group</p>
                    <p class="mt-2 text-sm font-semibold text-slate-900 dark:text-white">{{ $req->blood_group }}</p>
                </div>
                <div class="rounded-[1.5rem] bg-slate-50 px-4 py-4 dark:bg-slate-900/70">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Hospital</p>
                    <p class="mt-2 text-sm font-semibold text-slate-900 dark:text-white">{{ $req->hospital }}</p>
                </div>
                <div class="rounded-[1.5rem] bg-slate-50 px-4 py-4 dark:bg-slate-900/70">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">City</p>
                    <p class="mt-2 text-sm font-semibold text-slate-900 dark:text-white">{{ $req->city }}</p>
                </div>
                <div class="rounded-[1.5rem] bg-slate-50 px-4 py-4 dark:bg-slate-900/70">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Phone</p>
                    <p class="mt-2 text-sm font-semibold text-slate-900 dark:text-white">{{ $req->phone ?? 'Not shared' }}</p>
                </div>
                <div class="rounded-[1.5rem] bg-slate-50 px-4 py-4 dark:bg-slate-900/70">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Submitted</p>
                    <p class="mt-2 text-sm font-semibold text-slate-900 dark:text-white">{{ optional($req->created_at)->format('M d, Y • H:i') }}</p>
                </div>
            </div>

            <div class="mt-6 rounded-[1.5rem] border border-slate-200 bg-white px-5 py-4 dark:border-slate-700 dark:bg-slate-950/80">
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Request message</p>
                <p class="mt-3 text-sm leading-7 text-slate-700 dark:text-slate-200 whitespace-pre-line">{{ $req->message ?? 'No message was provided for this request.' }}</p>
            </div>

            @if($req->admin_message)
                <div class="mt-6 rounded-[1.5rem] border border-emerald-200 bg-emerald-50 px-5 py-4 dark:border-emerald-900 dark:bg-emerald-950/40">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-700 dark:text-emerald-200">Admin response</p>
                    <p class="mt-3 text-sm leading-7 text-emerald-900 dark:text-emerald-50 whitespace-pre-line">{{ $req->admin_message }}</p>
                    <p class="mt-3 text-xs text-emerald-800/80 dark:text-emerald-100/85">Updated {{ optional($req->status_updated_at)->format('M d, Y • H:i') }}</p>
                </div>
            @endif
        </div>

        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-red-600">Lifecycle</p>
            <h2 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">Status timeline</h2>
            <p class="mt-3 text-sm leading-6 text-slate-500 dark:text-slate-300">Track how this request moved from submission to final resolution.</p>

            <ul class="mt-6 space-y-1">
                @php
                    $timeline = [
                        ['label' => 'Request Created', 'time' => optional($req->created_at)->format('M d, Y • H:i'), 'done' => true, 'active' => false],
                        ['label' => 'Under Review', 'time' => $status === 'Pending' ? 'Waiting for admin review' : optional($req->status_updated_at)->format('M d, Y • H:i'), 'done' => in_array($status, ['Approved', 'Completed', 'Rejected']), 'active' => $status === 'Pending'],
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
    </div>
</div>

@push('scripts')
<script>
    window.__ebloodNotificationsSeed = [
        {
            id: 'request-status',
            title: 'Request status update',
            message: '{{ $nextAction }}',
            type: '{{ $status === "Pending" ? "reminder" : ($status === "Rejected" ? "rejected" : "announcement") }}',
            read: false,
        }
    ];
</script>
@endpush

@endsection
