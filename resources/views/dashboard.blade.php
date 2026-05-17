@extends('layouts.app')

@section('content')

<div class="bg-white dark:bg-gray-800 p-10 rounded-xl shadow-lg">
    <h1 class="text-4xl font-bold text-red-600 mb-4">
        Dashboard
    </h1>

    <p class="text-lg">
        Welcome {{ Auth::user()->name }}
    </p>

    <div class="mt-6">
        <a href="/become-donor" class="bg-red-600 text-white px-6 py-3 rounded">
            Become Donor
        </a>
    </div>
</div>

@endsection