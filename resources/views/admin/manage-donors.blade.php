@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-red-600">Admin</p>
            <h1 class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">Manage donors</h1>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Review registered donors and remove any invalid profile records.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-red-300 hover:text-red-600 dark:border-slate-700 dark:text-slate-100">Back to dashboard</a>
    </div>

    <div class="overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-950/80">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700 dark:text-slate-100">Name</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700 dark:text-slate-100">Email</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700 dark:text-slate-100">Blood group</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700 dark:text-slate-100">City</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700 dark:text-slate-100">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700 dark:text-slate-100">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($donors as $donor)
                        <tr>
                            <td class="px-4 py-4 text-sm text-slate-900 dark:text-white">{{ $donor->name ?? 'Unknown donor' }}</td>
                            <td class="px-4 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $donor->email ?? 'No email' }}</td>
                            <td class="px-4 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $donor->blood_group ?? 'Unknown' }}</td>
                            <td class="px-4 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $donor->city ?? 'Unknown city' }}</td>
                            <td class="px-4 py-4 text-sm">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $donor->available === 'yes' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-200' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-100' }}">
                                    {{ $donor->available === 'yes' ? 'Available' : 'Unavailable' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <a href="{{ route('admin.delete-user', $donor->_id) }}" class="font-semibold text-rose-600 hover:text-rose-700" onclick="return confirm('Delete this donor account?')">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-sm text-slate-500 dark:text-slate-300">No donors found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-200 px-4 py-4 dark:border-slate-700">
            {{ $donors->links() }}
        </div>
    </div>
</div>
@endsection
