<div class="select_text form-group form-animate-text <?php $__errorArgs = [$fieldName];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-animate-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
    <?php echo Form::text($fieldName, $value, ['class' => 'hidden']); ?>

    <?php echo Form::text($fieldName.'_text', null, [
            'class' => 'form-text'.($errors->has($fieldName)?' error':''),
            'required' => $required,
            'readonly' => $readonly
        ]); ?>

    <ul class="list-group hidden">
        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($loop->index > 0): ?>
            <a href="#" class="list-group-item hidden" data-id="<?php echo e($id); ?>">
                <?php echo e($option['title'][app()->getLocale()]); ?>

            </a>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
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
            let listJson = <?php echo json_encode($options, 15, 512) ?>;
            const list = $('.modal .select_text .list-group');
            const field = $('.modal input[name="<?php echo e($fieldName); ?>"]');
            const text = $('.modal input[name="<?php echo e($fieldName); ?>_text"]');
            const type = $('.modal select[name="type_id"]');

            function select(typedText, clear = true) {
                typedText = !typedText ? '' : typedText.trim();
                if (clear && typedText && typedText.length > 1) {
                    field.val('');
                }

                list.children().each(function(k, v) {
                    const itemText = $(v).text().trim();
                    if (
                        typedText && typedText.length > 1 &&
                        itemText.toLowerCase().includes(typedText.toLowerCase()) &&
                        type.val() == listJson[$(v).attr('data-id')].type_id
                    ) {
                        $(v).click(function(e) {
                            e.preventDefault();

                            text.val(itemText);
                            field.val($(e.target).attr('data-id'));
                        });
                        $(v).removeClass('hidden');
                    } else {
                        $(v).addClass('hidden');
                    }
                });
            }

            text.on('keyup focusin', function(e) {
                if (timer) {
                    clearTimeout(timer);
                }

                timer = setTimeout(function() {
                    select($(e.target).val(), e.type === 'focusin' ? false : true);
                }, 500);

                list.removeClass('hidden');
            });

            $('body').click(function(e) {
                if ($(e.target).attr('name') != '<?php echo e($fieldName); ?>_text') {
                    list.addClass('hidden');
                }
            });
        });
    })(jQuery);
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.0\resources\views/uitypes/select_text.blade.php ENDPATH**/ ?>