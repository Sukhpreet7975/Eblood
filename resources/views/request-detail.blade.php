@extends('layouts.app')

@section('content')

<div class="container mx-auto p-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6">
        <h1 class="text-2xl font-bold mb-4">Request Details</h1>

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

                @if(auth()->check() && auth()->user()->is_admin)
                    <div class="mt-4">
                        <form method="POST" action="{{ route('admin.request-status', $req->_id) }}">
                            @csrf
                            <select name="status" class="border p-2 rounded-lg">
                                <option value="Pending" {{ $status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Approved" {{ $status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                <option value="Completed" {{ $status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Rejected" {{ $status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            <button class="ml-2 bg-blue-600 text-white px-3 py-2 rounded-lg">Update</button>
                        </form>
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>

@endsection
