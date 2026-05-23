

<?php $__env->startSection('content'); ?>

<div class="max-w-2xl mx-auto card-panel dark:card-panel-dark">
    <h1 class="text-4xl font-bold text-red-600 mb-6">
        Emergency Blood Request
    </h1>

    <form method="POST" action="<?php echo e(route('requester.requests.store')); ?>" class="space-y-5">
        <?php echo csrf_field(); ?>
        <div>
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Patient Name
            </label>

            <input
                type="text"
                name="patient_name"
                class="form-field dark:form-field-dark">
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
                Hospital
            </label>

            <input
                type="text"
                name="hospital"
                class="form-field dark:form-field-dark">
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                City
            </label>

            <input
                type="text"
                name="city"
                class="form-field dark:form-field-dark">
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Phone
            </label>

            <input
                type="text"
                name="phone"
                class="form-field dark:form-field-dark">
        </div>

        <div class="space-y-2">
            <label class="block mb-2 font-semibold text-slate-700 dark:text-slate-200">
                Message
            </label>

            <textarea
                name="message"
                rows="4"
                class="form-field dark:form-field-dark"></textarea>
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views\blood-request.blade.php ENDPATH**/ ?>