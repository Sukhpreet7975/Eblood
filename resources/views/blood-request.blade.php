@extends('layouts.requester')

@section('content')

<div class="max-w-2xl mx-auto card-panel dark:card-panel-dark">
    <h1 class="text-4xl font-bold text-red-600 mb-6">
        Emergency Blood Request
    </h1>

    @if($errors->any())
        <div class="mb-6 rounded-[1.5rem] border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800 dark:border-red-900 dark:bg-red-950 dark:text-red-100">
            <p class="font-semibold">Please fix the highlighted fields.</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('requester.requests.store') }}" class="space-y-5">
        @csrf
        <div>
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Patient Name
            </label>

            <input
                type="text"
                name="patient_name"
                value="{{ old('patient_name') }}"
                required
                autocomplete="name"
                class="form-field dark:form-field-dark @error('patient_name') border-red-500 ring-2 ring-red-100 @enderror">

            @error('patient_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Blood Group
            </label>

            <select name="blood_group" required class="form-field dark:form-field-dark @error('blood_group') border-red-500 ring-2 ring-red-100 @enderror">
                <option value="" {{ old('blood_group') === null ? 'selected' : '' }}>Select a blood group</option>
                <option value="A+" {{ old('blood_group') === 'A+' ? 'selected' : '' }}>A+</option>
                <option value="A-" {{ old('blood_group') === 'A-' ? 'selected' : '' }}>A-</option>
                <option value="B+" {{ old('blood_group') === 'B+' ? 'selected' : '' }}>B+</option>
                <option value="B-" {{ old('blood_group') === 'B-' ? 'selected' : '' }}>B-</option>
                <option value="O+" {{ old('blood_group') === 'O+' ? 'selected' : '' }}>O+</option>
                <option value="O-" {{ old('blood_group') === 'O-' ? 'selected' : '' }}>O-</option>
                <option value="AB+" {{ old('blood_group') === 'AB+' ? 'selected' : '' }}>AB+</option>
                <option value="AB-" {{ old('blood_group') === 'AB-' ? 'selected' : '' }}>AB-</option>
            </select>

            @error('blood_group')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Hospital
            </label>

            <input
                type="text"
                name="hospital"
                value="{{ old('hospital') }}"
                required
                autocomplete="organization"
                class="form-field dark:form-field-dark @error('hospital') border-red-500 ring-2 ring-red-100 @enderror">

            @error('hospital')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                City
            </label>

            <input
                type="text"
                name="city"
                value="{{ old('city') }}"
                required
                autocomplete="address-level2"
                class="form-field dark:form-field-dark @error('city') border-red-500 ring-2 ring-red-100 @enderror">

            @error('city')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Phone
            </label>

            <input
                type="tel"
                name="phone"
                value="{{ old('phone') }}"
                required
                inputmode="tel"
                autocomplete="tel"
                class="form-field dark:form-field-dark @error('phone') border-red-500 ring-2 ring-red-100 @enderror">

            @error('phone')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Message
            </label>

            <textarea
                name="message"
                rows="4"
                class="form-field dark:form-field-dark @error('message') border-red-500 ring-2 ring-red-100 @enderror">{{ old('message') }}</textarea>

            @error('message')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
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