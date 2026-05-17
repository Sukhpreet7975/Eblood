@extends('layouts.app')

@section('content')

<h1 class="text-4xl font-bold mb-8 text-red-600">
    Search Results
</h1>

<div class="grid md:grid-cols-3 gap-6">

    @forelse($donors as $donor)

    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">

        <div class="flex justify-between items-center">

            <h2 class="text-2xl font-bold">
                {{ $donor->name }}
            </h2>

            <span class="bg-red-600 text-white px-3 py-1 rounded-full">
                {{ $donor->blood_group }}
            </span>

        </div>

        <div class="mt-4 space-y-2">

            <p>
                <strong>City:</strong>
                {{ $donor->city }}
            </p>

            <p>
                <strong>Phone:</strong>
                {{ $donor->phone }}
            </p>

        </div>

    </div>

    @empty

    <p>No donors found.</p>

    @endforelse

</div>

<div class="mt-10">
    {{ $donors->links() }}
</div>

@endsection