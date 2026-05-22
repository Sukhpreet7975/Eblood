

<?php $__env->startSection('content'); ?>

<section class="relative overflow-hidden bg-gradient-to-br from-red-600 via-red-700 to-slate-950 text-white">
    <div class="container mx-auto px-6 py-24 lg:py-28">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div class="space-y-8">
                <div class="inline-flex items-center gap-3 rounded-full bg-white/10 px-4 py-2 text-sm font-semibold uppercase tracking-[0.2em] text-white shadow-lg shadow-red-900/20 ring-1 ring-white/10">
                    <span class="inline-flex h-2.5 w-2.5 rounded-full bg-rose-300 animate-pulse"></span>
                    Blood donation made simple
                </div>

                <div class="space-y-6">
                    <h1 class="text-5xl font-extrabold leading-tight tracking-tight md:text-6xl lg:text-7xl">
                        Donate Blood, <span class="text-rose-100">Save Lives</span>
                    </h1>

                    <p class="max-w-2xl text-lg text-red-100/90 sm:text-xl">
                        E-Blood connects donors to patients in urgent need. Join the community, search available donors, and make a life-saving impact today.
                    </p>
                </div>

                <div class="flex flex-col gap-4 sm:flex-row">
                    <a href="/register" class="inline-flex items-center justify-center rounded-full bg-white px-8 py-3 text-base font-semibold text-red-700 shadow-xl shadow-rose-900/20 transition duration-300 hover:-translate-y-1 hover:bg-red-50">
                        Register as Donor
                    </a>
                    <a href="/login" class="inline-flex items-center justify-center rounded-full border border-white/25 bg-white/10 px-8 py-3 text-base font-semibold text-white transition duration-300 hover:-translate-y-1 hover:bg-white/20">
                        Login
                    </a>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/10 p-6 shadow-2xl shadow-black/20 backdrop-blur-xl">
                    <p class="text-sm uppercase tracking-[0.2em] text-rose-200">Fast access</p>
                    <div class="mt-4 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-3xl bg-white/10 p-4 text-center">
                            <p class="text-2xl font-bold"><?php echo e($totalDonors); ?></p>
                            <p class="text-sm text-rose-100/80">Total Donors</p>
                        </div>
                        <div class="rounded-3xl bg-white/10 p-4 text-center">
                            <p class="text-2xl font-bold"><?php echo e($availableDonors); ?></p>
                            <p class="text-sm text-rose-100/80">Available Now</p>
                        </div>
                        <div class="rounded-3xl bg-white/10 p-4 text-center">
                            <p class="text-2xl font-bold"><?php echo e($citiesCovered); ?></p>
                            <p class="text-sm text-rose-100/80">Cities Covered</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -left-10 top-10 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute -right-10 bottom-10 h-40 w-40 rounded-full bg-rose-300/20 blur-3xl"></div>

                <div class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-slate-950/80 p-8 shadow-2xl shadow-black/40">
                    <div class="absolute inset-x-0 top-0 h-24 bg-gradient-to-r from-rose-500/40 via-red-500/30 to-transparent"></div>
                    <div class="relative grid gap-6 rounded-[1.75rem] bg-slate-900/95 p-8 shadow-xl shadow-black/30">
                        <div class="space-y-3">
                            <span class="inline-flex rounded-full bg-rose-500/20 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-rose-100">E-Blood hero</span>
                            <h2 class="text-3xl font-bold text-white">Blood connects us all</h2>
                            <p class="text-sm leading-7 text-slate-300">Instantly search donors by blood group and city. Save time when every minute matters.</p>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-3xl bg-slate-950/80 p-5 text-center ring-1 ring-white/10">
                                <p class="text-4xl font-bold text-rose-300">98%</p>
                                <p class="mt-2 text-sm text-slate-400">Responsive matches</p>
                            </div>
                            <div class="rounded-3xl bg-slate-950/80 p-5 text-center ring-1 ring-white/10">
                                <p class="text-4xl font-bold text-rose-300">24/7</p>
                                <p class="mt-2 text-sm text-slate-400">Emergency ready</p>
                            </div>
                        </div>

                        <div class="mt-4 rounded-3xl bg-gradient-to-br from-rose-600 to-red-700 p-6 text-white shadow-2xl shadow-rose-900/40">
                            <p class="text-sm uppercase tracking-[0.2em] text-rose-100/80">Trusted by communities</p>
                            <p class="mt-3 text-xl font-semibold">Thousands of donors standing ready to help when it matters most.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-slate-50 dark:bg-slate-950 py-20">
    <div class="container mx-auto px-6">
        <div class="grid gap-10 lg:grid-cols-4">
            <article class="rounded-3xl border border-slate-200/80 bg-white p-8 shadow-lg shadow-slate-900/5 transition hover:-translate-y-2 dark:border-slate-700/80 dark:bg-slate-900 dark:text-slate-100">
                <p class="text-4xl font-bold text-red-600"><?php echo e($totalDonors); ?></p>
                <p class="mt-3 text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Total Donors</p>
            </article>

            <article class="rounded-3xl border border-slate-200/80 bg-white p-8 shadow-lg shadow-slate-900/5 transition hover:-translate-y-2 dark:border-slate-700/80 dark:bg-slate-900 dark:text-slate-100">
                <p class="text-4xl font-bold text-emerald-500"><?php echo e($availableDonors); ?></p>
                <p class="mt-3 text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Available Donors</p>
            </article>

            <article class="rounded-3xl border border-slate-200/80 bg-white p-8 shadow-lg shadow-slate-900/5 transition hover:-translate-y-2 dark:border-slate-700/80 dark:bg-slate-900 dark:text-slate-100">
                <p class="text-4xl font-bold text-rose-500"><?php echo e($emergencyRequests); ?></p>
                <p class="mt-3 text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Emergency Requests</p>
            </article>

            <article class="rounded-3xl border border-slate-200/80 bg-white p-8 shadow-lg shadow-slate-900/5 transition hover:-translate-y-2 dark:border-slate-700/80 dark:bg-slate-900 dark:text-slate-100">
                <p class="text-4xl font-bold text-sky-500"><?php echo e($citiesCovered); ?></p>
                <p class="mt-3 text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Cities Covered</p>
            </article>
        </div>
    </div>
