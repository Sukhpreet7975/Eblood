<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['label', 'time' => null, 'status' => 'upcoming', 'active' => false, 'done' => false]));

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

foreach (array_filter((['label', 'time' => null, 'status' => 'upcoming', 'active' => false, 'done' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $iconClasses = $done
        ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-200'
        : ($active ? 'bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-200' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-300');

    $textClasses = $done
        ? 'text-slate-900 dark:text-white'
        : ($active ? 'text-blue-700 dark:text-blue-200' : 'text-slate-500 dark:text-slate-300');
?>

<li class="flex gap-4">
    <div class="flex flex-col items-center">
        <div class="inline-flex h-10 w-10 items-center justify-center rounded-full <?php echo e($iconClasses); ?>">
            <?php if($done): ?>
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
            <?php elseif($active): ?>
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6v6l4 2"/></svg>
            <?php else: ?>
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/></svg>
            <?php endif; ?>
        </div>
        <div class="mt-2 h-full w-px bg-slate-200 dark:bg-slate-700"></div>
    </div>

    <div class="pb-6">
        <p class="text-sm font-semibold <?php echo e($textClasses); ?>"><?php echo e($label); ?></p>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-300"><?php echo e($time ?? 'Waiting for update'); ?></p>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-300"><?php echo e($status); ?></p>
    </div>
</li>
<?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views/components/timeline-step.blade.php ENDPATH**/ ?>