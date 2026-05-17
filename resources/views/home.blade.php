@extends('layouts.app')

@section('content')

<!-- Hero Section -->

<div class="bg-gradient-to-r
            from-red-600 to-red-800
            text-white rounded-3xl
            p-12 shadow-2xl">

    <div class="max-w-3xl">

        <h1 class="text-6xl font-extrabold
                   leading-tight mb-6">

            Donate Blood <br>
            Save Human Life

        </h1>

        <p class="text-xl text-red-100 mb-8">

            Your single donation can save
            multiple lives.

        </p>

        <a href="/blood-request"
           class="bg-white text-red-600
                  px-8 py-4 rounded-2xl
                  font-bold hover:bg-red-100
                  transition">

            Request Blood

        </a>

    </div>

</div>

<!-- Search Section -->

<div class="bg-white dark:bg-gray-800
            p-6 rounded-3xl shadow-xl mt-10">

    <h2 class="text-3xl font-bold mb-6">

        Search Blood Donors

    </h2>

    <div class="grid md:grid-cols-2 gap-4">

        <!-- Blood Group -->

        <select
            id="blood_group"
            class="border p-4 rounded-xl
                   w-full dark:bg-gray-700
                   dark:border-gray-600">

            <option value="">

                Select Blood Group

            </option>

            <option>A+</option>
            <option>A-</option>
            <option>B+</option>
            <option>B-</option>
            <option>O+</option>
            <option>O-</option>
            <option>AB+</option>
            <option>AB-</option>

        </select>

        <!-- City -->

        <input
            type="text"
            id="city"
            placeholder="Enter city"
            class="border p-4 rounded-xl
                   w-full dark:bg-gray-700
                   dark:border-gray-600">

    </div>

</div>

<!-- Donors Section -->

<div class="mt-12">

    <div class="flex justify-between
                items-center mb-6">

        <h2 class="text-4xl font-bold">

            Available Donors

        </h2>

        <span class="bg-red-600 text-white
                     px-4 py-2 rounded-full">

            {{ $donors->count() }} Donors

        </span>

    </div>

    <!-- Donor Cards -->

    <div
        id="donors-container"
        class="grid md:grid-cols-3 gap-8">

        @foreach($donors as $donor)

        <div class="bg-white dark:bg-gray-800
                    p-6 rounded-3xl shadow-xl
                    hover:scale-105
                    transition-all duration-300">

            <!-- Image -->

            <div class="flex justify-center mb-5">

                @if($donor->profile_image)

                <img
                    src="{{ asset('storage/profile_images/' . $donor->profile_image) }}"
                    class="w-28 h-28 rounded-full
                           object-cover border-4
                           border-red-500">

                @else

                <div class="w-28 h-28 rounded-full
                            bg-red-100 flex
                            items-center justify-center
                            text-4xl font-bold
                            text-red-600">

                    {{ strtoupper(substr($donor->name, 0, 1)) }}

                </div>

                @endif

            </div>

            <!-- Name -->

            <div class="text-center">

                <h3 class="text-2xl font-bold">

                    {{ $donor->name }}

                </h3>

                <span class="inline-block
                             mt-3 bg-red-600
                             text-white px-4 py-2
                             rounded-full">

                    {{ $donor->blood_group }}

                </span>

            </div>

            <!-- Details -->

            <div class="mt-6 space-y-3">

                <p>

                    <strong>City:</strong>

                    {{ $donor->city }}

                </p>

                <p>

                    <strong>Status:</strong>

                    @if($donor->available == 'yes')

                    <span class="text-green-600 font-bold">

                        Available

                    </span>

                    @else

                    <span class="text-red-600 font-bold">

                        Unavailable

                    </span>

                    @endif

                </p>

            </div>

            <!-- Button -->

            <button
                onclick="openModal(
                    '{{ $donor->name }}',
                    '{{ $donor->blood_group }}',
                    '{{ $donor->city }}',
                    '{{ $donor->phone }}',
                    '{{ $donor->email }}'
                )"
                class="mt-6 w-full
                       bg-red-600 text-white
                       px-6 py-3 rounded-2xl
                       hover:bg-red-700 transition">

                Contact Donor

            </button>

        </div>

        @endforeach

    </div>

</div>

<!-- Contact Modal -->

<div id="donorModal"
     class="fixed inset-0 bg-black/60
            hidden items-center
            justify-center z-50">

    <div class="bg-white dark:bg-gray-800
                rounded-3xl p-8
                w-[90%] max-w-lg
                relative">

        <!-- Close -->

        <button
            onclick="closeModal()"
            class="absolute top-4 right-4
                   text-2xl">

            ✕

        </button>

        <h2 class="text-3xl font-bold mb-6">

            Donor Details

        </h2>

        <div class="space-y-4">

            <p>
                <strong>Name:</strong>
                <span id="modal-name"></span>
            </p>

            <p>
                <strong>Blood Group:</strong>
                <span id="modal-blood"></span>
            </p>

            <p>
                <strong>City:</strong>
                <span id="modal-city"></span>
            </p>

            <p>
                <strong>Phone:</strong>
                <span id="modal-phone"></span>
            </p>

            <p>
                <strong>Email:</strong>
                <span id="modal-email"></span>
            </p>

        </div>

        <!-- Buttons -->

        <div class="mt-8 flex gap-4">

            <a
                id="call-btn"
                href="#"
                class="bg-green-600 text-white
                       px-6 py-3 rounded-xl">

                Call

            </a>

            <a
                id="mail-btn"
                href="#"
                class="bg-blue-600 text-white
                       px-6 py-3 rounded-xl">

                Email

            </a>

        </div>

    </div>

