<div class="form-group form-animate-text <?php $__errorArgs = [$fieldName];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-animate-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
       >
    <?php echo Form::file($fieldName, array('class' => 'form-text', 'style'=>'opacity:0;position:absolute;z-index:1;')+($required?['required']:[])); ?>

    <div class="input-group">
        <?php if($document != null): ?>
            <?php echo Form::hidden(str_replace(']_id', '_id]', $fieldName.'_id'), $document->id, array('class' => 'form-text file-id')); ?>

            <input type="text" class="form-text file-name<?php echo e($errors->has($fieldName)?' error':''); ?>"
                   value="<?php echo e($document->name); ?>" readonly>
            <span class="input-group-addon"><i class="fas fa-paperclip" title="<?php echo e(__('Choose')); ?>"></i></span>
            <span class="input-group-addon file-clear" style="z-index: 2;position: sticky;background: none;"><i
                        class="fas fa-times" title="<?php echo e(__('Clear')); ?>"></i></span>
            <span class="input-group-addon file-download" style="z-index: 2;position: sticky;background: none;"><a
                        href="<?php echo e(route('download-file', $document->name_uuid)); ?>" target="_blank"
                        title="<?php echo e(__('Download')); ?>"
                        style="color:#555555;"><i class="fas fa-download"></i></a></span>
        <?php else: ?>
            <input type="text" class="form-text file-name<?php echo e($errors->has($fieldName)?' error':''); ?>" value="" readonly>
            <span class="input-group-addon"><i class="fas fa-paperclip" title="<?php echo e(__('Choose')); ?>"></i></span>
            <span class="input-group-addon file-clear"
                  style="z-index: 2;position: sticky;background: none;display:none;"><i class="fas fa-times"
                                                                                        title="<?php echo e(__('Clear')); ?>"></i></span>
        <?php endif; ?>
    </div>
    <span class="bar"></span>
    <label><?php echo e($label); ?></label>
    <?php $__errorArgs = [$fieldName];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <em class="error"><?php echo e(__($message)); ?></em>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<?php $__env->startPush('page-scripts'); ?>
    <script>
        $('input[name="<?php echo e($fieldName); ?>"]').parent().find('.file-clear').click(function () {
            $(this).closest('.form-group').find('input[type="file"]').val('').trigger('change');
        });
        $('input[name="<?php echo e($fieldName); ?>"]').change(function () {
            if (this.files.length > 0) {
                var fileName = [];
                for (var file of this.files) {
                    fileName.push(file.name);
                }
                $(this).parent().find('.file-id').val('');
                $(this).parent().find('.file-name').val(fileName.join(', '));
                $(this).parent().find('.file-clear').show();
                $(this).parent().find('.file-download').show();
            } else {
                $(this).parent().find('.file-id').val('');
                $(this).parent().find('.file-name').val('');
                $(this).parent().find('.file-clear').hide();
                $(this).parent().find('.file-download').hide();
            }
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\IMO\PhpstormProjects\gses\resources\views/uitypes/file.blade.php ENDPATH**/ ?>