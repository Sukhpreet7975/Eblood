@extends('layouts.app')

@section('content')

<div class="container mx-auto p-6">

    <h1 class="text-3xl font-bold mb-6">My Requests</h1>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-4">{{ session('success') }}</div>
    @endif

    @if($requests->count() == 0)
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 text-center">
            <h2 class="text-xl font-semibold">No requests yet</h2>
            <p class="text-gray-500 mt-2">You haven't submitted any emergency requests. Use the button below to create one.</p>
            <a href="/blood-request" class="mt-4 inline-block bg-red-600 text-white px-6 py-2 rounded-lg">Create Request</a>
        </div>
    @else

        <div class="grid gap-4">
            @foreach($requests as $request)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm flex flex-col md:flex-row justify-between gap-4">
                    <div>
                        <h3 class="font-semibold text-lg">{{ $request->patient_name }}</h3>
                        <p class="text-gray-500">{{ $request->blood_group }} • {{ $request->hospital }} • {{ $request->city }}</p>
                        <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ $request->message ?? '-' }}</p>
                        <p class="mt-2 text-xs text-gray-400">Submitted: {{ optional($request->created_at)->format('Y-m-d H:i') }}</p>
                    </div>

                    <div class="flex flex-col items-start md:items-end gap-2">
                        @php $status = $request->status ?? 'Pending'; @endphp
                        @if($status == 'Pending')
                            <span class="bg-yellow-400 text-black px-3 py-1 rounded-full">Pending</span>
                        @elseif($status == 'Approved')
                            <span class="bg-blue-500 text-white px-3 py-1 rounded-full">Approved</span>
                        @elseif($status == 'Completed')
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full">Completed</span>
                        @else
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full">Rejected</span>
                        @endif

                        @if($request->admin_message)
                            <div class="mt-3 w-full rounded-3xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-700 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200">
                                <p class="font-semibold">Admin Response</p>
                                <p class="mt-2 whitespace-pre-line">{{ $request->admin_message }}</p>
                                <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Updated {{ optional($request->status_updated_at)->format('Y-m-d H:i') }}</p>
                            </div>
                        @endif

                        <div class="flex gap-2 mt-2">
                            <a href="/request/{{ $request->_id }}" class="text-sm text-red-600 hover:underline">View</a>
                            <form method="POST" action="{{ route('request.cancel', $request->_id) }}" onsubmit="return confirm('Cancel this request?')">
                                @csrf
                                <button class="text-sm text-gray-600 hover:underline">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">{{ $requests->links() }}</div>

    @endif

</div>

@endsection
