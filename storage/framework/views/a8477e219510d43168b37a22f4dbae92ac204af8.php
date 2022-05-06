<div class="form-group form-animate-text <?php $__errorArgs = [$fieldName];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-animate-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
    <?php echo Form::select($fieldName, $options, $value, array('class' => 'form-control js-states select2'.($errors->has($fieldName)?' error':''))+($required?['required']:[])); ?>

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
<style>
    .select2-container--default .select2-results__option[aria-disabled=true] {
        display: none;
    }
</style>
<?php $__env->startPush('page-scripts'); ?>
    <script>
        $('select[name="<?php echo e($fieldName); ?>"]').select2({
            placeholder: '<?php echo e(__('Search for an item')); ?>',
            allowClear: true,
            theme: 'default',
            width: '100%',
        });

        <?php if($parentSelect): ?>

        $('<?php echo e($formArea); ?> '+'select[name=<?php echo e($parentSelect); ?>]').change(function () {
            let currentSelect = $('<?php echo e($formArea); ?> '+'select[name=<?php echo e($fieldName); ?>]');
            let dependencyRelation = <?php echo json_encode($dependencies, 15, 512) ?>;
            let keys = [];
            let selectedId = $(this).find(":selected").val();
            for (const [key, value] of Object.entries(dependencyRelation)) {
                if (value[0] == selectedId) {
                    keys.push(value[1]);
                }
            }
            currentSelect.val("");
            currentSelect.find('option').prop('disabled', true);

            currentSelect.find('option').each(function () {
                if (keys.includes(parseInt($(this).val())) || $(this).val() == '') {
                    $(this).prop('disabled', false);

                }
            });
            currentSelect.select2('destroy').select2({
                placeholder: '<?php echo e(__('Search for an item')); ?>',
                allowClear: true,
                theme: 'default',
                width: '100%',
            });
        });
        //clear all options for create
        $(document).ready(function () {
            let currentSelect = $('<?php echo e($formArea); ?> '+'select[name=<?php echo e($fieldName); ?>]');
            let parentSelect = $('<?php echo e($formArea); ?> '+'select[name=<?php echo e($parentSelect); ?>]');
            let dependencyRelation = <?php echo json_encode($dependencies, 15, 512) ?>;
            let keys = [];
            let selectedId = parentSelect.val();
            for (const [key, value] of Object.entries(dependencyRelation)) {
                if (value[0] == selectedId) {
                    keys.push(value[1]);
                }
            }

            currentSelect.find('option').prop('disabled', true);
            currentSelect.find('option').each(function () {
                if (keys.includes(parseInt($(this).val())) || $(this).val() == '') {
                    $(this).prop('disabled', false);
                }
            });
            currentSelect.select2('destroy').select2({
                placeholder: '<?php echo e(__('Search for an item')); ?>',
                allowClear: true,
                theme: 'default',
                width: '100%',
            });
        });
        <?php endif; ?>
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\IMO\PhpstormProjects\gses\resources\views/uitypes/select_depend.blade.php ENDPATH**/ ?>