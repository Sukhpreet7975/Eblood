@props(['label', 'time' => null, 'status' => 'upcoming', 'active' => false, 'done' => false])

@php
    $iconClasses = $done
        ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-200'
        : ($active ? 'bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-200' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-300');

    $textClasses = $done
        ? 'text-slate-900 dark:text-white'
        : ($active ? 'text-blue-700 dark:text-blue-200' : 'text-slate-500 dark:text-slate-300');
@endphp

<li class="flex gap-4">
    <div class="flex flex-col items-center">
        <div class="inline-flex h-10 w-10 items-center justify-center rounded-full {{ $iconClasses }}">
            @if($done)
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
            @elseif($active)
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6v6l4 2"/></svg>
            @else
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/></svg>
            @endif
        </div>
        <div class="mt-2 h-full w-px bg-slate-200 dark:bg-slate-700"></div>
    </div>

    <div class="pb-6">
        <p class="text-sm font-semibold {{ $textClasses }}">{{ $label }}</p>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">{{ $time ?? 'Waiting for update' }}</p>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">{{ $status }}</p>
    </div>
</li>
