

<?php $__env->startSection('title', 'Destinations'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">

        
        <div class="ui-hero p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                
                <div>
                    <h4 class="fw-bold mb-1">Destinations</h4>
                    <div class="text-muted small">
                        Routes & Job Points — planning, costing, and optimisation.
                    </div>
                </div>

                
                <form method="GET" action="<?php echo e(route('flash.destinations.index')); ?>" class="d-flex align-items-center gap-2">

                    <div class="ui-search-wrapper">
                        <i class="bi bi-search"></i>
                        <input type="text" name="q" value="<?php echo e(request('q')); ?>" class="form-control"
                            placeholder="Search hub, area...">
                    </div>

                    <?php if(request('q')): ?>
                        <a href="<?php echo e(route('flash.destinations.index')); ?>" class="btn ui-btn ui-btn-clear">
                            Clear
                        </a>
                    <?php endif; ?>

                    <button type="button" class="btn ui-btn ui-btn-add" data-bs-toggle="modal"
                        data-bs-target="#addDestinationModal">
                        <i class="bi bi-plus-lg me-1"></i> Add
                    </button>

                </form>

            </div>
        </div>

        <div class="card shadow-sm">
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">

                        <?php
                            function sortDirection($column)
                            {
                                if (request('sort') !== $column) {
                                    return 'asc';
                                }
                                if (request('direction') === 'asc') {
                                    return 'desc';
                                }
                                if (request('direction') === 'desc') {
                                    return null;
                                } // reset
                                return 'asc';
                            }

                            function sortIcon($column)
                            {
                                if (request('sort') !== $column) {
                                    return '↕';
                                }
                                if (request('direction') === 'asc') {
                                    return '↑';
                                }
                                if (request('direction') === 'desc') {
                                    return '↓';
                                }
                                return '↕';
                            }
                        ?>

                        <thead>
                            <tr>
                                <th>
                                    <a href="<?php echo e(route(
                                        'flash.destinations.index',
                                        array_filter([
                                            'sort' => sortDirection('hub_code') ? 'hub_code' : null,
                                            'direction' => sortDirection('hub_code'),
                                        ]),
                                    )); ?>"
                                        class="ui-sort">
                                        HUB <?php echo sortIcon('hub_code'); ?>

                                    </a>
                                </th>

                                <th>
                                    <a href="<?php echo e(route(
                                        'flash.destinations.index',
                                        array_filter([
                                            'sort' => sortDirection('area') ? 'area' : null,
                                            'direction' => sortDirection('area'),
                                        ]),
                                    )); ?>"
                                        class="ui-sort">
                                        DESTINATION <?php echo sortIcon('area'); ?>

                                    </a>
                                </th>

                                <th>
                                    <a href="<?php echo e(route(
                                        'flash.destinations.index',
                                        array_filter([
                                            'sort' => sortDirection('rate') ? 'rate' : null,
                                            'direction' => sortDirection('rate'),
                                        ]),
                                    )); ?>"
                                        class="ui-sort">
                                        RATE <?php echo sortIcon('rate'); ?>

                                    </a>
                                </th>

                                <th>REMARKS</th>

                                <th width="120">ACTION</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $destinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="position-relative">

                                    <td><?php echo e($d->hub_code ?? '-'); ?></td>

                                    <td>
                                        <div class="fw-semibold"><?php echo e($d->area); ?></div>
                                    </td>

                                    <td class="fw-bold text-success">
                                        ₱ <?php echo e(number_format($d->rate, 2)); ?>

                                    </td>

                                    <td class="text-muted">
                                        <?php echo e($d->remarks ?? '-'); ?>

                                    </td>

                                    <td>
                                        <div class="d-flex gap-1">

                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#edit-<?php echo e($d->id); ?>">
                                                ✏️
                                            </button>

                                            <button class="btn btn-sm btn-danger delete-btn" data-id="<?php echo e($d->id); ?>"
                                                data-name="<?php echo e($d->area); ?>">
                                                🗑️
                                            </button>

                                        </div>
                                    </td>
                                </tr>

                                
                                <div class="modal fade" id="edit-<?php echo e($d->id); ?>">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5>Edit Destination</h5>
                                                <button class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <form method="POST" action="<?php echo e(route('flash.destinations.update', $d->id)); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>

                                                <div class="modal-body">
                                                    <div class="row g-3">

                                                        <div class="col-md-6">
                                                            <input class="form-control" name="hub_code"
                                                                value="<?php echo e($d->hub_code); ?>" required>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <input class="form-control" name="area"
                                                                value="<?php echo e($d->area); ?>" placeholder="Area (optional)">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <input type="number" step="0.01" class="form-control"
                                                                name="rate" value="<?php echo e($d->rate); ?>"required>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <input class="form-control" name="remarks"
                                                                placeholder="Remarks (optional)"
                                                                value="<?php echo e($d->remarks); ?>">
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-primary">Update</button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        No destinations found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="deleteModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="text-danger">Delete Destination</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    Are you sure you want to delete:
                    <strong id="deleteName"></strong>?
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                    <form method="POST" id="deleteForm">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-danger">Delete</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    
    <div class="modal fade" id="addDestinationModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5>Add Destination</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" action="<?php echo e(route('flash.destinations.store')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <input class="form-control" name="hub_code" placeholder="Hub Code" required>
                            </div>

                            <div class="col-md-6">
                                <input class="form-control" name="area" placeholder="Area / Destination">
                            </div>

                            <div class="col-md-6">
                                <input type="number" step="0.01" class="form-control" name="rate"
                                    placeholder="Rate" required>
                            </div>

                            <div class="col-6">
                                <input class="form-control" name="remarks" placeholder="Remarks (optional)">
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary">Save</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // DELETE
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;

                    document.getElementById('deleteName').textContent = name;
                    document.getElementById('deleteForm').action =
                        `/flash/destinations/${id}`;

                    new bootstrap.Modal(document.getElementById('deleteModal')).show();
                });
            });

        });
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* ================================
                                                                                   GLOBAL UI HELPERS
                                                                                ================================ */
        .ui-rounded {
            border-radius: 12px;
        }

        .ui-shadow {
            box-shadow: 0 8px 25px rgba(16, 24, 40, .06);
        }

        /* ================================
                                                                                   HERO HEADER
                                                                                ================================ */
        .ui-hero {
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, .05);
            background:
                radial-gradient(900px 500px at 10% 10%, rgba(99, 102, 241, .10), transparent 60%),
                radial-gradient(900px 500px at 90% 20%, rgba(16, 185, 129, .10), transparent 60%),
                linear-gradient(135deg, #ffffff, #f9fafb);
            box-shadow: 0 20px 40px rgba(17, 24, 39, .06);
            padding: 24px 28px;
        }

        /* ================================
                                                                                   SEARCH BAR
                                                                                ================================ */
        .ui-search-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .ui-search-wrapper {
            position: relative;
            width: 220px;
        }

        .ui-search-wrapper i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 13px;
            color: #98a2b3;
        }

        .ui-search-wrapper input {
            padding-left: 32px;
            height: 40px;
            border-radius: 10px;
        }

        /* ================================
                                                                                   BUTTONS
                                                                                ================================ */
        .ui-btn {
            height: 40px;
            border-radius: 10px;
            padding: 0 14px;
            font-weight: 500;
        }

        .ui-btn-clear {
            background: #fff;
            border: 1px solid #e5e7eb;
        }

        .ui-btn-add {
            background: linear-gradient(135deg, #7c3aed, #6366f1);
            color: #fff;
            border: none;
            font-weight: 600;
            transition: 0.2s ease;
            padding: 0 16px;
        }

        .ui-btn,
        .ui-btn-add,
        .ui-btn-clear {
            height: 38px;
            display: flex;
            align-items: center;
        }

        .ui-btn-add:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(99, 102, 241, 0.25);
        }

        /* ================================
                                                                                   TABLE / RATE
                                                                                ================================ */
        .ui-rate-badge {
            color: #259c39;
            font-weight: 700;
            font-size: 13px;
        }

        /* ================================
                                                                                   REMARKS OVERLAY
                                                                                ================================ */

        .ui-sort {
            color: inherit;
            text-decoration: none;
            font-weight: 600;
        }

        .ui-sort:hover {
            color: #6366f1;
        }

        .ui-sort span {
            font-size: 12px;
            margin-left: 4px;
        }


        /* ================================
                                                                                   RESPONSIVE
                                                                                ================================ */
        @media (max-width: 768px) {
            .ui-search-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .ui-search-wrapper {
                width: 100%;
            }

            .ui-btn {
                width: 100%;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HF-PC\Downloads\last zip\laravel_app\resources\views/flash/destinations/index.blade.php ENDPATH**/ ?>