

<?php $__env->startSection('content'); ?>

<div class="max-w-2xl mx-auto card-panel dark:card-panel-dark">
    <h1 class="text-3xl font-bold mb-6 text-center text-red-600">
        Become a Blood Donor
    </h1>
    <?php if($errors->any()): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-3xl mb-6">
        <ul class="list-disc list-inside space-y-1">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    <form action="/save-donor" method="POST" class="space-y-5">
        <?php echo csrf_field(); ?>
        <div>
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Phone Number
            </label>

            <input
                type="text"
                name="phone"
                class="form-field dark:form-field-dark"
                required>
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Blood Group
            </label>

            <select name="blood_group" class="form-field dark:form-field-dark">
                <option>A+</option>
                <option>A-</option>
                <option>B+</option>
                <option>B-</option>
                <option>O+</option>
                <option>O-</option>
                <option>AB+</option>
                <option>AB-</option>
            </select>
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                City
            </label>

            <input
                type="text"
                name="city"
                class="form-field dark:form-field-dark"
                required>
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Address
            </label>

            <textarea
                name="address"
                class="form-field dark:form-field-dark"
                rows="4"></textarea>
        </div>

        <button class="w-full bg-red-600 text-white p-3 rounded hover:bg-red-700">
            Save Donor
        </button>
    </form>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.donor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views/donor-form.blade.php ENDPATH**/ ?>