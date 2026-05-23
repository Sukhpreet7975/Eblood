@props(['title', 'description', 'icon' => null, 'buttonText' => null, 'buttonHref' => null])

<div {{ $attributes->merge(['class' => 'rounded-[2rem] border border-dashed border-slate-200 bg-white/95 px-6 py-10 text-center shadow-[0_18px_50px_-32px_rgba(15,23,42,0.28)] dark:border-slate-700 dark:bg-slate-950/80']) }}>
    @if($slot->isNotEmpty())
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-[1.5rem] bg-red-50 text-red-600 dark:bg-red-950/40 dark:text-red-200">
            {{ $slot }}
        </div>
    @elseif($icon)
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-[1.5rem] bg-red-50 text-red-600 dark:bg-red-950/40 dark:text-red-200">
            {!! $icon !!}
        </div>
    @endif

    <h3 class="mt-4 text-xl font-semibold text-slate-900 dark:text-white">{{ $title }}</h3>
    <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-slate-500 dark:text-slate-300">{{ $description }}</p>

    @if($buttonText && $buttonHref)
        <div class="mt-6">
            <a href="{{ $buttonHref }}" class="btn-primary">{{ $buttonText }}</a>
        </div>
    @endif
</div>
