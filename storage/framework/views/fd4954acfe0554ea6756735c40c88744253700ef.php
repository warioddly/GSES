<div class="form-group form-animate-text <?php $__errorArgs = [$fieldName];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-animate-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
    <?php echo Form::select($fieldName, $options, $value, array('class' => 'form-control js-states select2'.($errors->has($fieldName)?' error':''))+($required?['required']:[])+($readonly?['readonly']:[])+($ajax?['data-ajax'=>$ajax]:[])); ?>

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
    <?php if($ajax): ?>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $('select[name="<?php echo e($fieldName); ?>"]').select2({
        ajax: {
            url: '<?php echo e($ajax); ?>',
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    _token: CSRF_TOKEN,
                    search: params.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        },
        placeholder: '<?php echo e(__('Search for an item')); ?>',
        allowClear: true,
        theme: 'default',
        width: '100%'
    });
    <?php else: ?>
    $('select[name="<?php echo e($fieldName); ?>"]').select2({
        placeholder: '<?php echo e(__('Search for an item')); ?>',
        theme: 'default',
        allowClear: true,
        width: '100%'
    });
    <?php endif; ?>
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.2\GSES 2.0\resources\views/uitypes/select.blade.php ENDPATH**/ ?>