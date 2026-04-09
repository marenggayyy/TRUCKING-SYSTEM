

<?php $__env->startSection('title', 'Drivers & Crew'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">

        
        <div class="ui-hero p-4 mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <h4 class="mb-1 fw-bold">Drivers & Crew</h4>
                    <div class="text-muted small">
                        Availability, performance, and risk overview.
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row g-3 mb-1">

            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card ui-available-card border-bottom border-4 border-0 border-primary"
                    style="margin-bottom:10px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small fw-semibold">
                                Total Drivers 👤
                            </div>
                            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                <div class="ui-available-number text-primary">
                                    <?php echo e($drivers->count() ?? ($stats['total_drivers'] ?? 0)); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card ui-available-card border-bottom border-4 border-0 border-info" style="margin-bottom:10px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small fw-semibold">
                                Total Helpers 👷
                            </div>
                            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                <div class="ui-available-number text-info">
                                    <?php echo e($helpers->count() ?? ($stats['total_helpers'] ?? 0)); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card ui-available-card border-bottom border-4 border-0 border-info" style="margin-bottom:10px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small fw-semibold">
                                On Leave 🏖️
                            </div>
                            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                <div class="ui-available-number text-info">
                                    <?php echo e($stats['on_leave'] ?? 0); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card ui-available-card border-bottom border-4 border-0 border-danger"
                    style="margin-bottom:10px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small fw-semibold">
                                Inactive ⛔
                            </div>
                            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                <div class="ui-available-number text-danger">
                                    <?php echo e($stats['inactive'] ?? 0); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card ui-available-card border-bottom border-4 border-0 border-success"
                    style="margin-bottom:10px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small fw-semibold">
                                Driver Available ✅
                            </div>

                            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                <div class="ui-available-number text-success">
                                    <?php echo e($availableDrivers->count() ?? 0); ?>

                                </div>

                                <button type="button" class="btn btn-sm ui-eye-btn" data-bs-target="#availDriversList"
                                    aria-controls="availDriversList" aria-expanded="false">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="collapse mt-0 ui-available-dropdown" id="availDriversList">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-2">

                            <div class="ui-paginated-list" data-per-page="5" data-target="drivers">
                                <?php $__empty_1 = true; $__currentLoopData = $availableDrivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="ui-list-item py-1 small"><?php echo e($dr->name); ?></div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="text-muted small">No available drivers.</div>
                                <?php endif; ?>
                            </div>

                            <?php if(($availableDrivers->count() ?? 0) > 5): ?>
                                <div class="d-flex justify-content-end align-items-center gap-2 mt-2 ui-list-controls"
                                    data-controls="drivers">
                                    <button type="button" class="btn btn-sm btn-light ui-list-prev">Prev</button>
                                    <div class="small text-muted ui-list-page">1</div>
                                    <button type="button" class="btn btn-sm btn-light ui-list-next">Next</button>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card ui-available-card border-bottom border-4 border-0 border-primary"
                    style="margin-bottom:10px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small fw-semibold">
                                On Trip Drivers 🚚
                            </div>

                            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                <div class="ui-available-number text-primary">
                                    <?php echo e($onTripDrivers->count() ?? ($stats['on_trip_drivers'] ?? 0)); ?>

                                </div>

                                <button type="button" class="btn btn-sm ui-eye-btn" data-bs-target="#onTripDriversList"
                                    aria-controls="onTripDriversList" aria-expanded="false">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="collapse mt-0 ui-available-dropdown" id="onTripDriversList">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-2">

                            <div class="ui-paginated-list" data-per-page="5" data-target="ontripdrivers">
                                <?php $__empty_1 = true; $__currentLoopData = ($onTripDrivers ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="ui-list-item py-1 small"><?php echo e($dr->name); ?></div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="text-muted small">No on-trip drivers.</div>
                                <?php endif; ?>
                            </div>

                            <?php if(($onTripDrivers->count() ?? 0) > 5): ?>
                                <div class="d-flex justify-content-end align-items-center gap-2 mt-2 ui-list-controls"
                                    data-controls="ontripdrivers">
                                    <button type="button" class="btn btn-sm btn-light ui-list-prev">Prev</button>
                                    <div class="small text-muted ui-list-page">1</div>
                                    <button type="button" class="btn btn-sm btn-light ui-list-next">Next</button>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card ui-available-card border-bottom border-4 border-0 border-warning"
                    style="margin-bottom:10px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small fw-semibold">
                                Helper Available ✅
                            </div>

                            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                <div class="ui-available-number text-warning">
                                    <?php echo e($availableHelpers->count() ?? 0); ?>

                                </div>

                                
                                <button type="button" class="btn btn-sm ui-eye-btn" data-bs-target="#availHelpersList"
                                    aria-controls="availHelpersList" aria-expanded="false">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="collapse mt-0 ui-available-dropdown" id="availHelpersList">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-2">
                            <div class="ui-paginated-list" data-per-page="5" data-target="helpers">
                                <?php $__empty_1 = true; $__currentLoopData = $availableHelpers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="ui-list-item py-1 small"><?php echo e($h->name); ?></div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="text-muted small">No available helpers.</div>
                                <?php endif; ?>
                            </div>

                            <?php if(($availableHelpers->count() ?? 0) > 5): ?>
                                <div class="d-flex justify-content-end align-items-center gap-2 mt-2 ui-list-controls"
                                    data-controls="helpers">
                                    <button type="button" class="btn btn-sm btn-light ui-list-prev">Prev</button>
                                    <div class="small text-muted ui-list-page">1</div>
                                    <button type="button" class="btn btn-sm btn-light ui-list-next">Next</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card ui-available-card border-bottom border-4 border-0 border-warning"
                    style="margin-bottom:10px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small fw-semibold">
                                On Trip Helpers 🚚
                            </div>

                            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                <div class="ui-available-number text-warning">
                                    <?php echo e($onTripHelpers->count() ?? ($stats['on_trip_helpers'] ?? 0)); ?>

                                </div>

                                <button type="button" class="btn btn-sm ui-eye-btn" data-bs-target="#onTripHelpersList"
                                    aria-controls="onTripHelpersList" aria-expanded="false">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="collapse mt-0 ui-available-dropdown" id="onTripHelpersList">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-2">

                            <div class="ui-paginated-list" data-per-page="5" data-target="ontriphelpers">
                                <?php $__empty_1 = true; $__currentLoopData = ($onTripHelpers ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="ui-list-item py-1 small"><?php echo e($h->name); ?></div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="text-muted small">No on-trip helpers.</div>
                                <?php endif; ?>
                            </div>

                            <?php if(($onTripHelpers->count() ?? 0) > 5): ?>
                                <div class="d-flex justify-content-end align-items-center gap-2 mt-2 ui-list-controls"
                                    data-controls="ontriphelpers">
                                    <button type="button" class="btn btn-sm btn-light ui-list-prev">Prev</button>
                                    <div class="small text-muted ui-list-page">1</div>
                                    <button type="button" class="btn btn-sm btn-light ui-list-next">Next</button>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0">
                <div class="ui-people-header">
                    <div class="ui-people-title-wrap">
                        <h5 class="mb-0 fw-bold ui-people-title">Drivers &amp; Helpers</h5>
                    </div>

                    <div class="ui-people-actions">
                        
                        <div class="ui-people-search">
                            <i class="bi bi-search ui-people-search-icon"></i>
                            <input type="text" id="peopleSearchInput" class="form-control ui-people-search-input"
                                placeholder="Search drivers/helpers...">
                        </div>

                        <button class="btn btn-sm btn-primary ui-people-btn ui-people-btn--add" data-bs-toggle="modal"
                            data-bs-target="#addPersonModal">
                            ➕ Add
                        </button>

                        <form id="bulkDeletePeopleForm" method="POST" action="<?php echo e(route('owner.people.bulkDestroy')); ?>"
                            class="m-0">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

                            <input type="hidden" name="driver_ids" id="bulkDriverIds" value="">
                            <input type="hidden" name="helper_ids" id="bulkHelperIds" value="">

                            <button type="submit" class="btn btn-sm btn-outline-danger ui-people-btn ui-people-btn--icon"
                                id="bulkDeletePeopleBtn" disabled onclick="return confirm('Delete selected records?')"
                                title="Delete selected">
                                🗑️
                            </button>
                        </form>
                    </div>
                </div>

                
                <div class="modal fade" id="addPersonModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">Add Driver / Helper</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form method="POST" id="addPersonForm" action="<?php echo e(route('owner.drivers.store')); ?>"
                                enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Type</label>
                                        <select name="type" id="personType" class="form-select" required>
                                            <option value="">-- Select --</option>
                                            <option value="driver">Driver</option>
                                            <option value="helper">Helper</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Profile Picture</label>
                                        <input type="file" name="profile_photo" class="form-control"
                                            accept="image/*">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            placeholder="example@email.com">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select" required>
                                            <option value="active">Active</option>
                                            <option value="on-leave">On Leave</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="card-body" style= "padding-right: 0; padding-left: 0; ">

                    
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-drivers"
                                type="button">
                                <span class="d-inline d-lg-none">👨‍✈️ D</span>
                                <span class="d-none d-lg-inline">👨‍✈️ Drivers</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-helpers" type="button">
                                <span class="d-inline d-lg-none">👷 H</span>
                                <span class="d-none d-lg-inline">👷 Helpers</span>
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">

                        
                        <div class="tab-pane fade show active" id="tab-drivers">

                            
                            <div class="d-block d-lg-none">
                                <?php $__empty_1 = true; $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $a = $driver->status;

                                        if ($driver->status === 'inactive') {
                                            $a = 'unavailable';
                                        }

                                        $availabilityLabel = match ($a) {
                                            'on_trip' => 'On Trip',
                                            'inactive' => 'Unavailable',
                                            default => 'Available',
                                        };
                                    ?>

                                    <div class="card border-0 shadow-sm mb-3 ui-mobile-person ui-mobile-person--centered">
                                        <div class="card-body">

                                            
                                            <div class="ui-person-top">
                                                <img src="<?php echo e($driver->profile_photo ? asset('storage/' . $driver->profile_photo) : asset('assets/images/page-img/14.png')); ?>"
                                                    class="ui-person-avatar-lg" alt="avatar">
                                            </div>

                                            
                                            <div class="ui-person-head">
                                                <div class="ui-person-name"><?php echo e($driver->name); ?></div>
                                                <div class="ui-person-email"><?php echo e($driver->email ?? '—'); ?></div>
                                            </div>

                                            
                                            <div class="ui-person-meta-list">

                                                <div class="ui-meta-line">
                                                    <span class="ui-meta-label">Status</span>

                                                    <?php
                                                        $displayStatus = $driver->status;
                                                        $badgeClass = 'bg-secondary';
                                                        if ($driver->status === 'active') {
                                                            if ($driver->availability_status === 'on_trip') {
                                                                $displayStatus = 'On Trip';
                                                                $badgeClass = 'bg-warning';
                                                            } elseif ($driver->availability_status === 'on_leave') {
                                                                $displayStatus = 'On Leave';
                                                                $badgeClass = 'bg-info';
                                                            } else {
                                                                $displayStatus = 'Available';
                                                                $badgeClass = 'bg-success';
                                                            }
                                                        } elseif ($driver->status === 'inactive') {
                                                            $displayStatus = 'Inactive';
                                                            $badgeClass = 'bg-secondary';
                                                        } elseif ($driver->status === 'on-leave') {
                                                            $displayStatus = 'On Leave';
                                                            $badgeClass = 'bg-info';
                                                        } elseif ($driver->status === 'on_trip') {
                                                            $displayStatus = 'On Trip';
                                                            $badgeClass = 'bg-warning';
                                                        }
                                                    ?>

                                                    <span class="badge <?php echo e($badgeClass); ?>">
                                                        <?php echo e($displayStatus); ?>

                                                    </span>
                                                </div>

                                                <div class="ui-meta-line">
                                                    <span class="ui-meta-label">Availability</span>

                                                    <?php
                                                        $availabilityBadge = match ($a) {
                                                            'on_trip' => 'bg-primary',
                                                            'inactive' => 'bg-danger',
                                                            default => 'bg-success',
                                                        };
                                                    ?>

                                                    <span class="badge <?php echo e($availabilityBadge); ?>">
                                                        <?php echo e($availabilityLabel); ?>

                                                    </span>
                                                </div>

                                            </div>

                                            
                                            <div class="ui-person-actions">

                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editDriverModal-<?php echo e($driver->id); ?>">
                                                    ✏️
                                                </button>

                                                <button class="btn btn-sm btn-info driver-docs-btn" data-bs-toggle="modal"
                                                    data-bs-target="#personDocsModal" data-type="driver"
                                                    data-id="<?php echo e($driver->id); ?>" data-name="<?php echo e($driver->name); ?>">
                                                    📄
                                                </button>
                                            </div>

                                        </div>
                                    </div>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="text-center py-5">
                                        <div class="text-muted mb-2"><i class="bi bi-person fs-3"></i></div>
                                        <div class="fw-semibold">No drivers found</div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            
                            <div class="d-none d-lg-block">
                                <div class="table-responsive">
                                    <table class="table table-striped align-middle">
                                        <thead>
                                            <tr>
                                                <th style="width:40px;">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="selectAllDrivers">
                                                </th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Availability</th>
                                                <th style="width: 120px;">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <?php
                                                    // Status badge
                                                    $statusBadge = 'bg-secondary';
                                                    $statusLabel = ucfirst($driver->status);
                                                    if ($driver->status === 'active') {
                                                        $statusBadge = 'bg-success';
                                                        $statusLabel = 'Active';
                                                    } elseif ($driver->status === 'inactive') {
                                                        $statusBadge = 'bg-secondary';
                                                        $statusLabel = 'Inactive';
                                                    } elseif ($driver->status === 'on-leave') {
                                                        $statusBadge = 'bg-info';
                                                        $statusLabel = 'On Leave';
                                                    } elseif ($driver->status === 'on_trip') {
                                                        $statusBadge = 'bg-warning';
                                                        $statusLabel = 'On Trip';
                                                    }

                                                    // Availability badge
                                                    $availBadge = 'bg-success';
                                                    $availLabel = 'Available';
                                                    if ($driver->availability_status === 'on_trip') {
                                                        $availBadge = 'bg-warning';
                                                        $availLabel = 'On Trip';
                                                    } elseif ($driver->availability_status === 'on_leave') {
                                                        $availBadge = 'bg-info';
                                                        $availLabel = 'On Leave';
                                                    } elseif ($driver->availability_status === 'unavailable') {
                                                        $availBadge = 'bg-danger';
                                                        $availLabel = 'Unavailable';
                                                    }
                                                ?>

                                                <tr>
                                                    <td>
                                                        <input class="form-check-input driver-check" type="checkbox"
                                                            value="<?php echo e($driver->id); ?>">
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <img src="<?php echo e($driver->profile_photo ? asset('storage/' . $driver->profile_photo) : asset('assets/images/page-img/14.png')); ?>"
                                                                style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                                                            <span><?php echo e($driver->name); ?></span>
                                                        </div>
                                                    </td>
                                                    <td class="text-muted"><?php echo e($driver->email ?? '-'); ?></td>
                                                    <td>
                                                        <span
                                                            class="badge <?php echo e($statusBadge); ?>"><?php echo e($statusLabel); ?></span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge <?php echo e($availBadge); ?>"><?php echo e($availLabel); ?></span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-1">

                                                            
                                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                                data-bs-target="#editDriverModal-<?php echo e($driver->id); ?>">
                                                                ✏️
                                                            </button>

                                                            
                                                            <button class="btn btn-sm btn-info driver-docs-btn"
                                                                data-bs-toggle="modal" data-bs-target="#personDocsModal"
                                                                data-type="driver" data-id="<?php echo e($driver->id); ?>"
                                                                data-name="<?php echo e($driver->name); ?>">
                                                                📄
                                                            </button>

                                                        </div>
                                                    </td>
                                                </tr>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">No drivers found.
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        
                        <div class="tab-pane fade" id="tab-helpers">

                            
                            <div class="d-block d-lg-none">
                                <?php $__empty_1 = true; $__currentLoopData = $helpers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $helper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $displayStatus = $helper->status;
                                        $badgeClass = 'bg-secondary';
                                        if ($helper->status === 'active') {
                                            if ($helper->availability_status === 'on_trip') {
                                                $displayStatus = 'On Trip';
                                                $badgeClass = 'bg-warning';
                                            } elseif ($helper->availability_status === 'on_leave') {
                                                $displayStatus = 'On Leave';
                                                $badgeClass = 'bg-info';
                                            } else {
                                                $displayStatus = 'Available';
                                                $badgeClass = 'bg-success';
                                            }
                                        } elseif ($helper->status === 'inactive') {
                                            $displayStatus = 'Inactive';
                                            $badgeClass = 'bg-secondary';
                                        } elseif ($helper->status === 'on-leave') {
                                            $displayStatus = 'On Leave';
                                            $badgeClass = 'bg-info';
                                        } elseif ($helper->status === 'on_trip') {
                                            $displayStatus = 'On Trip';
                                            $badgeClass = 'bg-warning';
                                        }
                                    ?>

                                    <div class="card border-0 shadow-sm mb-3 ui-mobile-person ui-mobile-person--centered">
                                        <div class="card-body">

                                            
                                            <div class="ui-person-top">
                                                <img src="<?php echo e($helper->profile_photo ? asset('storage/' . $helper->profile_photo) : asset('assets/images/page-img/14.png')); ?>"
                                                    class="ui-person-avatar-lg" alt="avatar">
                                            </div>

                                            
                                            <div class="ui-person-head">
                                                <div class="ui-person-name"><?php echo e($helper->name); ?></div>
                                                <div class="ui-person-email"><?php echo e($helper->email ?? '—'); ?></div>
                                            </div>

                                            
                                            <div class="ui-person-meta-list">

                                                <div class="ui-meta-line">
                                                    <span class="ui-meta-label">Status</span>

                                                    <span class="badge <?php echo e($badgeClass); ?>">
                                                        <?php echo e($displayStatus); ?>

                                                    </span>
                                                </div>

                                                <div class="ui-meta-line">
                                                    <span class="ui-meta-label">Availability</span>

                                                    <span class="badge <?php echo e($availBadge); ?>">
                                                        <?php echo e($availLabel); ?>

                                                    </span>
                                                </div>

                                            </div>

                                            
                                            <div class="ui-person-actions">
                                                
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editHelperModal-<?php echo e($helper->id); ?>">
                                                    ✏️
                                                </button>

                                                
                                                <button class="btn btn-sm btn-info helper-docs-btn" data-bs-toggle="modal"
                                                    data-bs-target="#personDocsModal" data-type="helper"
                                                    data-id="<?php echo e($helper->id); ?>" data-name="<?php echo e($helper->name); ?>">
                                                    📄
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="text-center py-5">
                                        <div class="text-muted mb-2"><i class="bi bi-person fs-3"></i></div>
                                        <div class="fw-semibold">No helpers found</div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            
                            <div class="d-none d-lg-block">
                                <div class="table-responsive">
                                    <table class="table table-striped align-middle">
                                        <thead>
                                            <tr>
                                                <th style="width:40px;">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="selectAllHelpers">
                                                </th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Availability</th>
                                                <th style="width: 120px;">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $helpers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $helper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <?php
                                                    // Status badge
                                                    $statusBadge = 'bg-secondary';
                                                    $statusLabel = ucfirst($helper->status);
                                                    if ($helper->status === 'active') {
                                                        $statusBadge = 'bg-success';
                                                        $statusLabel = 'Active';
                                                    } elseif ($helper->status === 'inactive') {
                                                        $statusBadge = 'bg-secondary';
                                                        $statusLabel = 'Inactive';
                                                    } elseif ($helper->status === 'on-leave') {
                                                        $statusBadge = 'bg-info';
                                                        $statusLabel = 'On Leave';
                                                    } elseif ($helper->status === 'on_trip') {
                                                        $statusBadge = 'bg-warning';
                                                        $statusLabel = 'On Trip';
                                                    }

                                                    // Availability badge
                                                    $availBadge = 'bg-success';
                                                    $availLabel = 'Available';
                                                    if ($helper->availability_status === 'on_trip') {
                                                        $availBadge = 'bg-warning';
                                                        $availLabel = 'On Trip';
                                                    } elseif ($helper->availability_status === 'on_leave') {
                                                        $availBadge = 'bg-info';
                                                        $availLabel = 'On Leave';
                                                    } elseif ($helper->availability_status === 'unavailable') {
                                                        $availBadge = 'bg-danger';
                                                        $availLabel = 'Unavailable';
                                                    }
                                                ?>

                                                <tr>
                                                    <td>
                                                        <input class="form-check-input helper-check" type="checkbox"
                                                            value="<?php echo e($helper->id); ?>">
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <img src="<?php echo e($helper->profile_photo ? asset('storage/' . $helper->profile_photo) : asset('assets/images/page-img/14.png')); ?>"
                                                                style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                                                            <span><?php echo e($helper->name); ?></span>
                                                        </div>
                                                    </td>
                                                    <td class="text-muted"><?php echo e($helper->email ?? '-'); ?></td>
                                                    <td>
                                                        <span
                                                            class="badge <?php echo e($statusBadge); ?>"><?php echo e($statusLabel); ?></span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge <?php echo e($availBadge); ?>"><?php echo e($availLabel); ?></span>
                                                    </td>

                                                    <td>
                                                        <div class="d-flex gap-1">

                                                            
                                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                                data-bs-target="#editHelperModal-<?php echo e($helper->id); ?>">
                                                                ✏️
                                                            </button>

                                                            
                                                            <button class="btn btn-sm btn-info helper-docs-btn"
                                                                data-bs-toggle="modal" data-bs-target="#personDocsModal"
                                                                data-type="helper" data-id="<?php echo e($helper->id); ?>"
                                                                data-name="<?php echo e($helper->name); ?>">
                                                                📄
                                                            </button>

                                                        </div>
                                                    </td>

                                                </tr>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">No helpers found.
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        
        <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="modal fade" id="editDriverModal-<?php echo e($driver->id); ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Edit Driver</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form method="POST" action="<?php echo e(route('owner.drivers.update', $driver->id)); ?>"
                            enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="modal-body">
                                <div class="mb-3 text-center">
                                    <label class="form-label d-block">Profile Picture</label>

                                    
                                    <div class="mb-2">
                                        <?php if($driver->profile_photo): ?>
                                            <img src="<?php echo e(asset('storage/' . $driver->profile_photo)); ?>" alt="Profile"
                                                class="rounded-circle border"
                                                style="width: 200px; height: 200px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center border"
                                                style="width: 200px; height: 200px;">
                                                <span class="text-muted small">No Image</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    
                                    <label class="form-label">Change Profile Picture</label>
                                    <input type="file" name="profile_photo" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input class="form-control" name="name" value="<?php echo e($driver->name); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email"
                                        value="<?php echo e($driver->email); ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="active" <?php echo e($driver->status === 'active' ? 'selected' : ''); ?>>Active
                                        </option>
                                        <option value="on-leave" <?php echo e($driver->status === 'on-leave' ? 'selected' : ''); ?>>On
                                            Leave</option>
                                        <option value="inactive" <?php echo e($driver->status === 'inactive' ? 'selected' : ''); ?>>
                                            Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php $__currentLoopData = $helpers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $helper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="modal fade" id="editHelperModal-<?php echo e($helper->id); ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Edit Helper</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form method="POST" action="<?php echo e(route('owner.helpers.update', $helper->id)); ?>"
                            enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="modal-body">
                                <div class="mb-3 text-center">
                                    <label class="form-label d-block">Profile Picture</label>

                                    
                                    <div class="mb-2">
                                        <?php if($helper->profile_photo): ?>
                                            <img src="<?php echo e(asset('storage/' . $helper->profile_photo)); ?>" alt="Profile"
                                                class="rounded-circle border"
                                                style="width: 200px; height: 200px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center border"
                                                style="width: 200px; height: 200px;">
                                                <span class="text-muted small">No Image</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    
                                    <label class="form-label">Change Profile Picture</label>
                                    <input type="file" name="profile_photo" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input class="form-control" name="name" value="<?php echo e($helper->name); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email"
                                        value="<?php echo e($helper->email); ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="active" <?php echo e($helper->status === 'active' ? 'selected' : ''); ?>>Active
                                        </option>
                                        <option value="on-leave" <?php echo e($helper->status === 'on-leave' ? 'selected' : ''); ?>>On
                                            Leave</option>
                                        <option value="inactive" <?php echo e($helper->status === 'inactive' ? 'selected' : ''); ?>>
                                            Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="modal fade" id="personDocsModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <form method="POST" action="<?php echo e(route('owner.person-docs.save')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="modal-header">
                            <h5 class="modal-title" id="docsModalTitle">Documents</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <input type="hidden" name="person_id" id="personId">
                            <input type="hidden" name="person_type" id="personTypeDoc">

                            <div class="mb-3">
                                <strong id="driverName"></strong>
                            </div>

                            <hr>

                            
                            <div id="documentsContainer"></div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary">Save</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // =========================
            // 1) Add Person Modal action switch
            // =========================
            const form = document.getElementById('addPersonForm');
            const type = document.getElementById('personType');

            if (form && type) {
                const defaultAction = form.getAttribute('action') || '';

                const actions = {
                    driver: <?php echo json_encode(route('owner.drivers.store'), 15, 512) ?>,
                    helper: <?php echo json_encode(route('owner.helpers.store'), 15, 512) ?>,
                };

                const setAction = () => {
                    const val = (type.value || '').toLowerCase();
                    form.action = actions[val] || defaultAction;
                    return !!actions[val];
                };

                setAction();
                type.addEventListener('change', setAction);

                form.addEventListener('submit', (e) => {
                    if (!setAction()) {
                        e.preventDefault();
                        alert('Please select a type (Driver / Helper).');
                        type.focus();
                    }
                });
            }

            // =========================
            // 2) FIX: Eye buttons toggle collapse open/close
            // =========================
            if (!window.bootstrap || !bootstrap.Collapse) {
                console.warn('Bootstrap Collapse not found. Make sure bootstrap.bundle.min.js is loaded.');
                return;
            }

            document.querySelectorAll('.ui-eye-btn[data-bs-target]').forEach((btn) => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();

                    const selector = btn.getAttribute('data-bs-target');
                    const target = document.querySelector(selector);
                    if (!target) return;

                    const instance = bootstrap.Collapse.getOrCreateInstance(target, {
                        toggle: false
                    });
                    const isOpen = target.classList.contains('show');

                    if (isOpen) {
                        instance.hide();
                        btn.setAttribute('aria-expanded', 'false');
                    } else {
                        instance.show();
                        btn.setAttribute('aria-expanded', 'true');
                    }
                });
            });

            // ===== Bulk select (Drivers + Helpers) =====
            const bulkBtn = document.getElementById('bulkDeletePeopleBtn');
            const driverIdsInput = document.getElementById('bulkDriverIds');
            const helperIdsInput = document.getElementById('bulkHelperIds');

            const selectAllDrivers = document.getElementById('selectAllDrivers');
            const selectAllHelpers = document.getElementById('selectAllHelpers');

            const getDriverChecks = () => Array.from(document.querySelectorAll('.driver-check'));
            const getHelperChecks = () => Array.from(document.querySelectorAll('.helper-check'));

            const getSelectedDriverIds = () => getDriverChecks().filter(c => c.checked).map(c => c.value);
            const getSelectedHelperIds = () => getHelperChecks().filter(c => c.checked).map(c => c.value);

            const refreshBulkUI = () => {
                const dIds = getSelectedDriverIds();
                const hIds = getSelectedHelperIds();

                driverIdsInput.value = dIds.join(',');
                helperIdsInput.value = hIds.join(',');

                bulkBtn.disabled = (dIds.length + hIds.length) === 0;

                if (selectAllDrivers) {
                    selectAllDrivers.checked = dIds.length > 0 && dIds.length === getDriverChecks().length;
                }
                if (selectAllHelpers) {
                    selectAllHelpers.checked = hIds.length > 0 && hIds.length === getHelperChecks().length;
                }
            };

            if (selectAllDrivers) {
                selectAllDrivers.addEventListener('change', () => {
                    getDriverChecks().forEach(c => c.checked = selectAllDrivers.checked);
                    refreshBulkUI();
                });
            }

            if (selectAllHelpers) {
                selectAllHelpers.addEventListener('change', () => {
                    getHelperChecks().forEach(c => c.checked = selectAllHelpers.checked);
                    refreshBulkUI();
                });
            }

            document.addEventListener('change', (e) => {
                if (e.target.classList.contains('driver-check') || e.target.classList.contains(
                        'helper-check')) {
                    refreshBulkUI();
                }
            });

            refreshBulkUI();

            const TAB_KEY = 'driversCrewActiveTab';

            // When user clicks a tab, save it
            document.querySelectorAll('button[data-bs-toggle="tab"]').forEach((tabBtn) => {
                tabBtn.addEventListener('shown.bs.tab', (e) => {
                    const target = e.target.getAttribute(
                        'data-bs-target'); // #tab-drivers or #tab-helpers
                    if (target) localStorage.setItem(TAB_KEY, target);
                });
            });

            // On load, restore the last tab
            const lastTab = localStorage.getItem(TAB_KEY);
            if (lastTab) {
                const btn = document.querySelector(`button[data-bs-target="${lastTab}"]`);
                if (btn && window.bootstrap) {
                    bootstrap.Tab.getOrCreateInstance(btn).show();
                }
            }

            // =========================
            // 3) Search filter (Drivers + Helpers) - desktop tables + mobile cards
            // =========================
            const searchInput = document.getElementById('peopleSearchInput');

            const normalise = (s) => (s || '').toString().toLowerCase().trim();

            // Filter Desktop Rows
            const filterTableRows = (tabPane, query) => {
                if (!tabPane) return;

                const rows = tabPane.querySelectorAll('table tbody tr');
                rows.forEach(row => {
                    // ignore "No drivers found" row
                    const colsText = normalise(row.innerText);
                    const shouldShow = colsText.includes(query);
                    row.style.display = shouldShow ? '' : 'none';
                });
            };

            // Filter Mobile Cards
            const filterMobileCards = (tabPane, query) => {
                if (!tabPane) return;

                const cards = tabPane.querySelectorAll('.ui-mobile-person');
                cards.forEach(card => {
                    const text = normalise(card.innerText);
                    const shouldShow = text.includes(query);
                    card.style.display = shouldShow ? '' : 'none';
                });
            };

            const runPeopleSearch = () => {
                const q = normalise(searchInput.value);

                const activeTabBtn = document.querySelector('button[data-bs-toggle="tab"].active');
                const targetSel = activeTabBtn ? activeTabBtn.getAttribute('data-bs-target') : '#tab-drivers';
                const activePane = document.querySelector(targetSel);

                // Filter only currently active tab content
                filterTableRows(activePane, q);
                filterMobileCards(activePane, q);
            };

            if (searchInput) {
                searchInput.addEventListener('input', runPeopleSearch);

                // When switching tabs, re-run search so it applies to the new tab
                document.querySelectorAll('button[data-bs-toggle="tab"]').forEach((tabBtn) => {
                    tabBtn.addEventListener('shown.bs.tab', () => runPeopleSearch());
                });
            }

        });


        const driverDocs = ['DRUG_TEST', 'NBI', 'SSS', 'PHILHEALTH', 'PAGIBIG', 'LICENSE'];
        const helperDocs = ['DRUG_TEST', 'NBI', 'SSS', 'PHILHEALTH', 'PAGIBIG', 'VALID_ID'];

        document.addEventListener('click', async function(e) {

            const btn = e.target.closest('.driver-docs-btn, .helper-docs-btn');

            if (btn) {
                const id = btn.dataset.id;
                const name = btn.dataset.name;
                const type = btn.dataset.type;

                document.getElementById('personId').value = id;
                document.getElementById('personTypeDoc').value = type;
                document.getElementById('driverName').innerText = name;

                document.getElementById('docsModalTitle').innerText =
                    type === 'driver' ? 'Driver Documents' : 'Helper Documents';

                const container = document.getElementById('documentsContainer');
                container.innerHTML = '';

                const docsList = type === 'driver' ? driverDocs : helperDocs;

                // 🔥 FETCH EXISTING DATA
                let existingDocs = {};

                try {
                    const res = await fetch(`/owner/person-docs/${id}/${type}`);
                    const data = await res.json();

                    data.forEach(d => {
                        const key = (d.type || '').toUpperCase().replace(/\s+/g, '_');
                        existingDocs[key] = d;
                    });

                } catch (err) {
                    console.error('Fetch error:', err);
                }

                // 🔥 BUILD UI WITH EXISTING DATA
                docsList.forEach(doc => {

                    const key = doc.toUpperCase().replace(/\s+/g, '_');

                    const file = existingDocs[key]?.file_path;
                    const expiry = existingDocs[key]?.expiry_date || '';

                    const div = document.createElement('div');
                    div.classList.add('mb-3');

                    div.innerHTML = `
    <label class="fw-bold">${doc}</label>

    <div class="mb-1">
        ${file 
            ? `<a href="/storage/${file}" target="_blank" class="small text-primary">View File</a>` 
            : '<span class="small text-muted">No file</span>'}
    </div>

    <div class="row">
        <div class="col-md-6">
            <input type="date" 
                name="expiry[${doc}]" 
                class="form-control"
                value="${expiry}">

            <div class="form-check mt-1">
                <input type="checkbox" 
                    name="delete_expiry[${doc}]" 
                    value="1"
                    class="form-check-input">
                <label class="form-check-label small text-danger">
                    Delete Expiry
                </label>
            </div>
        </div>

        <div class="col-md-6">
            <input type="file" 
                name="file[${doc}]" 
                class="form-control">

            <div class="form-check mt-1">
                <input type="checkbox" 
                    name="delete_file[${doc}]" 
                    value="1"
                    class="form-check-input">
                <label class="form-check-label small text-danger">
                    Delete File
                </label>
            </div>
        </div>
    </div>
`;

                    container.appendChild(div);
                });
            }

        });
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* ====== Available Cards UI ====== */
        .ui-hero {
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, .05);
            background:
                radial-gradient(900px 500px at 10% 10%, rgba(99, 102, 241, .10), transparent 60%),
                radial-gradient(900px 500px at 90% 20%, rgba(16, 185, 129, .10), transparent 60%),
                linear-gradient(135deg, #ffffff, #f9fafb);
            box-shadow: 0 20px 40px rgba(17, 24, 39, .06);
        }

        .ui-available-card {
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(16, 24, 40, .06);
            transition: .2s ease;
        }

        .ui-available-card:hover {
            box-shadow: 0 12px 35px rgba(16, 24, 40, .10);
        }

        .ui-available-number {
            font-size: 30px;
            font-weight: 800;
            line-height: 1;
        }

        /* Eye Button */
        .ui-eye-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid #d0d5dd;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .2s ease;
        }

        .ui-eye-btn i {
            font-size: 16px;
            color: #344054;
        }

        .ui-eye-btn:hover {
            background: #f2f4f7;
        }

        /* Dropdown closer */
        .ui-available-dropdown {
            margin-top: 6px;
        }

        /* List pagination controls */
        .ui-list-controls .btn {
            border-radius: 999px;
            padding: .25rem .7rem;
        }

        /* =========================================================
                                                                                                                                                                                             MOBILE PERSON CARDS (Drivers/Helpers) - CENTRED LAYOUT
                                                                                                                                                                                            ========================================================= */

        .ui-mobile-person--centered {
            border-radius: 18px;
            overflow: hidden;
            transition: .2s ease;
        }

        .ui-mobile-person--centered:hover {
            box-shadow: 0 10px 25px rgba(16, 24, 40, .08);
        }

        .ui-person-top {
            display: flex;
            justify-content: center;
            padding-top: 6px;
        }

        .ui-person-avatar-lg {
            width: 84px;
            height: 84px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 10px 25px rgba(16, 24, 40, .10);
        }

        .ui-person-head {
            text-align: center;
            margin-top: 10px;
        }

        .ui-person-name {
            font-weight: 900;
            font-size: 1.05rem;
            line-height: 1.2;
            word-break: break-word;
            overflow-wrap: anywhere;
            padding: 0 10px;
        }

        .ui-person-email {
            margin-top: 4px;
            font-size: .88rem;
            color: #667085;
            word-break: break-word;
            overflow-wrap: anywhere;
            padding: 0 10px;
        }

        /* ===== MOBILE META (COMPACT VERSION) ===== */

        .ui-person-meta-list {
            margin-top: 14px;
            padding-top: 10px;
            border-top: 1px solid #f1f3f6;
        }

        .ui-meta-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            /* tighter */
        }

        .ui-meta-line+.ui-meta-line {
            border-top: 1px solid #f7f7f9;
        }

        .ui-meta-label {
            font-size: .72rem;
            /* smaller label */
            font-weight: 600;
            color: #98A2B3;
        }

        .ui-meta-line .badge {
            font-weight: 600;
            font-size: .45rem;
            /* smaller value */
            padding: .28rem .55rem;
            /* smaller pill */
            border-radius: 999px;
            white-space: nowrap;
        }

        /* Actions */
        .ui-person-actions {
            margin-top: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;

        }

        .ui-person-btn {
            width: 100%;
            border-radius: 999px;
            font-weight: 800;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* ====== Fixed Header Layout (No Overflow) ====== */
        .ui-people-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .ui-people-title-wrap {
            min-width: 0;
            /* allows text to wrap instead of pushing buttons out */
            flex: 1 1 auto;
        }

        .ui-people-title {
            white-space: normal;
            /* allow wrapping on mobile */
            line-height: 1.15;
        }

        .ui-people-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            flex: 0 0 auto;
        }

        .ui-people-btn {
            height: 40px;
            border-radius: 12px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 14px;
            white-space: nowrap;
        }

        .ui-people-btn--icon {
            width: 44px;
            padding: 0;
        }

        /* Search bar (aligned with Add/Delete) */
        .ui-people-search {
            position: relative;
            width: 320px;
            max-width: 100%;
        }

        .ui-people-search-input {
            height: 40px;
            /* match buttons */
            border-radius: 12px;
            /* match UI */
            padding-left: 38px;
            /* room for icon */
            font-weight: 600;
        }

        .ui-people-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #667085;
            font-size: 16px;
            pointer-events: none;
        }

        /* Mobile: stack nicely, search full width */
        @media (max-width: 575.98px) {
            .ui-people-actions {
                flex-wrap: wrap;
                gap: 10px;
            }

            .ui-people-search {
                width: 100%;
                order: 1;
            }

            .ui-people-btn--add {
                flex: 1 1 auto;
                order: 2;
            }

            #bulkDeletePeopleForm {
                order: 3;
            }
        }

        /* Mobile: make it 2 rows (Title on top, buttons below full width) */
        @media (max-width: 575.98px) {
            .ui-people-header {
                flex-direction: column;
                align-items: stretch;
            }

            .ui-people-actions {
                width: 100%;
                justify-content: flex-end;
            }

            .ui-people-btn--add {
                flex: 1 1 auto;
                /* Add button takes remaining space */
            }
        }

        /* Optional: reduce padding on very small screens */
        @media (max-width: 380px) {
            .ui-person-avatar-lg {
                width: 76px;
                height: 76px;
            }

            .ui-person-name {
                font-size: 1rem;
            }

            .ui-person-meta-row {
                gap: 10px;
            }

            .ui-person-meta-row .badge {
                font-size: .78rem;
                padding: .42rem .7rem;
            }

        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.owner', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u649672793/domains/gray-spoonbill-292506.hostingersite.com/laravel_app/resources/views/owner/drivers/index.blade.php ENDPATH**/ ?>