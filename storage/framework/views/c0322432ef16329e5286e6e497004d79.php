<?php if(!$doc || !$doc->expiry_date): ?>
    <span class="badge bg-secondary">No Data</span>
<?php else: ?>
    
    <?php if($doc->status === 'ACTIVE'): ?>
        <div class="badge bg-success mb-1">Active</div>
        <?php $eyeColor = 'text-success'; ?>
    <?php elseif($doc->status === 'EXPIRING'): ?>
        <div class="badge bg-warning text-dark mb-1">
            Expiring (<?php echo e($doc->days_left); ?>d)
        </div>
        <?php $eyeColor = 'text-warning'; ?>
    <?php else: ?>
        <div class="badge bg-danger mb-1">Expired</div>
        <?php $eyeColor = 'text-danger'; ?>
    <?php endif; ?>

    
    <div class="small text-muted">
        <?php echo e(\Carbon\Carbon::parse($doc->expiry_date)->format('M d, Y')); ?>

    </div>

    
    <div>
        <?php
            $file = $doc->file_path ?? null;
        ?>

        <?php if(!empty($file) && $file !== 'null' && trim($file) !== ''): ?>
            <a href="<?php echo e(url('storage/' . $file)); ?>" target="_blank">
                👁
            </a>
        <?php else: ?>
            <span class="text-muted small fst-italic">No uploaded file</span>
        <?php endif; ?>
    </div>

<?php endif; ?>
<?php /**PATH /home/u649672793/domains/gray-spoonbill-292506.hostingersite.com/laravel_app/resources/views/partials/doc-status.blade.php ENDPATH**/ ?>