@extends('layouts.app')

@section('content')

<h1 class="text-4xl font-bold mb-8 text-red-600">Search Donors</h1>

<div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow mb-6">
    <form id="search-form" class="grid gap-3 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
        <input id="q-city" name="city" placeholder="City" class="border p-3 rounded-xl dark:bg-gray-700 dark:border-gray-600" />
        <select id="q-blood" name="blood_group" class="border p-3 rounded-xl dark:bg-gray-700 dark:border-gray-600">
            <option value="">Any blood group</option>
            @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $g)
                <option value="{{ $g }}">{{ $g }}</option>
            @endforeach
        </select>
        <div class="flex gap-2">
            <button id="search-btn" class="px-4 py-2 rounded-xl bg-red-600 text-white">Search</button>
            <button id="clear-btn" type="button" class="px-4 py-2 rounded-xl border">Clear</button>
        </div>
    </form>
</div>

<div id="results" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @forelse($donors as $donor)
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg donor-card">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold">{{ $donor->name }}</h2>
                <span class="bg-red-600 text-white px-3 py-1 rounded-full">{{ $donor->blood_group }}</span>
            </div>
            <div class="mt-4 space-y-2">
                <p><strong>City:</strong> {{ $donor->city }}</p>
                <p><strong>Phone:</strong> {{ $donor->phone }}</p>
            </div>
        </div>
    @empty
        <p class="text-gray-500">No donors found.</p>
    @endforelse
</div>

<div class="mt-10">{{ $donors->links() }}</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const form = document.getElementById('search-form');
    const city = document.getElementById('q-city');
    const blood = document.getElementById('q-blood');
    const results = document.getElementById('results');
    const btn = document.getElementById('search-btn');
    const clear = document.getElementById('clear-btn');

    const render = (donors) => {
        if(!results) return;
        if(!donors.length){
            results.innerHTML = '<p class="text-gray-500">No donors found.</p>';
            return;
        }
        results.innerHTML = donors.map(d => `
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg donor-card">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">${d.name}</h2>
                    <span class="bg-red-600 text-white px-3 py-1 rounded-full">${d.blood_group || ''}</span>
                </div>
                <div class="mt-4 space-y-2">
                    <p><strong>City:</strong> ${d.city || ''}</p>
                    <p><strong>Phone:</strong> ${d.phone || ''}</p>
                </div>
            </div>
        `).join('');
    };

    const fetchResults = async () => {
        const q = new URLSearchParams({ city: city.value, blood_group: blood.value });
        try{
            const res = await fetch('/live-search?'+q.toString(), { headers: { 'Accept': 'application/json' } });
            const data = await res.json();
            render(data || []);
        } catch (e){
            results.innerHTML = '<p class="text-red-500">Search failed. Try again.</p>';
        }
    };

    // Instant search on change
    city.addEventListener('input', () => fetchResults());
    blood.addEventListener('change', () => fetchResults());

    form.addEventListener('submit', function(e){ e.preventDefault(); fetchResults(); });

    clear.addEventListener('click', function(){ city.value = ''; blood.value = ''; fetchResults(); });
});
</script>
@endpush

@endsection