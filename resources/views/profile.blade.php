@extends('layouts.donor')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-8">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="card-panel dark:card-panel-dark hover:shadow-xl transition">
                <div class="flex flex-col items-center text-center">
                    <div class="w-40 h-40 rounded-full overflow-hidden border-4 border-white shadow-md">
                        @if($user->profile_image)
                            <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=fff&color=dc2626&size=256" alt="avatar" class="w-full h-full object-cover">
                        @endif
                    </div>

                    <h2 class="mt-4 text-2xl font-bold">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">Member since {{ optional($user->created_at)->format('M Y') }}</p>

                    <div class="mt-4 flex flex-wrap justify-center gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-50 text-red-700 font-semibold">{{ $user->blood_group ?? 'N/A' }}</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full {{ $user->available == 'yes' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->available == 'yes' ? 'Available' : 'Unavailable' }}
                        </span>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button id="open-edit-modal" class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-4 py-2 rounded-lg hover:opacity-95 transition">Edit Profile</button>
                        <a href="{{ route('availability') }}" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 transition">Manage Availability</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="card-panel dark:card-panel-dark">
                <h3 class="text-xl font-semibold mb-4">Personal Information</h3>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium">{{ $user->email }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Phone</p>
                        <p class="font-medium">{{ $user->phone ?? 'Not Added' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">City</p>
                        <p class="font-medium">{{ $user->city ?? 'Not Added' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="font-medium">{{ $user->address ?? 'Not Added' }}</p>
                    </div>
                </div>
            </div>

            <div class="card-panel dark:card-panel-dark">
                <h3 class="text-xl font-semibold mb-4">Profile Image</h3>

                <form action="/upload-image" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    @csrf
                    <input type="file" name="profile_image" class="block w-full sm:w-auto" />
                    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg">Upload Image</button>
                </form>
            </div>
        </div>

    </div>

    <!-- Edit Modal -->
    <div id="edit-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="card-panel dark:card-panel-dark rounded-lg w-full max-w-lg p-6">
            <div class="flex justify-between items-center">
                <h4 class="text-lg font-semibold">Edit Profile</h4>
                <button id="close-edit-modal" class="text-gray-500 hover:text-gray-700">✕</button>
            </div>

            <p class="text-sm text-gray-500 mt-2">You can edit your profile information on the edit page.</p>
            <div class="mt-4 flex gap-3">
                <a href="/profile/edit" class="bg-red-600 text-white px-4 py-2 rounded-lg">Go to Edit Page</a>
                <button id="close-edit-modal-2" class="px-4 py-2 rounded-lg bg-gray-200">Close</button>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const open = document.getElementById('open-edit-modal');
    const modal = document.getElementById('edit-modal');
    const close = document.getElementById('close-edit-modal');
    const close2 = document.getElementById('close-edit-modal-2');

    if(open){ open.addEventListener('click', ()=> modal.classList.remove('hidden')) }
    if(close){ close.addEventListener('click', ()=> modal.classList.add('hidden')) }
    if(close2){ close2.addEventListener('click', ()=> modal.classList.add('hidden')) }
});
</script>
@endpush

@endsection