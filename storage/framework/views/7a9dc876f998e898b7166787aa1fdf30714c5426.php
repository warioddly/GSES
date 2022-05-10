<?php $__env->startSection('panel'); ?>
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft"><?php echo e(__('Edit Material')); ?></h3>
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

    <?php echo Form::model($material, ['id'=>'material-form', 'method' => 'PATCH', 'route' => ['materials.update', $material->id], 'enctype'=>'multipart/form-data']); ?>

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
                        <?php echo e(AppHelper::dependedSelectBlade('object_type_id', __('Object type'), [null=>__('Search for an item')]+$objectTypes, null,true)); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::dependedSelectBlade('type_id', __('Source'), [null=>__('Search for an item')]+$types, null,true, 'object_type_id', $typeRelation)); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::selectMultipleBlade('language_id', __('Language'), $languages, $hasLanguages)); ?>

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
                        <?php echo e(AppHelper::fileBlade('file', __('Attach source file'), $material->file()->first())); ?>

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
    </div>

    <?php echo $__env->make('materials.sections', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="panel">
        <div class="panel-footer bg-white border-none">
            <div class="row">
                <div class="col-md-12 py-md-3 px-md-5 text-right">
                    <div class="btn-group dropup">
                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><?php echo e(__('Analyze')); ?></button>
                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="<?php echo e(route('materials.content', $material->id)); ?>" class="btn-link"
                                   target="_blank"><?php echo e(__('Analyze content')); ?></a></li>
                            <li><a href="javascript:void()" class="btn-link" onclick="$('#analyze-form').submit();"
                                   target="_blank"><?php echo e(__('Analyze materials')); ?></a></li>
                            <li><a href="<?php echo e(route('materials.images', $material->id)); ?>" class="btn-link"
                                   target="_blank"><?php echo e(__('Analyze images')); ?></a></li>
                        </ul>
                    </div>
                    <a href="<?php echo e(route('materials.index')); ?>" class="btn btn-secondary"><?php echo e(__('Close')); ?></a>
                    <button type="submit" class="btn btn-primary"><?php echo e(__('Save')); ?></button>
                </div>
            </div>
        </div>
    </div>

    <?php echo Form::close(); ?>


    <?php echo Form::open(array('id'=>'analyze-form', 'route' => 'materials.analyzes.search','method'=>'POST', 'target'=>'_blank')); ?>

    <?php echo Form::hidden('type', 'text'); ?>

    <?php echo Form::hidden('text', $material->file_text); ?>

    <?php echo Form::hidden('material_id', $material->id); ?>

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
                if(this.files[0].name.substr(this.files[0].name.length - 4)=='.zip'){
                    $(this).val('').trigger('change');
                    alert('<?php echo e(__("When changing the material, you can not use the archive")); ?>');
                    return;
                }
                startPreloader();
                var form_data = new FormData();
                form_data.append('file', this.files[0]);
                $.ajax({
                    url: '<?php echo e(route('materials.analyzes.extract')); ?>', // <-- point to server-side PHP script
                    dataType: 'json',  // <-- what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function (data) {
                        stopPreloader();
                        if (!data.result_array.error) {
                            $('textarea[name="file_text"]').text(data.result_array.file_text);
                        } else {
                            $('textarea[name="file_text"]').text('');
                            alert(data.result_array.error);
                        }
                    }
                });
            }
            else {
                $('textarea[name="file_text"]').text('');
            }
        });
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.0\resources\views/materials/edit.blade.php ENDPATH**/ ?>