

<?php $__env->startSection('content'); ?>

<div class="max-w-2xl mx-auto card-panel dark:card-panel-dark">
    <h1 class="text-4xl font-bold text-red-600 mb-6">
        Emergency Blood Request
    </h1>

    <?php if($errors->any()): ?>
        <div class="mb-6 rounded-[1.5rem] border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800 dark:border-red-900 dark:bg-red-950 dark:text-red-100">
            <p class="font-semibold">Please fix the highlighted fields.</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('requests.store')); ?>" class="space-y-5">
        <?php echo csrf_field(); ?>
        <div>
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Patient Name
            </label>

            <input
                type="text"
                name="patient_name"
                value="<?php echo e(old('patient_name')); ?>"
                required
                autocomplete="name"
                class="form-field dark:form-field-dark <?php $__errorArgs = ['patient_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-100 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

            <?php $__errorArgs = ['patient_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Blood Group
            </label>

            <select name="blood_group" required class="form-field dark:form-field-dark <?php $__errorArgs = ['blood_group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-100 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <option value="" <?php echo e(old('blood_group') === null ? 'selected' : ''); ?>>Select a blood group</option>
                <option value="A+" <?php echo e(old('blood_group') === 'A+' ? 'selected' : ''); ?>>A+</option>
                <option value="A-" <?php echo e(old('blood_group') === 'A-' ? 'selected' : ''); ?>>A-</option>
                <option value="B+" <?php echo e(old('blood_group') === 'B+' ? 'selected' : ''); ?>>B+</option>
                <option value="B-" <?php echo e(old('blood_group') === 'B-' ? 'selected' : ''); ?>>B-</option>
                <option value="O+" <?php echo e(old('blood_group') === 'O+' ? 'selected' : ''); ?>>O+</option>
                <option value="O-" <?php echo e(old('blood_group') === 'O-' ? 'selected' : ''); ?>>O-</option>
                <option value="AB+" <?php echo e(old('blood_group') === 'AB+' ? 'selected' : ''); ?>>AB+</option>
                <option value="AB-" <?php echo e(old('blood_group') === 'AB-' ? 'selected' : ''); ?>>AB-</option>
            </select>

            <?php $__errorArgs = ['blood_group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Hospital
            </label>

            <input
                type="text"
                name="hospital"
                value="<?php echo e(old('hospital')); ?>"
                required
                autocomplete="organization"
                class="form-field dark:form-field-dark <?php $__errorArgs = ['hospital'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-100 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

            <?php $__errorArgs = ['hospital'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                City
            </label>

            <input
                type="text"
                name="city"
                value="<?php echo e(old('city')); ?>"
                required
                autocomplete="address-level2"
                class="form-field dark:form-field-dark <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-100 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

            <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Phone
            </label>

            <input
                type="tel"
                name="phone"
                value="<?php echo e(old('phone')); ?>"
                required
                inputmode="tel"
                autocomplete="tel"
                class="form-field dark:form-field-dark <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-100 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Message
            </label>

            <textarea
                name="message"
                rows="4"
                class="form-field dark:form-field-dark <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-100 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('message')); ?></textarea>

            <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.requester', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views/blood-request.blade.php ENDPATH**/ ?>