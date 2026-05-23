@extends('layouts.app')

@section('content')

<div class="space-y-8">
    <section class="hero-panel">
        <div class="max-w-3xl">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-rose-100">Donor search</p>
            <h1 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">Find the right donor with privacy-first search.</h1>
            <p class="mt-4 max-w-2xl text-sm leading-7 text-rose-50/90 sm:text-base">
                Search by city and blood group, review only the information needed for a safe match, and keep donor privacy protected at every step.
            </p>
        </div>
    </section>

    <div class="section-panel dark:section-panel-dark">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-red-600">Filter donors</p>
                <h2 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">Refine your search</h2>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Instant updates keep the donor list current while you type.</p>
            </div>
            <div class="rounded-full bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 dark:bg-red-950/40 dark:text-red-200">Responsive • privacy-first • AJAX ready</div>
        </div>

        <form id="search-form" class="mt-6 grid gap-4 lg:grid-cols-[1fr_1fr_auto_auto]">
            <label class="space-y-2 text-sm text-slate-600 dark:text-slate-300">
                <span class="font-semibold">City</span>
                <input id="q-city" name="city" placeholder="Search city" class="form-field dark:form-field-dark" value="{{ request('city') }}" />
            </label>
            <label class="space-y-2 text-sm text-slate-600 dark:text-slate-300">
                <span class="font-semibold">Blood group</span>
                <select id="q-blood" name="blood_group" class="form-field dark:form-field-dark">
                    <option value="">Any blood group</option>
                    @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $group)
                        <option value="{{ $group }}" {{ request('blood_group') === $group ? 'selected' : '' }}>{{ $group }}</option>
                    @endforeach
                </select>
            </label>
            <div class="flex items-end">
                <button id="search-btn" type="submit" class="btn-primary w-full">Search</button>
            </div>
            <div class="flex items-end">
                <button id="clear-btn" type="button" class="btn-secondary w-full">Clear</button>
            </div>
        </form>
    </div>

    <div id="smart-summary" class="grid gap-4 xl:grid-cols-3">
        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Live status</p>
            <p id="refresh-status" class="mt-3 text-lg font-semibold text-slate-900 dark:text-white">Ready</p>
            <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-300">The list refreshes automatically so availability stays current.</p>
        </div>
        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Compatibility</p>
            <p id="compatibility-summary" class="mt-3 text-lg font-semibold text-slate-900 dark:text-white">Choose a blood group to validate compatibility</p>
            <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-300">Compatible donors are highlighted without exposing private contact details.</p>
        </div>
        <div class="card-panel dark:card-panel-dark">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Search focus</p>
            <p id="recommendation-summary" class="mt-3 text-lg font-semibold text-slate-900 dark:text-white">Waiting for a match</p>
            <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-300">Results prioritize local availability, blood group fit, and recent updates.</p>
        </div>
    </div>

    @if($donors->count())
        <div id="results" class="grid gap-5 lg:grid-cols-2 xl:grid-cols-3">
            @foreach($donors as $donor)
                <article class="card-panel dark:card-panel-dark donor-card">
                    <div class="flex items-start gap-4">
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-[1.25rem] bg-red-50 text-lg font-bold text-red-700 dark:bg-red-950/40 dark:text-red-100">
                            @if(!empty($donor->profile_image))
                                <img src="{{ asset('storage/profile_images/' . $donor->profile_image) }}" alt="{{ $donor->name }}" class="h-full w-full object-cover">
                            @else
                                {{ strtoupper(substr((string) $donor->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-red-500">Verified donor</p>
                            <h2 class="mt-2 text-xl font-semibold text-slate-900 dark:text-white">{{ $donor->name }}</h2>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">{{ $donor->city ?? 'City not listed' }}</p>
                        </div>
                    </div>

                    <div class="mt-5 flex flex-wrap items-center gap-2">
                        <span class="rounded-full bg-red-600 px-3 py-1 text-sm font-semibold text-white">{{ $donor->blood_group ?? 'N/A' }}</span>
                        <span class="rounded-full px-3 py-1 text-sm font-semibold {{ $donor->available === 'yes' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-200' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-100' }}">
                            {{ $donor->available === 'yes' ? 'Available now' : 'Currently unavailable' }}
                        </span>
                    </div>

                    <div class="mt-5 rounded-[1.5rem] bg-slate-50 px-4 py-3 dark:bg-slate-900/70">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Privacy note</p>
                        <p class="mt-2 text-sm leading-6 text-slate-700 dark:text-slate-200">Only limited donor details are shown here for safety. Contact information is shared only after a request is approved.</p>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">{{ $donors->links() }}</div>
    @else
        <x-empty-state
            title="No donors found"
            description="Try adjusting the city or blood group to widen your search and discover more available donors near you."
            button-text="Reset search"
            button-href="/search"
        >
            <svg viewBox="0 0 24 24" class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 21l-4.35-4.35"/>
                <circle cx="11" cy="11" r="7"/>
            </svg>
        </x-empty-state>
    @endif
</div>

@endsection