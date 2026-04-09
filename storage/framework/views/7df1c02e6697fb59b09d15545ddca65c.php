<?php if($paginator->hasPages()): ?>
    <div class="dataTables_paginate paging_simple_numbers">
        <ul class="pagination mb-0">

            
            <?php if($paginator->onFirstPage()): ?>
                <li class="paginate_button page-item previous disabled">
                    <span class="page-link">Previous</span>
                </li>
            <?php else: ?>
                <li class="paginate_button page-item previous">
                    <a class="page-link"
                       href="<?php echo e($paginator->previousPageUrl()); ?>"
                       rel="prev">Previous</a>
                </li>
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                
                <?php if(is_string($element)): ?>
                    <li class="paginate_button page-item disabled">
                        <span class="page-link"><?php echo e($element); ?></span>
                    </li>
                <?php endif; ?>

                
                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <li class="paginate_button page-item active">
                                <span class="page-link"><?php echo e($page); ?></span>
                            </li>
                        <?php else: ?>
                            <li class="paginate_button page-item">
                                <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li class="paginate_button page-item next">
                    <a class="page-link"
                       href="<?php echo e($paginator->nextPageUrl()); ?>"
                       rel="next">Next</a>
                </li>
            <?php else: ?>
                <li class="paginate_button page-item next disabled">
                    <span class="page-link">Next</span>
                </li>
            <?php endif; ?>

        </ul>
    </div>
<?php endif; ?><?php /**PATH /home/u649672793/domains/gray-spoonbill-292506.hostingersite.com/laravel_app/resources/views/vendor/pagination/ui-datatable.blade.php ENDPATH**/ ?>