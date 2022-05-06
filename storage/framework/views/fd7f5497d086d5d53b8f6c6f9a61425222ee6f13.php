<?php if($label!=''): ?>
<div class="form-group">
    <strong><?php echo e($label); ?>:</strong>
<?php endif; ?>
    <?php if(is_object($value) or is_array($value)): ?>
        <?php if($value instanceof App\Models\Document): ?>
            <?php if($value->isImage()): ?>
                <a class="thumbnail" style="width: fit-content; max-width: 100%;">
                    <img onclick="ImageToModal(event)"  src="<?php echo e(route('view-file', $value->name_uuid )); ?>" style="width: inherit;">
                </a>
            <?php elseif($value->extension == 'mp4' || $value->extension == 'mov' || $value->extension == 'mpeg'
                    || $value->extension == 'avi' || $value->extension == 'ogg' || $value->extension == 'wmv'): ?>
                <a onclick="VideoToModal(event)" class="video" href="<?php echo e(route('view-file', $value->name_uuid)); ?>"><?php echo e($value->name); ?></a>
            <?php elseif($value->extension == 'm4a' || $value->extension == 'mp3' || $value->extension == 'flac'
                || $value->extension == 'wav' || $value->extension == 'wma' || $value->extension == 'aac'): ?>
                <a onclick="AudioToModal(event)" class="audio" href="<?php echo e(route('view-file', $value->name_uuid)); ?>"><?php echo e($value->name); ?></a>
            <?php else: ?>
                <a href="<?php echo e(route('download-file', $value->name_uuid)); ?>"><?php echo e($value->name); ?></a>
            <?php endif; ?>
        <?php elseif($value instanceof App\Models\Material): ?>
                <a href="<?php echo e(route('materials.show', $value->id)); ?>" target="_blank"><?php echo e($value->name); ?></a>
        <?php elseif(!empty($value)): ?>
            <?php if(end($value) instanceof App\Models\Document): ?>
            <div class="row">
                <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xs-6 col-md-1">
                    <?php if($v->isImage()): ?>
                        <a href="<?php echo e(route('download-file', $v->name_uuid)); ?>" class="thumbnail"><img src="<?php echo e(route('view-file', $v->name_uuid)); ?>" style="max-width: 100%;" data-holder-rendered="true"></a>
                    <?php else: ?>
                        <a href="<?php echo e(route('download-file', $v->name_uuid)); ?>" class=""><?php echo e($v->name); ?></a>
                    <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php else: ?>
                <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="badge badge-info"><?php echo e($v); ?></label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php else: ?>
    <?php echo e($value); ?>

    <?php endif; ?>
<?php if($label!=''): ?>
</div>
<?php endif; ?>
<?php /**PATH C:\Users\IMO\PhpstormProjects\gses\resources\views/uitypes/show.blade.php ENDPATH**/ ?>