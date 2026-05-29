<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title', 'description', 'icon' => null, 'buttonText' => null, 'buttonHref' => null]));

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

foreach (array_filter((['title', 'description', 'icon' => null, 'buttonText' => null, 'buttonHref' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div <?php echo e($attributes->merge(['class' => 'rounded-[2rem] border border-dashed border-slate-200 bg-white/95 px-6 py-10 text-center shadow-[0_18px_50px_-32px_rgba(15,23,42,0.28)] dark:border-slate-700 dark:bg-slate-950/80'])); ?>>
    <?php if($slot->isNotEmpty()): ?>
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-[1.5rem] bg-red-50 text-red-600 dark:bg-red-950/40 dark:text-red-200">
            <?php echo e($slot); ?>

        </div>
    <?php elseif($icon): ?>
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-[1.5rem] bg-red-50 text-red-600 dark:bg-red-950/40 dark:text-red-200">
            <?php echo $icon; ?>

        </div>
    <?php endif; ?>

    <h3 class="mt-4 text-xl font-semibold text-slate-900 dark:text-white"><?php echo e($title); ?></h3>
    <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-slate-500 dark:text-slate-300"><?php echo e($description); ?></p>

    <?php if($buttonText && $buttonHref): ?>
        <div class="mt-6">
            <a href="<?php echo e($buttonHref); ?>" class="btn-primary"><?php echo e($buttonText); ?></a>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views/components/empty-state.blade.php ENDPATH**/ ?>