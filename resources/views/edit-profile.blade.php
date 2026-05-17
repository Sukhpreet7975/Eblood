@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-lg">

    <h1 class="text-4xl font-bold text-red-600 mb-8">
        Edit Profile
    </h1>

    <form action="/profile/update" method="POST">
        @csrf
        <div class="mb-5">
            <label class="block mb-2 font-bold">
                Phone
            </label>

            <input
                type="text"
                name="phone"
                value="{{ $user->phone }}"
                class="w-full border p-3 rounded-xl dark:bg-gray-700 dark:border-gray-600">
        </div>

        <div class="mb-5">
            <label class="block mb-2 font-bold">
                Blood Group
            </label>

            <select name="blood_group" class="w-full border p-3 rounded-xl dark:bg-gray-700 dark:border-gray-600">
                <option {{ $user->blood_group == 'A+' ? 'selected' : '' }}>A+</option>
                <option {{ $user->blood_group == 'A-' ? 'selected' : '' }}>A-</option>
                <option {{ $user->blood_group == 'B+' ? 'selected' : '' }}>B+</option>
                <option {{ $user->blood_group == 'B-' ? 'selected' : '' }}>B-</option>
                <option {{ $user->blood_group == 'O+' ? 'selected' : '' }}>O+</option>
                <option {{ $user->blood_group == 'O-' ? 'selected' : '' }}>O-</option>
                <option {{ $user->blood_group == 'AB+' ? 'selected' : '' }}>AB+</option>
                <option {{ $user->blood_group == 'AB-' ? 'selected' : '' }}>AB-</option>
            </select>
        </div>

        <div class="mb-5">
            <label class="block mb-2 font-bold">
                City
            </label>

            <input
                type="text"
                name="city"
                value="{{ $user->city }}"
                class="w-full border p-3 rounded-xl dark:bg-gray-700 dark:border-gray-600">
        </div>

        <div class="mb-5">
            <label class="block mb-2 font-bold">
                Address
            </label>

            <textarea
            name="address"
            rows="4"
            class="w-full border p-3 rounded-xl dark:bg-gray-700 dark:border-gray-600">{{ $user->address }}</textarea>
        </div>

        <button class="w-full bg-red-600 text-white p-3 rounded-xl hover:bg-red-700">
            Update Profile
        </button>
    </form>
</div>

@endsection