</section>

<section class="bg-white dark:bg-slate-950 py-20">
    <div class="container mx-auto px-6">
        <div class="max-w-3xl text-center mx-auto mb-16">
            <p class="text-sm uppercase tracking-[0.3em] text-red-600">About E-Blood</p>
            <h2 class="mt-4 text-4xl font-bold text-slate-900 dark:text-white">A modern blood donation platform built for every community.</h2>
            <p class="mt-5 text-base leading-8 text-slate-600 dark:text-slate-300">Our mission is to make blood donation fast, transparent, and safe. We bring real-time donor availability to patients, caregivers, and hospitals.</p>
        </div>

        <div class="grid gap-8 lg:grid-cols-3">
            <div class="rounded-3xl border border-slate-200/80 bg-slate-50 p-8 shadow-lg shadow-slate-900/5 transition hover:-translate-y-2 dark:border-slate-700/80 dark:bg-slate-900 dark:text-slate-100">
                <h3 class="text-xl font-semibold text-slate-900 dark:text-white">Why it works</h3>
                <p class="mt-4 text-slate-600 dark:text-slate-300">Donors and seekers connect in minutes, not days. Our system keeps availability accurate so urgent needs are met promptly.</p>
            </div>
            <div class="rounded-3xl border border-slate-200/80 bg-slate-50 p-8 shadow-lg shadow-slate-900/5 transition hover:-translate-y-2 dark:border-slate-700/80 dark:bg-slate-900 dark:text-slate-100">
                <h3 class="text-xl font-semibold text-slate-900 dark:text-white">How it works</h3>
                <p class="mt-4 text-slate-600 dark:text-slate-300">Donors sign up once and update availability. Patients search donors by blood group, city, and availability.</p>
            </div>
            <div class="rounded-3xl border border-slate-200/80 bg-slate-50 p-8 shadow-lg shadow-slate-900/5 transition hover:-translate-y-2 dark:border-slate-700/80 dark:bg-slate-900 dark:text-slate-100">
                <h3 class="text-xl font-semibold text-slate-900 dark:text-white">Impact</h3>
                <p class="mt-4 text-slate-600 dark:text-slate-300">Every connection helps save a life. We make it easy to find support, give blood, and share recovery stories.</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-slate-100 dark:bg-slate-900 py-20">
    <div class="container mx-auto px-6">
        <div class="max-w-3xl text-center mx-auto mb-14">
            <span class="text-sm uppercase tracking-[0.3em] text-red-600">How it works</span>
            <h2 class="mt-4 text-4xl font-bold text-slate-900 dark:text-white">3 simple steps to save lives</h2>
        </div>

        <div class="grid gap-8 lg:grid-cols-3">
            <div class="group rounded-[2rem] border border-slate-200/80 bg-white p-8 text-center shadow-xl shadow-slate-900/5 transition hover:-translate-y-2 hover:border-red-300 dark:border-slate-700/80 dark:bg-slate-950 dark:text-slate-100">
                <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-3xl bg-red-500 text-white shadow-lg transition duration-300 group-hover:bg-red-600">
                    <span class="text-3xl font-bold">1</span>
                </div>
                <h3 class="text-xl font-semibold">Register as donor</h3>
                <p class="mt-4 text-slate-600 dark:text-slate-300">Create your profile, add your blood group, and share your availability.</p>
            </div>
            <div class="group rounded-[2rem] border border-slate-200/80 bg-white p-8 text-center shadow-xl shadow-slate-900/5 transition hover:-translate-y-2 hover:border-red-300 dark:border-slate-700/80 dark:bg-slate-950 dark:text-slate-100">
                <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-3xl bg-rose-500 text-white shadow-lg transition duration-300 group-hover:bg-rose-600">
                    <span class="text-3xl font-bold">2</span>
                </div>
                <h3 class="text-xl font-semibold">Search donors</h3>
                <p class="mt-4 text-slate-600 dark:text-slate-300">Find donors by blood group and city with instant availability filters.</p>
            </div>
            <div class="group rounded-[2rem] border border-slate-200/80 bg-white p-8 text-center shadow-xl shadow-slate-900/5 transition hover:-translate-y-2 hover:border-red-300 dark:border-slate-700/80 dark:bg-slate-950 dark:text-slate-100">
                <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-3xl bg-sky-500 text-white shadow-lg transition duration-300 group-hover:bg-sky-600">
                    <span class="text-3xl font-bold">3</span>
                </div>
                <h3 class="text-xl font-semibold">Contact and save lives</h3>
                <p class="mt-4 text-slate-600 dark:text-slate-300">Reach out to donors quickly, coordinate help, and support patients in need.</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-white dark:bg-slate-950 py-20">
    <div class="container mx-auto px-6">
        <div class="max-w-3xl text-center mx-auto mb-14">
            <span class="text-sm uppercase tracking-[0.3em] text-red-600">Blood groups</span>
            <h2 class="mt-4 text-4xl font-bold text-slate-900 dark:text-white">Find donors for every blood group</h2>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <?php $__currentLoopData = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="rounded-3xl border border-slate-200/80 bg-slate-50 p-6 text-center shadow-lg shadow-slate-900/5 transition hover:-translate-y-2 hover:border-red-300 dark:border-slate-700/80 dark:bg-slate-900 dark:text-slate-100">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-600 text-2xl font-bold text-white shadow-lg"><?php echo e($group); ?></div>
                    <p class="text-lg font-semibold">Blood Group <?php echo e($group); ?></p>
                    <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">Search and match donors fast.</p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<section class="bg-slate-100 dark:bg-slate-900 py-20">
    <div class="container mx-auto px-6">
        <div class="flex flex-col gap-10 lg:flex-row lg:items-center">
            <div class="flex-1 rounded-[2rem] bg-white p-10 shadow-2xl shadow-slate-900/10 dark:bg-slate-950 dark:border dark:border-slate-800">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white">Recent donors near you</h2>
                <p class="mt-4 text-slate-600 dark:text-slate-300">Browse the latest donor profiles verified for availability and city.</p>

                <div class="mt-8 space-y-5">
                    <?php $__currentLoopData = $recentDonors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center gap-4 rounded-3xl border border-slate-200/80 bg-slate-50 p-4 shadow-sm dark:border-slate-700/80 dark:bg-slate-900">
                            <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-red-600 text-xl font-bold text-white">
                                <?php if($donor->profile_image): ?>
                                    <img src="<?php echo e(asset('storage/profile_images/' . $donor->profile_image)); ?>" alt="<?php echo e($donor->name); ?>" class="h-16 w-16 rounded-3xl object-cover" />
                                <?php else: ?>
                                    <?php echo e(strtoupper(substr($donor->name, 0, 1))); ?>

                                <?php endif; ?>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-slate-900 dark:text-white"><?php echo e($donor->name); ?></p>
                                <p class="text-sm text-slate-500 dark:text-slate-400"><?php echo e($donor->city ?? 'Unknown city'); ?></p>
                            </div>
                            <div class="rounded-3xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-900 dark:bg-slate-800 dark:text-slate-100">
                                <?php echo e($donor->blood_group ?? 'N/A'); ?>

                            </div>
                            <span class="inline-flex items-center rounded-full px-3 py-2 text-xs font-semibold <?php echo e($donor->available === 'yes' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-200' : 'bg-slate-200 text-slate-700 dark:bg-slate-700/70 dark:text-slate-300'); ?>">
                                <?php echo e($donor->available === 'yes' ? 'Available' : 'Unavailable'); ?>

                            </span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="flex-1 rounded-[2rem] bg-gradient-to-br from-red-600 to-rose-500 p-10 text-white shadow-2xl shadow-rose-900/25">
                <h2 class="text-3xl font-bold">Patient stories</h2>
                <p class="mt-4 text-slate-100/90">Stories from donors and recipients who found hope through E-Blood.</p>
                <div class="mt-10 space-y-6">
                    <div class="rounded-3xl bg-white/10 p-6 shadow-lg shadow-black/10 backdrop-blur-xl">
                        <p class="text-sm uppercase tracking-[0.2em] text-rose-100">Donor experience</p>
                        <p class="mt-3 text-lg font-semibold">“I signed up and received a match in minutes. It felt amazing to help someone in need.”</p>
                        <p class="mt-4 text-sm text-rose-100/80">— Priya, donor</p>
                    </div>
                    <div class="rounded-3xl bg-white/10 p-6 shadow-lg shadow-black/10 backdrop-blur-xl">
                        <p class="text-sm uppercase tracking-[0.2em] text-rose-100">Patient feedback</p>
                        <p class="mt-3 text-lg font-semibold">“The donor search was fast and the support team helped coordinate everything smoothly.”</p>
                        <p class="mt-4 text-sm text-rose-100/80">— Ravi, patient family</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-gradient-to-r from-slate-900 via-red-700 to-rose-500 py-24 text-white">
    <div class="container mx-auto px-6 text-center">
        <div class="mx-auto max-w-3xl">
            <span class="inline-flex rounded-full bg-white/10 px-4 py-2 text-sm uppercase tracking-[0.3em] text-white/80">Ready to help?</span>
            <h2 class="mt-6 text-4xl font-extrabold sm:text-5xl">Become a Blood Donor Today</h2>
            <p class="mx-auto mt-5 max-w-2xl text-base leading-8 text-white/80">Register, search donors, and support emergency patients across your city.</p>
            <div class="mt-10 flex flex-col justify-center gap-4 sm:flex-row sm:items-center sm:justify-center">
                <a href="/register" class="inline-flex items-center justify-center rounded-full bg-white px-8 py-4 text-base font-semibold text-red-700 shadow-xl shadow-black/20 transition hover:-translate-y-1 hover:bg-red-50">Register</a>
                <a href="/search" class="inline-flex items-center justify-center rounded-full border border-white/30 bg-white/10 px-8 py-4 text-base font-semibold text-white transition hover:-translate-y-1 hover:bg-white/20">Search Donors</a>
            </div>
        </div>
    </div>
