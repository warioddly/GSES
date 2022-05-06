<div class="form-group form-animate-text <?php $__errorArgs = [$fieldName];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-animate-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
    <?php if($type=='text'): ?>
        <?php echo Form::text($fieldName, $value, array('class' => 'form-text'.($errors->has($fieldName)?' error':''))+($required?['required']:[])+($readonly?['readonly']:[])); ?>

    <?php elseif($type=='tel'): ?>
        <?php echo Form::tel($fieldName, $value, array(
                                                    'class' => 'form-text'.($errors->has($fieldName)?' error':''))+
                                                    ($required?['required']:[])+
                                                    ($readonly?['readonly']:[])); ?>

    <?php else: ?>
        <?php echo Form::email($fieldName, $value, array(
                                                    'class' => 'form-text'.($errors->has($fieldName)?' error':''))+
                                                    ($required?['required']:[])+
                                                    ($readonly?['readonly']:[])); ?>

    <?php endif; ?>
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
        $(document).ready(function () {
            $.mask.definitions['9'] = '';
            $.mask.definitions['d'] = '[0-9]';
            $('input[type="tel"]').mask("996ddddddddd").change();
        })
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.0\resources\views/uitypes/text.blade.php ENDPATH**/ ?>