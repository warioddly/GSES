<?php $__env->startSection('panel'); ?>
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft"><?php echo e(__('Create New Material')); ?></h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="<?php echo e(route('materials.index')); ?>"> <?php echo e(__('Close')); ?></a>
                <button type="submit" class="btn btn-primary" form="material-form"><?php echo e(__('Save')); ?></button>
            </h3>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php if(count($errors) > 0): ?>
        <div class="alert alert-danger">
            <strong><?php echo e(__('Whoops!')); ?></strong> <?php echo e(__('There were some problems with your input.')); ?>

        </div>
    <?php endif; ?>

    <?php echo Form::open(array('id'=>'material-form', 'route' => 'materials.store','method'=>'POST', 'enctype'=>'multipart/form-data')); ?>


    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1"
                   class="">
                    <h4><?php echo e(__('Basic information')); ?></h4>
                </a>
            </div>
        </div>
        <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1"
             aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::textBlade('name', __('Material name'), null, true)); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::dependedSelectBlade('object_type_id', __('Object type'), [null=>__('Search for an item')] + $objectTypes, null,true)); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::dependedSelectBlade('type_id', __('Source'), [null=>__('Search for an item')] + $types, null,true, 'object_type_id', $typeRelation)); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::dependedSelectBlade('child_type_id', __('SourceType'), [null=>__('Search for an item')] + $childTypes, null,true, 'type_id', $childTypeRelation)); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::selectMultipleBlade('language_id', __('Language'), [null=>__('Search for an item')] + $languages)); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::textBlade('source', __('Material source'))); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::selectBlade('status_id', __('Status'), [null=>__('Search for an item')] + $statuses)); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#collapse2" aria-expanded="true" aria-controls="collapse2"
                   class="">
                    <h4><?php echo e(__('Document')); ?></h4>
                </a>
            </div>
        </div>
        <div id="collapse2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading2"
             aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::fileBlade('file', __('Attach source file'))); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::textBlade('file_text_comment', __('Commentary on the recognized material'))); ?>

                    </div>
                    <div class="col-md-12 px-md-5 form-multi-field">
                        <?php echo e(AppHelper::textareaBlade('file_text', __('Recognized material'))); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 panel-footer bg-white border-none">
            <div class="row">
                <div class="col-md-12 py-md-3 px-md-5 text-right">
                    <a href="<?php echo e(route('materials.index')); ?>" class="btn btn-secondary"><?php echo e(__('Close')); ?></a>
                    <button type="submit" class="btn btn-primary"><?php echo e(__('Save')); ?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="archive_container" class="d-none">

    </div>
    <?php echo Form::close(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('page-scripts'); ?>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('input[name="file"]').change(function(){
            if (this.files.length > 0) {
                startPreloader();
                var form_data = new FormData();
                form_data.append('file', this.files[0]);
                let archive_container = $('#archive_container');
                archive_container.empty();
                $.ajax({
                    url: '<?php echo e(route('materials.analyzes.extract')); ?>', // <-- point to server-side PHP script
                    dataType: 'json',  // <-- what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function (data) {
                        if (data.is_archive) {

                            for (let i = 0; i < data.result_array.length; i++) {
                                if (data.result_array[i].error) {
                                    $('textarea[name="file_text"]').text('');
                                    alert(data.result_array[i].error);
                                } else {
                                    let file_text = data.result_array[i].file_text;
                                    let file_path = data.result_array[i].file_path;
                                    archive_container.append(`<input type="hidden" name="archive_file_texts[]" value="${file_text}">`)
                                    archive_container.append(`<input type="hidden" name="archive_file_paths[]" value="${file_path}">`)
                                }
                            }
                        } else {
                            if (!data.result_array.error) {
                                $('textarea[name="file_text"]').text(data.result_array.file_text);
                            } else {
                                $('textarea[name="file_text"]').text('');
                                alert(data.result_array.error);
                            }
                        }
                        stopPreloader();
                    }
                });
            } else {
                $('textarea[name="file_text"]').text('');
            }
        });

    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.2\GSES 2.0\resources\views/materials/create.blade.php ENDPATH**/ ?>