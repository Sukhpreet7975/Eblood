@extends('layouts.app')

@section('content')

<div class="container mx-auto p-6">
    <div class="section-panel dark:section-panel-dark">
        <h1 class="text-3xl font-semibold mb-4 text-red-600">Request Details</h1>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <p><strong>Patient:</strong> {{ $req->patient_name }}</p>
                <p><strong>Phone:</strong> {{ $req->phone }}</p>
                <p><strong>Blood Group:</strong> {{ $req->blood_group }}</p>
                <p><strong>Hospital:</strong> {{ $req->hospital }}</p>
                <p><strong>City:</strong> {{ $req->city }}</p>
                <p class="mt-2"><strong>Message:</strong><br>{{ $req->message ?? '-' }}</p>
            </div>

            <div>
                <p><strong>Submitted:</strong> {{ optional($req->created_at)->format('Y-m-d H:i') }}</p>
                <p class="mt-4"><strong>Status:</strong></p>
                @php $status = $req->status ?? 'Pending'; @endphp
                <div class="mt-2">
                    @if($status == 'Pending')
                        <span class="bg-yellow-400 text-black px-3 py-1 rounded-full">Pending</span>
                    @elseif($status == 'Approved')
                        <span class="bg-blue-500 text-white px-3 py-1 rounded-full">Approved</span>
                    @elseif($status == 'Completed')
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full">Completed</span>
                    @else
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full">Rejected</span>
                    @endif
                </div>

                @if($req->admin_message)
                    <div class="mt-6 rounded-3xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-950">
                        <p class="font-semibold text-slate-900 dark:text-slate-100">Admin Response</p>
                        <p class="mt-3 text-slate-700 dark:text-slate-200 whitespace-pre-line">{{ $req->admin_message }}</p>
                        <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">Status updated {{ optional($req->status_updated_at)->format('Y-m-d H:i') }}</p>
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>

@endsection
