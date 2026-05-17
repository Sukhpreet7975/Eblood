@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg">
    <h1 class="text-4xl font-bold text-red-600 mb-6">
        Emergency Blood Request
    </h1>

    <form method="POST" action="/blood-request">
        @csrf
        <div class="mb-4">
            <label class="block mb-2 font-bold">
                Patient Name
            </label>

            <input
                type="text"
                name="patient_name"
                class="w-full border p-3 rounded dark:bg-gray-700 dark:border-gray-600">
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
                Hospital
            </label>

            <input
                type="text"
                name="hospital"
                class="w-full border p-3 rounded dark:bg-gray-700 dark:border-gray-600">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-bold">
                City
            </label>

            <input
                type="text"
                name="city"
                class="w-full border p-3 rounded dark:bg-gray-700 dark:border-gray-600">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-bold">
                Phone
            </label>

            <input
                type="text"
                name="phone"
                class="w-full border p-3 rounded dark:bg-gray-700 dark:border-gray-600">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-bold">
                Message
            </label>

            <textarea
                name="message"
                rows="4"
                class="w-full border p-3 rounded dark:bg-gray-700 dark:border-gray-600"></textarea>
        </div>

        <button id="submit-btn" class="bg-red-600 text-white px-8 py-3 rounded-xl hover:bg-red-700 transition-all duration-300">
            Submit Request
        </button>
    </form>
</div>

<script>

    const form = document.querySelector('form');
    const button = document.getElementById('submit-btn');
    form.addEventListener('submit', () => {
        button.innerHTML = 'Submitting...';
        button.disabled = true;
        button.classList.add(
            'opacity-50'
        );
    });

</script>

@endsection