



<div class="form-group form-animate-text <?php $__errorArgs = [$fieldName];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-animate-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
    <?php echo Form::text($fieldName, $value, array('autocomplete'=>'off', 'class' => 'form-text datepicker'.($errors->has($fieldName)?' error':''))+($required?['required']:[])+($readonly?['readonly']:[])); ?>

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
    var lang = $('html').attr('lang');
    $.datetimepicker.setLocale(lang);

    $('input[name="<?php echo e($fieldName); ?>"]').datetimepicker({
        timepicker: false,
        mask: '39-19-9999',
        format: 'd-m-Y',
        dayOfWeekStart: 1
    }).each(function(){ if (this.value == '__-__-____') $(this).val(''); });

    $('.datetimepicker').datetimepicker({
        timepicker: true,
        mask: '39-19-9999 29:59',
        format: 'd-m-Y H:i',
        dayOfWeekStart: 1
    }).each(function(){ if (this.value == '__-__-____ __:__') $(this).val(''); });
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.2\GSES 2.0\resources\views/uitypes/date.blade.php ENDPATH**/ ?>