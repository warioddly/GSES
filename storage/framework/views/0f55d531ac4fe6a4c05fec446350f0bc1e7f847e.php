<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('contractor-create')): ?>
    <div class="form-group form-animate-text <?php $__errorArgs = [$fieldName];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-animate-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> contractor-form-group">
        <div class="input-group">
            <?php echo Form::select($fieldName, $options, $value, array('class' => 'form-control contractor-select js-states select2'.($errors->has($fieldName)?' error':''))+($required?['required']:[])+($readonly?['readonly']:[])+($ajax?['data-ajax'=>$ajax]:[])); ?>

            <div class="input-group-btn">
                <button id="show-cover-modal" type="button" class="btn btn-secondary">
                    <i class="fas fa-plus"></i></button>
            </div>
        </div>
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
    <div class="modal fade" id="create-cover-modal" tabindex="-1" role="dialog"
         aria-labelledby="analyzeEditModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>
<?php else: ?>
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
<?php endif; ?>

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
        });
        <?php else: ?>
        $('select[name="<?php echo e($fieldName); ?>"]').select2({
            placeholder: '<?php echo e(__('Search for an item')); ?>',
            theme: 'default',
            allowClear: true,
        });
        <?php endif; ?>
    </script>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('contractor-create')): ?>
        <script>
            $('#show-cover-modal').click(function () {
                startPreloader();
                $.ajax({
                    method: 'get',
                    url: '<?php echo e(route('modal-cover.create')); ?>',
                    success: (data) => {
                        $('#create-cover-modal .modal-content').html(data);
                        $('#create-cover-modal').modal('show');
                        stopPreloader();
                    },
                    error: function (error) {
                        alert('Server error:' + error.status);
                    }
                });
                return false;
            })
        </script>
        <script>
            $(document).on('change', '#create-contractor-accordion select[name=type_id]', function () {
                type_id = $(this).val();
                if (type_id == 1) {
                    $('.type-depended-elements').show();
                    $('.type-depended-elements').each(function (i, el) {
                        $(el).find('input');
                        $(el).find('select').prop('required', true);
                    });
                }
                if (type_id == 2) {
                    $('.type-depended-elements').each(function (i, el) {
                        $(el).find('input').val(null);
                        $(el).find('select').val('').removeAttr('required');
                        $(el).find('select').select2('destroy').select2({
                            placeholder: '<?php echo e(__('Search for an item')); ?>',
                            theme: 'default',
                            allowClear: true,
                            width: '100%'
                        });
                        $(el).find('.select_text > input').val('').removeAttr('required');
                    });
                    $('.type-depended-elements').hide();
                }
                if (type_id == 3) {
                    $('.type-depended-elements').show();
                    $('.type-depended-elements').each(function (i, el) {
                        let input = $(el).find('input');
                        $(el).find('select').prop('required', true);

                        if (input && input.length && input[0].name === 'sub_organ') {
                            $(input[0]).val('').removeAttr('required');
                            $(el).hide();
                        }
                    });
                }
            });
        </script>
        <script>
            $('#create-cover-modal').on('submit', '#modal-form', function (e) {
                startPreloader();
                $('.ajax-modal-error').remove();
                e.preventDefault();
                $.ajax({
                    method: 'post',
                    url: $(this).attr('action'),
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: (data) => {
                        stopPreloader();
                        $('.contractor-select').append(`<option value="${data.id}" selected>${data.name}</option>`);
                        $('.contractor-select').select2('destroy').select2({
                            placeholder: '<?php echo e(__('Search for an item')); ?>',
                            theme: 'default',
                            allowClear: true,
                        });
                        $('#create-cover-modal').modal('hide');
                        $('#create-cover-modal .modal-content').empty();
                    },
                    error: function (error) {
                        stopPreloader();
                        if (error.status === 422) {
                            $.each(error.responseJSON.errors, function (i, error) {
                                var el = $('#create-cover-modal').find('[name="' + i + '"]');
                                el.parent().append($('<em class="ajax-modal-error error">' + error[0] + '</em>'));
                                $('#create-cover-modal').scrollTop(0);
                            });
                        } else {
                            alert('Server error:' + error.status);
                        }

                    }
                });
                return false;
            })
        </script>
    <?php endif; ?>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.0\resources\views/uitypes/select_cover.blade.php ENDPATH**/ ?>