</div>

<!-- Pagination -->

<div class="mt-12">

    {{ $donors->links() }}

</div>

<!-- Live Search Script -->

<script>

    /*
    |--------------------------------------------------------------------------
    | Live Search
    |--------------------------------------------------------------------------
    */

    const bloodGroup =
        document.getElementById('blood_group');

    const city =
        document.getElementById('city');

    async function fetchDonors()
    {
        try
        {
            const response = await fetch(

                `/live-search?blood_group=${encodeURIComponent(bloodGroup.value)}&city=${encodeURIComponent(city.value)}`

            );

            const donors =
                await response.json();

            let html = '';

            /*
            |--------------------------------------------------------------------------
            | No Donors
            |--------------------------------------------------------------------------
            */

            if(donors.length === 0)
            {
                html = `

                <div class="col-span-3">

                    <div class="bg-red-100
                                text-red-700
                                p-6 rounded-2xl">

                        No donors found.

                    </div>

                </div>

                `;
            }

            /*
            |--------------------------------------------------------------------------
            | Donors Cards
            |--------------------------------------------------------------------------
            */

            donors.forEach(donor => {

                const image =
                    donor.profile_image
                    ?
                    `
                    <img
                        src="/storage/profile_images/${donor.profile_image}"
                        class="w-28 h-28 rounded-full
                               object-cover border-4
                               border-red-500">
                    `
                    :
                    `
                    <div class="w-28 h-28 rounded-full
                                bg-red-100 flex
                                items-center justify-center
                                text-4xl font-bold
                                text-red-600">

                        ${donor.name.charAt(0).toUpperCase()}

                    </div>
                    `;

                html += `

<div class="bg-white dark:bg-gray-800
            p-6 rounded-3xl shadow-xl
            hover:scale-105
            transition-all duration-300">

    <!-- Image -->

    <div class="flex justify-center mb-5">

        ${image}

    </div>

    <!-- Name -->

    <div class="text-center">

        <h3 class="text-2xl font-bold">

            ${donor.name}

        </h3>

        <span class="inline-block
                     mt-3 bg-red-600
                     text-white px-4 py-2
                     rounded-full">

            ${donor.blood_group ?? '-'}

        </span>

    </div>

    <!-- Details -->

    <div class="mt-6 space-y-3">

        <p>

            <strong>City:</strong>

            ${donor.city ?? '-'}

        </p>

        <p>

            <strong>Status:</strong>

            ${donor.available ?? '-'}

        </p>

    </div>

    <!-- Button -->

    <button
        onclick="
            openModal(
                '${donor.name}',
                '${donor.blood_group}',
                '${donor.city}',
                '${donor.phone}',
                '${donor.email}'
            )
        "
        class="mt-6 w-full
               bg-red-600 text-white
               px-6 py-3 rounded-2xl
               hover:bg-red-700 transition">

        Contact Donor

    </button>

</div>

`;
            });

            document.getElementById(
                'donors-container'
            ).innerHTML = html;
        }
        catch(error)
        {
            console.log(error);
        }
    }

    bloodGroup.addEventListener(
        'change',
        fetchDonors
    );

    city.addEventListener(
        'keyup',
        fetchDonors
    );

    /*
    |--------------------------------------------------------------------------
    | Modal
    |--------------------------------------------------------------------------
    */

    function openModal(
        name,
        blood,
        city,
        phone,
        email
    )
    {
        document.getElementById(
            'modal-name'
        ).innerText = name;

        document.getElementById(
            'modal-blood'
        ).innerText = blood;

        document.getElementById(
            'modal-city'
        ).innerText = city;

        document.getElementById(
            'modal-phone'
        ).innerText = phone;

        document.getElementById(
            'modal-email'
        ).innerText = email;

        document.getElementById(
            'call-btn'
        ).href = `tel:${phone}`;

        document.getElementById(
            'mail-btn'
        ).href = `mailto:${email}`;

        document.getElementById(
            'donorModal'
        ).classList.remove('hidden');

        document.getElementById(
            'donorModal'
        ).classList.add('flex');
    }

    function closeModal()
    {
        document.getElementById(
            'donorModal'
        ).classList.add('hidden');

        document.getElementById(
            'donorModal'
        ).classList.remove('flex');
    }

</script>

@endsection