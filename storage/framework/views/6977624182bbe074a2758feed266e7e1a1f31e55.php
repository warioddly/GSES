<div class="form-group form-animate-text <?php $__errorArgs = [$fieldName];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-animate-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
    
    <div class="input-group">
        <?php echo Form::select($fieldName.'[]', $options, $values, array('class' => 'form-control subject_select js-states select2'.($errors->has($fieldName)?' error':''), 'multiple'=>'multiple')+($required?['required']:[])+($ajax?['data-ajax'=>$ajax]:[])); ?>

        <span class="bar"></span>
        <div class="input-group-btn">
            <button id="show-subject-modal" type="button" class="btn btn-secondary">
                <i class="fas fa-plus"></i>
            </button>
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
        <div class="modal fade" id="create-subject-modal" tabindex="-1" role="dialog"
             aria-labelledby="analyzeEditModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('page-scripts'); ?>
    <script>
        <?php if($ajax!=null): ?>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('select[name="<?php echo e($fieldName.'[]'); ?>"]').select2({
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
        $('select[name="<?php echo e($fieldName.'[]'); ?>"]').select2({
            placeholder: '<?php echo e(__('Search for an item')); ?>',
            theme: 'default',
            allowClear: true,
            width: '100%'
        });
        <?php endif; ?>
    </script>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('subject-create')): ?>
        <script>
            $('#show-subject-modal').click(function () {
                startPreloader();
                $.ajax({
                    method: 'get',
                    url: '<?php echo e(route('modal-subject.create')); ?>',
                    success: (data) => {
                        $('#create-subject-modal .modal-content').html(data);
                        $('#create-subject-modal').modal('show');
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
            $('#create-subject-modal').on('submit', '#modal-form', function (e) {
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
                        $('.subject_select').append(`<option value="${data.id}" selected>${data.subject_case}</option>`);
                        $('.subject_select').select2('destroy').select2({
                            placeholder: '<?php echo e(__('Search for an item')); ?>',
                            theme: 'default',
                            allowClear: true,
                        });
                        $('#create-subject-modal').modal('hide');
                        $('#create-subject-modal .modal-content').empty();
                    },
                    error: function (error) {
                        stopPreloader();
                        if (error.status === 422) {
                            $.each(error.responseJSON.errors, function (i, error) {
                                var el = $('#create-subject-modal').find('[name="' + i + '"]');
                                el.parent().append($('<em class="ajax-modal-error error">' + error[0] + '</em>'));
                                $('#create-subject-modal').scrollTop(0);
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
<?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.0\resources\views/uitypes/select_multiple_subject.blade.php ENDPATH**/ ?>