

<?php $__env->startSection('content'); ?>

<div class="max-w-2xl mx-auto card-panel dark:card-panel-dark">

    <h1 class="text-4xl font-bold text-red-600 mb-8">
        Edit Profile
    </h1>

    <form action="/profile/update" method="POST" class="space-y-5">
        <?php echo csrf_field(); ?>
        <div>
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Phone
            </label>

            <input
                type="text"
                name="phone"
                value="<?php echo e($user->phone); ?>"
                class="form-field dark:form-field-dark">
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Blood Group
            </label>

            <select name="blood_group" class="form-field dark:form-field-dark">
                <option <?php echo e($user->blood_group == 'A+' ? 'selected' : ''); ?>>A+</option>
                <option <?php echo e($user->blood_group == 'A-' ? 'selected' : ''); ?>>A-</option>
                <option <?php echo e($user->blood_group == 'B+' ? 'selected' : ''); ?>>B+</option>
                <option <?php echo e($user->blood_group == 'B-' ? 'selected' : ''); ?>>B-</option>
                <option <?php echo e($user->blood_group == 'O+' ? 'selected' : ''); ?>>O+</option>
                <option <?php echo e($user->blood_group == 'O-' ? 'selected' : ''); ?>>O-</option>
                <option <?php echo e($user->blood_group == 'AB+' ? 'selected' : ''); ?>>AB+</option>
                <option <?php echo e($user->blood_group == 'AB-' ? 'selected' : ''); ?>>AB-</option>
            </select>
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                City
            </label>

            <input
                type="text"
                name="city"
                value="<?php echo e($user->city); ?>"
                class="form-field dark:form-field-dark">
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Address
            </label>

            <textarea
            name="address"
            rows="4"
            class="form-field dark:form-field-dark"><?php echo e($user->address); ?></textarea>
        </div>

        <button class="w-full bg-red-600 text-white p-3 rounded-xl hover:bg-red-700">
            Update Profile
        </button>
    </form>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.donor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views\edit-profile.blade.php ENDPATH**/ ?>