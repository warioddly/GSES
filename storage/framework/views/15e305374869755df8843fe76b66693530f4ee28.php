<?php
    $count = $material->words()->where('type_id', '=', 3)->count();
?>
<?php if($count > 0): ?>
<a href="<?php echo e(route('materials.content', $material->id)); ?>"><span class="badge badge-danger" title="<?php echo e(__('Keywords')); ?>"><?php echo e($count); ?></span></a>
<?php elseif(trim($material->file_text)): ?>
<a href="<?php echo e(route('materials.content', $material->id)); ?>"><?php echo e(__('Analyze')); ?></a>
<?php endif; ?>
<?php /**PATH C:\Users\IMO\PhpstormProjects\gses\resources\views/materials/index-analyze.blade.php ENDPATH**/ ?>