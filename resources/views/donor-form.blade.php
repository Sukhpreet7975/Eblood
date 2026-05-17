@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
    <h1 class="text-3xl font-bold mb-6 text-center text-red-600">
        Become Blood Donor
    </h1>
@if($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

    <form action="/save-donor" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-2 font-bold">
                Phone Number
            </label>

            <input
                type="text"
                name="phone"
                class="w-full border p-3 rounded dark:bg-gray-700 dark:border-gray-600"
                required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-bold">
                Blood Group
            </label>

            <select name="blood_group" class="w-full border p-3 rounded dark:bg-gray-700 dark:border-gray-600">
                <option>A+</option>
                <option>A-</option>
                <option>B+</option>
                <option>B-</option>
                <option>O+</option>
                <option>O-</option>
                <option>AB+</option>
                <option>AB-</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-bold">
                City
            </label>

            <input
                type="text"
                name="city"
                class="w-full border p-3 rounded dark:bg-gray-700 dark:border-gray-600"
                required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-bold">
                Address
            </label>

            <textarea
                name="address"
                class="w-full border p-3 rounded dark:bg-gray-700 dark:border-gray-600"
                rows="4"></textarea>
        </div>

        <button class="w-full bg-red-600 text-white p-3 rounded hover:bg-red-700">
            Save Donor
        </button>
    </form>
</div>

@endsection