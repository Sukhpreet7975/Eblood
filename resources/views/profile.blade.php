@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-red-600 p-10 text-white dark:bg-gray-800">
            <div class="flex items-center gap-6">
            @if($user->profile_image)
                <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}" class="w-28 h-28 rounded-full object-cover border-4 border-white">
            @else
            <div class="w-28 h-28 rounded-full bg-white text-red-600 flex items-center justify-center text-4xl font-bold">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            @endif

                <div>
                    <h1 class="text-4xl font-bold">
                        {{ $user->name }}
                    </h1>
                    <p class="text-red-100 mt-2">
                        Blood Donor Profile
                    </p>
                </div>
            </div>
        </div>

        <!-- Info -->
        <div class="p-10">
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-2xl">
                    <h2 class="text-xl font-bold mb-4">
                        Personal Information
                    </h2>
                    <div class="space-y-3">
                        <p>
                            <strong>Email:</strong>
                            {{ $user->email }}
                        </p>

                        <p>
                            <strong>Phone:</strong>
                            {{ $user->phone ?? 'Not Added' }}
                        </p>

                        <p>
                            <strong>City:</strong>
                            {{ $user->city ?? 'Not Added' }}
                        </p>
                    </div>
                </div>

                <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-2xl">
                    <h2 class="text-xl font-bold mb-4">
                        Donor Information
                    </h2>

                    <div class="space-y-3">
                        <p>
                            <strong>Blood Group:</strong>
                            {{ $user->blood_group ?? 'Not Added' }}
                        </p>

                        <p>
                            <strong>Status:</strong>

                            @if($user->available == 'yes')
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full">
                                    Available
                                </span>
                            @else
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full">
                                    Unavailable
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

<form action="/upload-image" method="POST" enctype="multipart/form-data" class="mt-8">
    @csrf
    <input
        type="file"
        name="profile_image"
        class="mb-4">

    <button class="bg-blue-600 text-white px-6 py-2 rounded-xl">
        Upload Image
    </button>
</form>

            <!-- Buttons -->
            <div class="mt-10 flex gap-4">
                <a href="/profile/edit" class="bg-red-600 text-white px-6 py-3 rounded-xl hover:bg-red-700">
                    Edit Profile
                </a>

                <a href="/toggle-status" class="bg-gray-800 text-white px-6 py-3 rounded-xl">
                    Toggle Availability
                </a>
            </div>
        </div>
    </div>
</div>

@endsection