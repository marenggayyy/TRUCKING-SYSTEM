<form method="POST" action="<?php echo e(route('owner.payroll.update')); ?>">
        <?php echo csrf_field(); ?>

        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Destination</th>
                    <th>Rate</th>
                    <th>Amount</th>
                    <th>Allowance</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <input type="hidden" name="rows[<?php echo e($row->id); ?>][id]" value="<?php echo e($row->id); ?>">

                        <td><?php echo e($row->trip_date); ?></td>
                        <td><?php echo e($row->location); ?></td>

                        <td>
                            <input type="number" step="0.01" name="rows[<?php echo e($row->id); ?>][rate]"
                                value="<?php echo e($row->rate); ?>">
                        </td>

                        <td>
                            <input type="number" step="0.01" name="rows[<?php echo e($row->id); ?>][amount]"
                                value="<?php echo e($row->amount); ?>">
                        </td>

                        <td>
                            <input type="number" step="0.01" name="rows[<?php echo e($row->id); ?>][allowance]"
                                value="<?php echo e($row->allowance); ?>">
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <button class="btn btn-primary">Save Changes</button>
    </form><?php /**PATH C:\Users\HF-PC\Documents\TRUCKING-SYSTEM-master\TRUCKING-SYSTEM\resources\views/owner/payroll/edit.blade.php ENDPATH**/ ?>