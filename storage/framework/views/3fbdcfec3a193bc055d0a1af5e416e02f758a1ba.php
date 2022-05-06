<?php if(!empty($user->getRoleNames())): ?>
<?php $__currentLoopData = $user->getRoleNames(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roleName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <label class="badge badge-success"><?php echo e($roleName); ?></label>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.0\resources\views/security/users/index-roles.blade.php ENDPATH**/ ?>