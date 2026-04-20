<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $__env->yieldContent('title', 'Gigz'); ?></title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/favicon.ico')); ?>" />

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/core/libs.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/gigz.min.css?v=1.0.0')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/custom.min.css?v=1.0.0')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')); ?>" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://unpkg.com/cropperjs/dist/cropper.min.css" rel="stylesheet"/>
    


    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>

    
    <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="main-content">

        
        <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="container-fluid content-inner mt-3 py-0" style="padding-left: 16px;padding-right: 16px;">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

    </main>

    
    <script src="<?php echo e(asset('assets/js/core/libs.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/core/external.min.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/js/charts/widgetcharts.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/charts/vectore-chart.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/charts/dashboard.js')); ?>" defer></script>
    <script src="<?php echo e(asset('assets/js/plugins/fslightbox.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/gsap/gsap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/gsap/ScrollTrigger.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/gsap-init.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/form-wizard.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/js/gigz.js')); ?>" defer></script>

    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/cropperjs/dist/cropper.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof bootstrap === 'undefined') return;

            document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function(toggle) {
                bootstrap.Dropdown.getOrCreateInstance(toggle);
            });

            function closeAllDropdowns() {
                document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function(toggle) {
                    const inst = bootstrap.Dropdown.getInstance(toggle);
                    if (inst) inst.hide();
                });

                document.querySelectorAll('.dropdown-menu.show').forEach(m => m.classList.remove('show'));
                document.querySelectorAll('.dropdown-toggle.show').forEach(t => t.classList.remove('show'));
            }

            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown')) closeAllDropdowns();
            });

            window.addEventListener('pageshow', closeAllDropdowns);
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html><?php /**PATH C:\Users\HF-PC\Downloads\last zip\laravel_app\resources\views/layouts/owner.blade.php ENDPATH**/ ?>