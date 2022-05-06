<div class="select_fio form-group form-animate-text <?php $__errorArgs = [$fieldName];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-animate-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
    <?php echo Form::text($fieldName, null, [
            'class' => 'form-text'.($errors->has($fieldName)?' error':''),
            'required' => $required,
            'readonly' => $readonly
        ]); ?>

    <ul class="list-group hidden"></ul>
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
    (function ($) {
        $(document).ready(function() {
            let timer = null;
            let listJson = [];
            const list = $('.modal .select_fio .list-group');
            const text = $('.modal input[name="<?php echo e($fieldName); ?>"]');
            const name = $('.modal input[name="name"]');
            const midName = $('.modal input[name="middle_name"]');

            text.on('keyup focusin', function(e) {
                const textValue = $(e.target).val();
                if (timer) {
                    clearTimeout(timer);
                }

                timer = setTimeout(function() {
                    list.children().remove();
                    if (textValue && textValue.length > 2) {
                        $.get('/contractors?searchText=' + $(e.target).val(), function(data) {
                            listJson = data.data;
                            listJson.forEach(function(v, k) {
                                list.append(`
                                    <a href="#" class="list-group-item" data-key="${k}">
                                        ${v.last_name ? v.last_name : ''}
                                        ${v.name ? v.name : ''}
                                        ${v.middle_name ? v.middle_name : ''}
                                    </a>
                                `);
                            });
                            list.children().each(function(k, v) {
                                $(v).click(function(e) {
                                    e.preventDefault();
                                    const key = $(e.target).attr('data-key');
                                    text.val(listJson[key].last_name);
                                    name.val(listJson[key].name);
                                    midName.val(listJson[key].middle_name);
                                });
                            });
                        });
                    }
                    
                }, 500);

                list.removeClass('hidden');
            });

            $('body').click(function(e) {
                if ($(e.target).attr('name') != '<?php echo e($fieldName); ?>') {
                    list.addClass('hidden');
                }
            });
        });
    })(jQuery);
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.0\resources\views/uitypes/select_fio.blade.php ENDPATH**/ ?>