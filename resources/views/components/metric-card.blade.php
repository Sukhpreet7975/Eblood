@props(['label', 'value', 'caption' => null, 'icon' => null])

<div {{ $attributes->merge(['class' => 'rounded-[1.75rem] border border-slate-200/80 bg-white/95 p-5 shadow-[0_24px_80px_-50px_rgba(15,23,42,0.35)] dark:border-slate-700/80 dark:bg-slate-950/85']) }}>
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">{{ $label }}</p>
            <p class="mt-3 text-2xl font-bold text-slate-900 dark:text-white">{{ $value }}</p>
            @if($caption)
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">{{ $caption }}</p>
            @endif
        </div>

        @if($icon)
            <div class="inline-flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-2xl bg-red-50 text-red-600 dark:bg-red-950/40 dark:text-red-200">
                {!! $icon !!}
            </div>
        @endif
    </div>

    @if($slot->isNotEmpty())
        <div class="mt-4">{{ $slot }}</div>
    @endif
</div>
