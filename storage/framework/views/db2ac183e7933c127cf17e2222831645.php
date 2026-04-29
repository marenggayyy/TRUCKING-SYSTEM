<h2>🚚 New Trip Assigned</h2>

<p>Hello <?php echo e($person->name); ?>,</p>

<p>You have been assigned to a new trip for <strong><?php echo e($company); ?></strong>.</p>

<hr>

<p>
<strong>Date:</strong>
<?php echo e(\Carbon\Carbon::parse($trip->dispatch_date)->format('F d, Y')); ?>

</p>

<p>
<strong>Destination:</strong>
<?php echo e($trip->destination->store_name ?? '-'); ?>

</p>

<p>
<strong>Truck:</strong>
<?php echo e($trip->truck->plate_number ?? '-'); ?>

</p>

<p>
<strong>Driver:</strong>
<?php echo e($trip->driver->name ?? '-'); ?>

</p>

<p>
<strong>Helper(s):</strong>
<?php if(isset($trip->helpers) && $trip->helpers && $trip->helpers->count()): ?>
    <?php echo e($trip->helpers->pluck('name')->join(', ')); ?>

<?php else: ?>
    None
<?php endif; ?>
</p>

<?php if($trip->remarks): ?>
<p>
<strong>Remarks:</strong>
<?php echo e($trip->remarks); ?>

</p>
<?php endif; ?>

<hr>

<p>Please prepare accordingly and coordinate with dispatch if needed.</p>

<p>Safe travels,<br>– <?php echo e($company); ?></p><?php /**PATH C:\Users\HF-PC\Downloads\last zip\laravel_app\resources\views/emails/trip_assigned.blade.php ENDPATH**/ ?>