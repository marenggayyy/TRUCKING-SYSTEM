

<?php $__env->startSection('title', 'Maintenance'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">

        
        <div class="ui-hero p-4 md:p-6 mb-4">
            <h4 class="mb-1">Truck Maintenance</h4>
            <p class="text-muted">Monitor documents, insurance, and PMS status</p>
        </div>

        
        <div class="row">

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="text-muted small">Total Trucks</div>
                        <h4 class="fw-bold"><?php echo e($totalTrucks ?? 0); ?></h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="text-warning small">Expiring Soon</div>
                        <h4 class="fw-bold text-warning"><?php echo e($expiringCount ?? 0); ?></h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="text-danger small">Expired</div>
                        <h4 class="fw-bold text-danger"><?php echo e($expiredCount ?? 0); ?></h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="text-info small">PMS Due</div>
                        <h4 class="fw-bold text-info"><?php echo e($pmsDueCount ?? 0); ?></h4>
                    </div>
                </div>
            </div>

        </div>

        
        <div class="row mb-4">

            
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-warning text-white fw-bold">
                        ⚠ Expiring Soon
                    </div>
                    <div class="card-body">
                        <?php $__empty_1 = true; $__currentLoopData = $expiringDocs ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="mb-2">
                                🚛 <strong><?php echo e($doc->truck->plate_number ?? '-'); ?></strong>
                                - <?php echo e($doc->type); ?>

                                <span class="text-muted">(<?php echo e($doc->days_left); ?> days)</span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-muted">No expiring documents</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-danger text-white fw-bold">
                        ❌ Expired
                    </div>
                    <div class="card-body">
                        <?php $__empty_1 = true; $__currentLoopData = $expiredDocs ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="mb-2">
                                🚛 <strong><?php echo e($doc->truck->plate_number ?? '-'); ?></strong>
                                - <?php echo e($doc->type); ?>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-muted">No expired documents</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>

        
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header fw-bold">
                🚛 Truck Documents
            </div>

            <div class="card-body p-3">
                <div class="table-responsive table-card-wrap">
                    <table class="table table-bordered mb-0">
                        <thead class="text-center">
                            <tr>
                                <th>Plate No</th>
                                <th>ORCR</th>
                                <th>Insurance</th>
                                <th>LTFRB</th>
                                <th>PMS</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $trucks ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $truck): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="fw-bold"><?php echo e($truck->plate_number); ?></td>

                                    
                                    <td class="text-center">
                                        <?php echo $__env->make('partials.doc-status', ['doc' => $truck->orcr], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </td>

                                    
                                    <td class="text-center">
                                        <?php echo $__env->make('partials.doc-status', ['doc' => $truck->insurance], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </td>

                                    
                                    <td class="text-center">
                                        <?php echo $__env->make('partials.doc-status', ['doc' => $truck->ltfrb], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </td>

                                    
                                    <td class="text-center">
                                        <?php echo $__env->make('partials.doc-status', ['doc' => $truck->pms], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </td>

                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary edit-btn" data-bs-toggle="modal"
                                            data-bs-target="#editModal" data-truck-id="<?php echo e($truck->id); ?>"
                                            data-plate="<?php echo e($truck->plate_number); ?>"
                                            data-orcr="<?php echo e(optional($truck->orcr)->expiry_date); ?>"
                                            data-insurance="<?php echo e(optional($truck->insurance)->expiry_date); ?>"
                                            data-ltfrb="<?php echo e(optional($truck->ltfrb)->expiry_date); ?>"
                                            data-pms="<?php echo e(optional($truck->pms)->expiry_date); ?>"
                                            data-orcr-file="<?php echo e(optional($truck->orcr)->file_path); ?>"
                                            data-insurance-file="<?php echo e(optional($truck->insurance)->file_path); ?>"
                                            data-ltfrb-file="<?php echo e(optional($truck->ltfrb)->file_path); ?>"
                                            data-pms-file="<?php echo e(optional($truck->pms)->file_path); ?>">
                                            ✏
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No trucks found
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
        <div class="card border-0 shadow-sm">
            <div class="card-header fw-bold">
                🏢 Company Documents
            </div>

            <div class="card-body">

                <div class="row">

                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center justify-content-between border-end pe-3">

                            <div style="width: 60px;" class="fw-bold">
                                DTI
                            </div>

                            <div style="width: 120px;">
                                <?php if(isset($companyDocs['DTI'])): ?>
                                    <span
                                        class="badge 
                                <?php echo e($companyDocs['DTI']->status === 'ACTIVE'
                                    ? 'bg-success'
                                    : ($companyDocs['DTI']->status === 'EXPIRING'
                                        ? 'bg-warning text-dark'
                                        : 'bg-danger')); ?>">
                                        <?php echo e(ucfirst(strtolower($companyDocs['DTI']->status))); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">No Data</span>
                                <?php endif; ?>
                            </div>

                            <div style="width: 130px;" class="text-muted small">
                                <?php echo e(isset($companyDocs['DTI']) && $companyDocs['DTI']->expiry_date
                                    ? \Carbon\Carbon::parse($companyDocs['DTI']->expiry_date)->format('M d, Y')
                                    : '-'); ?>

                            </div>

                            <div style="width: 40px; text-align:center;">
                                <?php if(isset($companyDocs['DTI']) && $companyDocs['DTI']->file_path): ?>
                                    <a href="<?php echo e(url('storage/' . $companyDocs['DTI']->file_path)); ?>" target="_blank">
                                        👁
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div style="width: 40px;">
                                <button class="btn btn-sm btn-primary company-edit-btn" data-bs-toggle="modal"
                                    data-bs-target="#companyModal" data-type="DTI"
                                    data-expiry="<?php echo e(optional($companyDocs['DTI'] ?? null)->expiry_date); ?>"
                                    data-file="<?php echo e(optional($companyDocs['DTI'] ?? null)->file_path); ?>">
                                    ✏
                                </button>
                            </div>

                        </div>
                    </div>

                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center justify-content-between ps-3">

                            <div style="width: 60px;" class="fw-bold">
                                BIR
                            </div>

                            <div style="width: 120px;">
                                <?php if(isset($companyDocs['BIR'])): ?>
                                    <span
                                        class="badge 
                                <?php echo e($companyDocs['BIR']->status === 'ACTIVE'
                                    ? 'bg-success'
                                    : ($companyDocs['BIR']->status === 'EXPIRING'
                                        ? 'bg-warning text-dark'
                                        : 'bg-danger')); ?>">
                                        <?php echo e(ucfirst(strtolower($companyDocs['BIR']->status))); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">No Data</span>
                                <?php endif; ?>
                            </div>

                            <div style="width: 130px;" class="text-muted small">
                                <?php echo e(isset($companyDocs['BIR']) && $companyDocs['BIR']->expiry_date
                                    ? \Carbon\Carbon::parse($companyDocs['BIR']->expiry_date)->format('M d, Y')
                                    : '-'); ?>

                            </div>

                            <div style="width: 40px; text-align:center;">
                                <?php if(isset($companyDocs['BIR']) && $companyDocs['BIR']->file_path): ?>
                                    <a href="<?php echo e(url('storage/' . $companyDocs['BIR']->file_path)); ?>" target="_blank">
                                        👁
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div style="width: 40px;">
                                <button class="btn btn-sm btn-primary company-edit-btn" data-bs-toggle="modal"
                                    data-bs-target="#companyModal" data-type="BIR"
                                    data-expiry="<?php echo e(optional($companyDocs['BIR'] ?? null)->expiry_date); ?>"
                                    data-file="<?php echo e(optional($companyDocs['BIR'] ?? null)->file_path); ?>">
                                    ✏
                                </button>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>

        
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header d-flex justify-content-between align-items-center fw-bold">
                <span>🚗 Personal Car Documents</span>

                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addPersonalVehicleModal">
                    ➕ Add Personal Car
                </button>
            </div>

            <div class="card-body p-3">
                <div class="table-responsive table-card-wrap">
                    <table class="table table-bordered mb-0">
                        <thead class="text-center">
                            <tr>
                                <th>Plate No</th>
                                <th>ORCR</th>
                                <th>Insurance</th>
                                <th>LTFRB</th>
                                <th>PMS</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $personalVehicles ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="fw-bold"><?php echo e($car->plate_number); ?></td>

                                    <td class="text-center">
                                        <?php echo $__env->make('partials.doc-status', ['doc' => $car->orcr], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </td>

                                    <td class="text-center">
                                        <?php echo $__env->make('partials.doc-status', ['doc' => $car->insurance], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </td>

                                    <td class="text-center text-muted">
                                        N/A
                                    </td>

                                    <td class="text-center">
                                        <?php echo $__env->make('partials.doc-status', ['doc' => $car->pms], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">

                                            
                                            <button class="btn btn-sm btn-primary personal-edit-btn"
                                                data-bs-toggle="modal" data-bs-target="#personalModal"
                                                data-id="<?php echo e($car->id); ?>" data-plate="<?php echo e($car->plate_number); ?>"
                                                data-orcr="<?php echo e(optional($car->orcr)->expiry_date); ?>"
                                                data-insurance="<?php echo e(optional($car->insurance)->expiry_date); ?>"
                                                data-pms="<?php echo e(optional($car->pms)->expiry_date); ?>"
                                                data-orcr-file="<?php echo e(optional($car->orcr)->file_path); ?>"
                                                data-insurance-file="<?php echo e(optional($car->insurance)->file_path); ?>"
                                                data-pms-file="<?php echo e(optional($car->pms)->file_path); ?>">
                                                ✏
                                            </button>

                                            
                                            <form action="<?php echo e(route('owner.personal-vehicles.delete', $car->id)); ?>"
                                                method="POST"
                                                onsubmit="return confirm('Delete this personal vehicle and all documents?')"
                                                class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>

                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    🗑
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No personal vehicles found
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">

                <form method="POST" action="<?php echo e(route('owner.maintenance.save')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Truck Documents</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" name="truck_id" id="modalTruckId">

                        <div class="mb-3">
                            <label class="fw-bold">Truck</label>
                            <input type="text" id="modalPlate" class="form-control" readonly>
                        </div>

                        <hr>

                        
                        <h6 class="fw-bold">ORCR</h6>
                        <div id="orcrPreview" class="mt-2"></div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Expiry Date</label>
                                <input type="date" name="ORCR_expiry" id="orcrInput" class="form-control">

                                <div class="form-check mt-1">
                                    <input type="checkbox" name="delete_ORCR_expiry" value="1"
                                        class="form-check-input">
                                    <label class="form-check-label text-danger">Delete Expiry Date</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label>Upload File</label>
                                <input type="file" name="ORCR_file" class="form-control">

                                <div class="form-check mt-1">
                                    <input type="checkbox" name="delete_ORCR_file" value="1"
                                        class="form-check-input">
                                    <label class="form-check-label text-danger">Delete File</label>
                                </div>
                            </div>
                        </div>

                        
                        <h6 class="fw-bold">Insurance</h6>

                        <div id="insurancePreview" class="mt-2"></div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Expiry Date</label>
                                <input type="date" name="INSURANCE_expiry" id="insuranceInput" class="form-control">

                                <div class="form-check mt-1">
                                    <input type="checkbox" name="delete_INSURANCE_expiry" value="1"
                                        class="form-check-input">
                                    <label class="form-check-label text-danger">Delete Expiry Date</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Upload File</label>
                                <input type="file" name="INSURANCE_file" class="form-control">
                                <div class="form-check mt-1">
                                    <input type="checkbox" name="delete_INSURANCE_file" value="1"
                                        class="form-check-input">
                                    <label class="form-check-label text-danger">Delete File</label>
                                </div>
                            </div>
                        </div>

                        
                        <h6 class="fw-bold">LTFRB</h6>
                        <div id="ltfrbPreview" class="mt-2"></div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Expiry Date</label>
                                <input type="date" name="LTFRB_expiry" id="ltfrbInput" class="form-control">

                                <div class="form-check mt-1">
                                    <input type="checkbox" name="delete_LTFRB_expiry" value="1"
                                        class="form-check-input">
                                    <label class="form-check-label text-danger">Delete Expiry Date</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Upload File</label>
                                <input type="file" name="LTFRB_file" class="form-control">
                                <div class="form-check mt-1">
                                    <input type="checkbox" name="delete_LTFRB_file" value="1"
                                        class="form-check-input">
                                    <label class="form-check-label text-danger">Delete File</label>
                                </div>
                            </div>
                        </div>

                        
                        <h6 class="fw-bold">PMS</h6>
                        <div id="pmsPreview" class="mt-2"></div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Next PMS Date</label>
                                <input type="date" name="PMS_expiry" id="pmsInput" class="form-control">

                                <div class="form-check mt-1">
                                    <input type="checkbox" name="delete_PMS_expiry" value="1"
                                        class="form-check-input">
                                    <label class="form-check-label text-danger">Delete Expiry Date</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Upload File</label>
                                <input type="file" name="PMS_file" class="form-control">

                                <div class="form-check mt-1">
                                    <input type="checkbox" name="delete_PMS_file" value="1"
                                        class="form-check-input">
                                    <label class="form-check-label text-danger">Delete File</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="companyModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="POST" action="<?php echo e(route('owner.company-docs.save')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Company Document</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" name="type" id="companyType">

                        <h6 id="companyTitle"></h6>

                        <div id="companyPreview" class="mb-2"></div>

                        <div class="mb-3">
                            <label>Expiry Date</label>
                            <input type="date" name="expiry_date" id="companyExpiry" class="form-control">

                            <div class="form-check mt-1">
                                <input type="checkbox" name="delete_expiry" value="1" class="form-check-input">
                                <label class="form-check-label text-danger">Delete Expiry Date</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Upload File</label>
                            <input type="file" name="file" class="form-control">

                            <div class="form-check mt-1">
                                <input type="checkbox" name="delete_file" value="1" class="form-check-input">
                                <label class="form-check-label text-danger">Delete File</label>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary">Save</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="personalModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">

                <form method="POST" action="<?php echo e(route('owner.personal-vehicle-docs.save')); ?>"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Personal Vehicle Documents</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" name="personal_vehicle_id" id="personalVehicleId">

                        <div class="mb-3">
                            <label class="fw-bold">Plate Number</label>
                            <input type="text" id="personalPlate" class="form-control" readonly>
                        </div>

                        <hr>

                        <?php $__currentLoopData = ['ORCR', 'INSURANCE', 'PMS']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <h6 class="fw-bold"><?php echo e($type); ?></h6>

                            <div id="<?php echo e(strtolower($type)); ?>PersonalPreview" class="mt-2"></div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Expiry Date</label>
                                    <input type="date" name="<?php echo e($type); ?>_expiry"
                                        id="<?php echo e(strtolower($type)); ?>PersonalInput" class="form-control">

                                    <div class="form-check mt-1">
                                        <input type="checkbox" name="delete_<?php echo e($type); ?>_expiry" value="1"
                                            class="form-check-input">
                                        <label class="form-check-label text-danger">
                                            Delete Expiry Date
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Upload File</label>
                                    <input type="file" name="<?php echo e($type); ?>_file" class="form-control">

                                    <div class="form-check mt-1">
                                        <input type="checkbox" name="delete_<?php echo e($type); ?>_file" value="1"
                                            class="form-check-input">
                                        <label class="form-check-label text-danger">
                                            Delete File
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button class="btn btn-primary">
                            Save
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="addPersonalVehicleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="POST" action="<?php echo e(route('owner.personal-vehicles.store')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="modal-header">
                        <h5 class="modal-title">Add Personal Vehicle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="fw-bold">Plate Number</label>
                            <input type="text" name="plate_number" class="form-control" placeholder="e.g. ABC1234"
                                style="text-transform: uppercase;" required>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Vehicle Name (Optional)</label>
                            <input type="text" name="vehicle_name" class="form-control"
                                placeholder="e.g. Toyota Vios">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-success">
                            Add Vehicle
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .d-flex:hover {
            background: #f8f9fa;
        }

        .ui-hero {
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, .05);
            background:
                radial-gradient(900px 500px at 10% 10%, rgba(99, 102, 241, .10), transparent 60%),
                radial-gradient(900px 500px at 90% 20%, rgba(16, 185, 129, .10), transparent 60%),
                linear-gradient(135deg, #ffffff, #f9fafb);
            box-shadow: 0 20px 40px rgba(17, 24, 39, .06);
        }

        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        .table-card-wrap {
            border-radius: 14px;
            overflow: hidden;
            background: white;
        }

        .table-card-wrap table {
            margin-bottom: 0;
        }

        .table-card-wrap th {
            background: #f8fafc;
            font-size: 14px;
            white-space: nowrap;
        }

        .table-card-wrap th,
        .table-card-wrap td {
            vertical-align: middle;
            padding: 14px 12px;
        }

        .table-card-wrap tbody tr:hover {
            background: #f8fafc;
            transition: 0.2s ease;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('click', function(e) {

            // =========================
            // TRUCK EDIT (existing)
            // =========================
            const btn = e.target.closest('.edit-btn');

            if (btn) {

                document.getElementById('modalTruckId').value = btn.dataset.truckId;
                document.getElementById('modalPlate').value = btn.dataset.plate;

                document.getElementById('orcrInput').value = formatDate(btn.dataset.orcr);
                document.getElementById('insuranceInput').value = formatDate(btn.dataset.insurance);
                document.getElementById('ltfrbInput').value = formatDate(btn.dataset.ltfrb);
                document.getElementById('pmsInput').value = formatDate(btn.dataset.pms);

                setPreview('orcrPreview', btn.dataset.orcrFile);
                setPreview('insurancePreview', btn.dataset.insuranceFile);
                setPreview('ltfrbPreview', btn.dataset.ltfrbFile);
                setPreview('pmsPreview', btn.dataset.pmsFile);
            }

            // =========================
            // COMPANY EDIT (NEW)
            // =========================
            const companyBtn = e.target.closest('.company-edit-btn');

            if (companyBtn) {

                document.getElementById('companyType').value = companyBtn.dataset.type;
                document.getElementById('companyTitle').innerText =
                    companyBtn.dataset.type.replaceAll('_', ' ');

                document.getElementById('companyExpiry').value = formatDate(companyBtn.dataset.expiry);

                setPreview('companyPreview', companyBtn.dataset.file);
            }


            const personalBtn = e.target.closest('.personal-edit-btn');

            if (personalBtn) {

                document.getElementById('personalVehicleId').value = personalBtn.dataset.id;
                document.getElementById('personalPlate').value = personalBtn.dataset.plate;

                document.getElementById('orcrPersonalInput').value = formatDate(personalBtn.dataset.orcr);
                document.getElementById('insurancePersonalInput').value = formatDate(personalBtn.dataset.insurance);
                document.getElementById('pmsPersonalInput').value = formatDate(personalBtn.dataset.pms);

                setPreview('orcrPersonalPreview', personalBtn.dataset.orcrFile);
                setPreview('insurancePersonalPreview', personalBtn.dataset.insuranceFile);
                setPreview('pmsPersonalPreview', personalBtn.dataset.pmsFile);
            }

        });



        function hasFile(filePath) {
            return filePath &&
                filePath !== 'null' &&
                filePath !== 'undefined' &&
                filePath !== '' &&
                filePath !== '/' &&
                filePath !== 'storage/' &&
                filePath.trim() !== '';
        }

        function setPreview(elementId, filePath) {
            const el = document.getElementById(elementId);

            if (hasFile(filePath)) {
                el.innerHTML = `
            <a href="/storage/${filePath}" target="_blank" class="text-primary">
                👁 View Current File
            </a>
        `;
            } else {
                el.innerHTML = `<span class="text-muted">No file uploaded</span>`;
            }
        }

        function formatDate(date) {
            if (!date) return '';

            let d = new Date(date);

            let year = d.getFullYear();
            let month = String(d.getMonth() + 1).padStart(2, '0');
            let day = String(d.getDate()).padStart(2, '0');

            return `${year}-${month}-${day}`;
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.owner', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HF-PC\Downloads\last zip\laravel_app\resources\views/owner/reports/maintenance.blade.php ENDPATH**/ ?>