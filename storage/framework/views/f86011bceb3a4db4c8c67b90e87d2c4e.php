<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['label', 'value', 'caption' => null, 'icon' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['label', 'value', 'caption' => null, 'icon' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div <?php echo e($attributes->merge(['class' => 'rounded-[1.75rem] border border-slate-200/80 bg-white/95 p-5 shadow-[0_24px_80px_-50px_rgba(15,23,42,0.35)] dark:border-slate-700/80 dark:bg-slate-950/85'])); ?>>
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400"><?php echo e($label); ?></p>
            <p class="mt-3 text-2xl font-bold text-slate-900 dark:text-white"><?php echo e($value); ?></p>
            <?php if($caption): ?>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300"><?php echo e($caption); ?></p>
            <?php endif; ?>
        </div>

        <?php if($icon): ?>
            <div class="inline-flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-2xl bg-red-50 text-red-600 dark:bg-red-950/40 dark:text-red-200">
                <?php echo $icon; ?>

            </div>
        <?php endif; ?>
    </div>

    <?php if($slot->isNotEmpty()): ?>
        <div class="mt-4"><?php echo e($slot); ?></div>
    <?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views\components\metric-card.blade.php ENDPATH**/ ?>