</section>

<section class="bg-slate-950 py-14 text-slate-200">
    <div class="container mx-auto px-6">
        <div class="grid gap-10 lg:grid-cols-3">
            <div class="space-y-4">
                <h3 class="text-xl font-semibold text-white">E-Blood Donation</h3>
                <p class="leading-7 text-slate-400">Trusted platform for emergency support, donor matching, and community care.</p>
            </div>
            <div>
                <h4 class="text-sm uppercase tracking-[0.3em] text-rose-400">Quick Links</h4>
                <ul class="mt-6 space-y-3 text-slate-400">
                    <li><a href="/" class="transition hover:text-white">Home</a></li>
                    <li><a href="/search" class="transition hover:text-white">Search Donors</a></li>
                    <li><a href="/register" class="transition hover:text-white">Register</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-sm uppercase tracking-[0.3em] text-rose-400">Contact</h4>
                <p class="mt-6 text-slate-400">support@eblood.com</p>
                <p class="mt-2 text-slate-400">Punjab, India</p>
                <div class="mt-6 flex items-center gap-4 text-slate-400">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/5 transition hover:bg-white/10">T</span>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/5 transition hover:bg-white/10">F</span>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/5 transition hover:bg-white/10">I</span>
                </div>
            </div>
        </div>

        <div class="mt-10 border-t border-white/10 pt-8 text-center text-sm text-slate-500">© <?php echo e(date('Y')); ?> E-Blood Donation Platform. Donate blood, be someone’s hero.</div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views/home.blade.php ENDPATH**/ ?>