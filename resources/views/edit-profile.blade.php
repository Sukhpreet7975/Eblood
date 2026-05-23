@extends('layouts.donor')

@section('content')

<div class="max-w-2xl mx-auto card-panel dark:card-panel-dark">

    <h1 class="text-4xl font-bold text-red-600 mb-8">
        Edit Profile
    </h1>

    <form action="/profile/update" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Phone
            </label>

            <input
                type="text"
                name="phone"
                value="{{ $user->phone }}"
                class="form-field dark:form-field-dark">
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Blood Group
            </label>

            <select name="blood_group" class="form-field dark:form-field-dark">
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

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                City
            </label>

            <input
                type="text"
                name="city"
                value="{{ $user->city }}"
                class="form-field dark:form-field-dark">
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Address
            </label>

            <textarea
            name="address"
            rows="4"
            class="form-field dark:form-field-dark">{{ $user->address }}</textarea>
        </div>

        <button class="w-full bg-red-600 text-white p-3 rounded-xl hover:bg-red-700">
            Update Profile
        </button>
    </form>
</div>

@endsection