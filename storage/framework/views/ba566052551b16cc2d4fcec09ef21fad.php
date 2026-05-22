

<?php $__env->startSection('content'); ?>

<h1 class="text-4xl font-bold mb-8 text-red-600">Search Donors</h1>

<div class="section-panel dark:section-panel-dark mb-6">
    <form id="search-form" class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
        <input id="q-city" name="city" placeholder="City" class="form-field dark:form-field-dark" />
        <select id="q-blood" name="blood_group" class="form-field dark:form-field-dark">
            <option value="">Any blood group</option>
            <?php $__currentLoopData = ['A+','A-','B+','B-','O+','O-','AB+','AB-']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($g); ?>"><?php echo e($g); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <div class="flex flex-col sm:flex-row gap-3">
            <button id="search-btn" class="btn-primary w-full">Search</button>
            <button id="clear-btn" type="button" class="btn-secondary w-full">Clear</button>
        </div>
    </form>
</div>

<div id="results" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    <?php $__empty_1 = true; $__currentLoopData = $donors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card-panel dark:card-panel-dark donor-card">
            <div class="flex flex-col gap-4">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h2 class="text-2xl font-semibold"><?php echo e($donor->name); ?></h2>
                    <span class="rounded-full bg-red-600 px-3 py-1 text-sm font-semibold text-white"><?php echo e($donor->blood_group); ?></span>
                </div>
                <div class="grid gap-2 sm:grid-cols-2 text-sm text-slate-600 dark:text-slate-300">
                    <p><strong>City:</strong> <?php echo e($donor->city); ?></p>
                    <p><strong>Phone:</strong> <?php echo e($donor->phone); ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-gray-500">No donors found.</p>
    <?php endif; ?>
</div>

<div class="mt-10"><?php echo e($donors->links()); ?></div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    const form = document.getElementById('search-form');
    const city = document.getElementById('q-city');
    const blood = document.getElementById('q-blood');
    const results = document.getElementById('results');
    const btn = document.getElementById('search-btn');
    const clear = document.getElementById('clear-btn');

    const render = (donors) => {
        if(!results) return;
        if(!donors.length){
            results.innerHTML = '<p class="text-gray-500">No donors found.</p>';
            return;
        }
        results.innerHTML = donors.map(d => `
            <div class="card-panel dark:card-panel-dark donor-card">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">${d.name}</h2>
                    <span class="bg-red-600 text-white px-3 py-1 rounded-full">${d.blood_group || ''}</span>
                </div>
                <div class="mt-4 space-y-2">
                    <p><strong>City:</strong> ${d.city || ''}</p>
                    <p><strong>Phone:</strong> ${d.phone || ''}</p>
                </div>
            </div>
        `).join('');
    };

    const fetchResults = async () => {
        const q = new URLSearchParams({ city: city.value, blood_group: blood.value });
        try{
            const res = await fetch('/live-search?'+q.toString(), { headers: { 'Accept': 'application/json' } });
            const data = await res.json();
            render(data || []);
        } catch (e){
            results.innerHTML = '<p class="text-red-500">Search failed. Try again.</p>';
        }
    };

    // Instant search on change
    city.addEventListener('input', () => fetchResults());
    blood.addEventListener('change', () => fetchResults());

    form.addEventListener('submit', function(e){ e.preventDefault(); fetchResults(); });

    clear.addEventListener('click', function(){ city.value = ''; blood.value = ''; fetchResults(); });
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views/search.blade.php ENDPATH**/ ?>