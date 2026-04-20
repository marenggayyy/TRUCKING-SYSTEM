<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

    <div class="row align-items-start g-4">

        
        <div class="col-lg-8">
            <div class="d-flex flex-column gap-3">

                
                <div class="card">
                    <div class="card-body pb-xxl-0">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-2 row-cols-xxl-4 g-3">

                            
                            <div class="col">
                                <div class="card mb-xxl-0 iq-purchase" data-iq-gsap="onStart" data-iq-position-y="50"
                                    data-iq-rotate="0" data-iq-trigger="scroll" data-iq-ease="power.out"
                                    data-iq-opacity="0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <h5 class="text-primary mb-0">Trucks</h5>
                                            <a href="<?php echo e(route('owner.trucks.index')); ?>">
                                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M15.1609 12.5531C15.1609 14.2991 13.7449 15.7141 11.9989 15.7141C10.2529 15.7141 8.83789 14.2991 8.83789 12.5531C8.83789 10.8061 10.2529 9.39108 11.9989 9.39108C13.7449 9.39108 15.1609 10.8061 15.1609 12.5531Z"
                                                        stroke="#7B60E7" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M11.998 19.8549C15.806 19.8549 19.289 17.1169 21.25 12.5529C19.289 7.98888 15.806 5.25089 11.998 5.25089H12.002C8.194 5.25089 4.711 7.98888 2.75 12.5529C4.711 17.1169 8.194 19.8549 12.002 19.8549H11.998Z"
                                                        stroke="#7B60E7" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h3 class="mb-0"><?php echo e($trucksStats['total'] ?? 0); ?></h3>
                                            <p class="mb-0 ms-2 text-muted"><?php echo e($trucksStats['active'] ?? 0); ?> active</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="col">
                                <div class="card mb-xxl-0 iq-purchase" data-iq-gsap="onStart" data-iq-position-y="150"
                                    data-iq-rotate="0" data-iq-trigger="scroll" data-iq-ease="power.out"
                                    data-iq-opacity="0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <h5 class="text-primary mb-0">Drivers</h5>
                                            <a href="<?php echo e(route('owner.drivers.index')); ?>">
                                                <svg width="16" height="21" viewBox="0 0 16 21" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M7.98493 13.8462C4.11731 13.8462 0.814453 14.431 0.814453 16.7729C0.814453 19.1148 4.09636 19.7205 7.98493 19.7205C11.8525 19.7205 15.1545 19.1348 15.1545 16.7938C15.1545 14.4529 11.8735 13.8462 7.98493 13.8462Z"
                                                        stroke="#7B60E7" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M7.98489 10.5059C10.523 10.5059 12.5801 8.44782 12.5801 5.90972C12.5801 3.37163 10.523 1.31448 7.98489 1.31448C5.44679 1.31448 3.3887 3.37163 3.3887 5.90972C3.38013 8.43925 5.42394 10.4973 7.95251 10.5059H7.98489Z"
                                                        stroke="#7B60E7" stroke-width="1.42857" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h3 class="mb-0"><?php echo e($driversStats['total'] ?? 0); ?></h3>
                                            <p class="mb-0 ms-2 text-muted"><?php echo e($driversStats['active'] ?? 0); ?> active</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="col">
                                <div class="card iq-purchase" data-iq-gsap="onStart" data-iq-position-y="250"
                                    data-iq-rotate="0" data-iq-trigger="scroll" data-iq-ease="power.out"
                                    data-iq-opacity="0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <h5 class="text-primary mb-0">Destinations</h5>
                                            <a href="<?php echo e(route('owner.destinations.index')); ?>">
                                                <svg width="17" height="13" viewBox="0 0 17 13" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 6.49905L6.0014 11.4984L16 1.49976" stroke="#7B60E7"
                                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    </path>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h3 class="mb-0"><?php echo e($destinationsStats['total'] ?? 0); ?></h3>
                                            <p class="mb-0 ms-2">Avg:
                                                ₱<?php echo e(number_format($destinationsStats['avg_rate'], 2)); ?></p>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="col">
                                <div class="card iq-purchase" data-iq-gsap="onStart" data-iq-position-y="350"
                                    data-iq-rotate="0" data-iq-trigger="scroll" data-iq-ease="power.out"
                                    data-iq-opacity="0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <h5 class="text-primary mb-0">Trips</h5>
                                            <a href="<?php echo e(route('owner.trips.index')); ?>">
                                                <svg width="15" height="13" viewBox="0 0 15 17"
                                                    fill="currentcolor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M7.72461 0.75L7.72461 15.75" stroke="currentcolor"
                                                        stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                    <path d="M1.701 6.7998L7.725 0.749804L13.75 6.7998"
                                                        stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h3 class="mb-0"><?php echo e($tripsStats['total'] ?? 0); ?></h3>
                                            <p class="mb-0 ms-2 text-muted"><?php echo e($tripsStats['completed'] ?? 0); ?> done</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        
                        <div class="card-body pt-3 iq-services">
                            <div class="card-group border rounded-1">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <p class="mb-0">Today</p>
                                            <span class="badge bg-soft-success text-dark">
                                                <?php echo e($todayData['dispatched'] ?? 0); ?>

                                            </span>
                                        </div>
                                        <h5
                                            class="mb-1 
    <?php echo e($todayData['profit'] >= 0 ? 'text-success' : 'text-danger'); ?>">
                                            ₱<?php echo e(number_format($todayData['profit'] ?? 0, 2)); ?>

                                        </h5>
                                        <p class="small text-muted mb-0">Trips Dispatched Today</p>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <p class="mb-0">This week</p>
                                            <span class="badge bg-soft-info text-dark">
                                                <?php echo e($weekData['dispatched'] ?? 0); ?>

                                            </span>
                                        </div>
                                        <h5 class="mb-1">₱<?php echo e(number_format($weekData['gains'] ?? 0, 2)); ?></h5>
                                        <p class="small text-muted mb-0">Trips Dispatched This Week</p>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <p class="mb-0">Net Profit</p>
                                            <span class="badge bg-soft-success text-dark">✓</span>
                                        </div>
                                        <h5 class="mb-1">₱<?php echo e(number_format($todayData['profit'] ?? 0, 2)); ?></h5>
                                        <p class="small text-muted mb-0">Today's Net Profit</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                
                <div class="card" data-iq-gsap="onStart" data-iq-position-y="70" data-iq-rotate="0"
                    data-iq-trigger="scroll" data-iq-ease="power.out" data-iq-opacity="0">
                    <div class="card-header justify-content-between d-flex align-items-center">
                        <h4 class="card-title fw-bolder mb-0">Active Trips</h4>
                        <a href="<?php echo e(route('owner.trips.index')); ?>" class="btn btn-primary btn-sm">View All</a>
                    </div>

                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                            <?php $__empty_1 = true; $__currentLoopData = $activeTrips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="col">
                                    <div class="card border h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <span class="badge bg-success">In Transit</span>
                                                <small class="text-muted">
                                                    <?php echo e($trip->dispatch_date ? \Carbon\Carbon::parse($trip->dispatch_date)->format('M d') : '—'); ?>

                                                </small>
                                            </div>

                                            <h6 class="card-title mb-2"><?php echo e($trip->trip_ticket_no ?? 'N/A'); ?></h6>

                                            <p class="mb-1 small">
                                                <strong>Destination:</strong>
                                                <?php echo e($trip->destination?->store_name ?? 'N/A'); ?>

                                            </p>

                                            <p class="mb-2 small">
                                                <strong>Truck:</strong> <?php echo e($trip->truck?->plate_number ?? 'N/A'); ?>

                                            </p>

                                            <p class="mb-3 small text-muted fst-italic">
                                                <?php echo e($trip->driver?->name ?? '—'); ?>

                                            </p>

                                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                                <span class="small text-muted">Status</span>
                                                <span class="fw-bold text-success"><?php echo e($trip->status ?? '—'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="col-12">
                                    <p class="text-muted text-center py-4 mb-0">
                                        No active trips.
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div class="card" data-iq-gsap="onStart" data-iq-position-y="70" data-iq-rotate="0"
                    data-iq-trigger="scroll" data-iq-ease="power.out" data-iq-opacity="0">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title fw-bolder mb-0">High-Value Destinations</h4>
                        <a href="<?php echo e(route('owner.destinations.index')); ?>" class="btn btn-primary btn-sm">View all</a>
                    </div>

                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                            <?php $__empty_1 = true; $__currentLoopData = $topDestinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $destination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="col">
                                    <div class="card border h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <span class="badge bg-success">High Rate</span>
                                                <small class="text-muted"><?php echo e($destination->truck_type ?? '—'); ?></small>
                                            </div>
                                            <h6 class="card-title mb-2"><?php echo e($destination->store_name ?? 'N/A'); ?></h6>
                                            <p class="mb-1 small"><strong>Code:</strong>
                                                <?php echo e($destination->store_code ?? '—'); ?></p>
                                            <p class="mb-2 small"><strong>Area:</strong> <?php echo e($destination->area ?? '—'); ?>

                                            </p>

                                            <?php if(!empty($destination->remarks)): ?>
                                                <p class="mb-3 small text-muted fst-italic"><?php echo e($destination->remarks); ?>

                                                </p>
                                            <?php endif; ?>

                                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                                <span class="small text-muted">Rate</span>
                                                <span
                                                    class="fw-bold text-success">₱<?php echo e(number_format($destination->rate ?? 0, 2)); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="col-12">
                                    <p class="text-muted text-center py-4 mb-0">No destinations available</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-3">

                
                <div class="card bg-primary text-center text-white iq-post" data-iq-gsap="onStart"
                    data-iq-position-y="70" data-iq-rotate="0" data-iq-trigger="scroll" data-iq-ease="power.out"
                    data-iq-opacity="0">
                    <div class="card-body">
                        <h5 class="mb-3 text-white">Financial Summary</h5>
                        <div class="row g-3">
                            <div class="col-6">
                                <p class="mb-1 small text-white-50">Total Gains</p>
                                <h5 class="fw-bolder text-white mb-0" data-bs-toggle="tooltip" data-bs-html="true"
                                    style="cursor:pointer;"
                                    title="
        Billed: ₱<?php echo e(number_format($financialData['gains_billed'] ?? 0, 2)); ?> <br>
        Unbilled: ₱<?php echo e(number_format($financialData['gains_unbilled'] ?? 0, 2)); ?> <br>
        Pending: ₱<?php echo e(number_format($financialData['gains_pending'] ?? 0, 2)); ?>

    ">
                                    ₱<?php echo e(number_format($financialData['gains'] ?? 0, 2)); ?>

                                </h5>
                            </div>
                            <div class="col-6">
                                <p class="mb-1 small text-white-50">Expenses</p>
                                <h5 class="fw-bolder text-danger mb-0" data-bs-toggle="tooltip" data-bs-html="true"
                                    title="
        Fuel: ₱<?php echo e(number_format($financialData['fuel'] ?? 0, 2)); ?> <br>
        Payroll: ₱<?php echo e(number_format($financialData['payroll'] ?? 0, 2)); ?>

    ">
                                    ₱<?php echo e(number_format($financialData['expenses'] ?? 0, 2)); ?>

                                </h5>
                            </div>
                            <div class="col-12">
                                <hr class="border-white-50 my-2">
                                <p class="mb-1 small text-white-50">Net Profit</p>
                                <h4 class="fw-bolder text-success mb-0">
                                    ₱<?php echo e(number_format($financialData['profit'] ?? 0, 2)); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card" data-iq-gsap="onStart" data-iq-position-y="70" data-iq-rotate="0"
                    data-iq-trigger="scroll" data-iq-ease="power.out" data-iq-opacity="0">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title fw-bolder mb-0">Recent Trips</h4>
                        <a href="<?php echo e(route('owner.trips.history')); ?>" class="btn btn-primary btn-sm"> View All </a>
                    </div>

                    <div class="card-body">
                        <?php $__empty_1 = true; $__currentLoopData = $recentTrips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div
                                class="d-flex justify-content-between align-items-center flex-wrap py-3 <?php if(!$loop->last): ?> border-bottom <?php endif; ?>">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0"><?php echo e($trip->trip_ticket_no ?? 'N/A'); ?></h6>
                                    <span
                                        class="text-muted small"><?php echo e($trip->destination?->store_name ?? 'No destination'); ?></span>
                                </div>

                                <div class="text-end">
                                    <span
                                        class="badge bg-<?php if(($trip->status ?? '') === 'Completed'): ?> success <?php elseif(($trip->status ?? '') === 'Dispatched'): ?> warning <?php else: ?> secondary <?php endif; ?>">
                                        <?php echo e($trip->status ?? '—'); ?>

                                    </span>

                                    <p class="mb-0 small text-muted mt-1">
                                        <?php echo e($trip->dispatch_date ? \Carbon\Carbon::parse($trip->dispatch_date)->format('M d, Y') : '—'); ?>

                                    </p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-muted text-center py-4 mb-0">No trips yet</p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(function(el) {
                return new bootstrap.Tooltip(el)
            })
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.owner', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HF-PC\Downloads\last zip\laravel_app\resources\views/dashboard.blade.php ENDPATH**/ ?>