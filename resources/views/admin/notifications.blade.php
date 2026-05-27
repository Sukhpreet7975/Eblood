@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div>
        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-red-600">Admin</p>
        <h1 class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">Notifications</h1>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Platform notifications for admins.</p>
    </div>

    <div class="card-panel">
        @foreach($notifications as $note)
            <div class="mb-3 rounded-2xl border px-4 py-3">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold">{{ $note['title'] }}</p>
                        <p class="text-sm text-slate-600">{{ $note['message'] }}</p>
                    </div>
                    <div class="text-xs text-slate-400">{{ $note['type'] }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
