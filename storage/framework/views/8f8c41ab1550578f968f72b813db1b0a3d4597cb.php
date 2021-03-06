<?php $__env->startSection('panel'); ?>
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft"><?php echo e(__('Edit Contractor')); ?></h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="<?php echo e(route('modules.contractors.index')); ?>"> <?php echo e(__('Close')); ?></a>
                <button type="submit" class="btn btn-primary" form="modules-contractor-form"><?php echo e(__('Save')); ?></button>
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

    <?php echo Form::model($contractor, ['id'=>'modules-contractor-form', 'method' => 'PATCH', 'route' => ['modules.contractors.update', $contractor->id], 'enctype'=>'multipart/form-data']); ?>

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
                        <?php echo e(AppHelper::selectBlade('type_id', __('Type'), [null=>__('Search for an item')]+$types, null, true)); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field type-depended-elements">
                        <?php echo e(AppHelper::selectBlade('organ_id', __('name'), [null=>__('Search for an item')]+$organs, null, true)); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::dependedSelectBlade('region_id', __('Region'), [null=>__('Search for an item')] + $regions, $contractor->region_id, true)); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::dependedSelectBlade('district_id', __('District'), [null=>__('Search for an item')] + $districts, $contractor->district_id, false, 'region_id', $typeRelation)); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field type-depended-elements">
                        <?php echo e(AppHelper::textBlade('sub_organ', __('Subdivision name'), null, false)); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::textBlade('last_name', __('Contractor last name'), null, true)); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::textBlade('name', __('Contractor name'), null, true)); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::textBlade('middle_name', __('Contractor middle name'), null, false)); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field type-depended-elements">
                        <?php echo e(AppHelper::textBlade('position', __('Contractor position'), null, false)); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::textBlade('phone', __('Contractor phone'), null, false, false, 'tel')); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::textBlade('email', __('Contractor email'), null, false, false, 'email')); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel">
        <div class="panel-footer bg-white border-none">
            <div class="row">
                <div class="col-md-12 py-md-3 px-md-5 text-right">
                    <a href="<?php echo e(route('modules.contractors.index')); ?>" class="btn btn-secondary"><?php echo e(__('Close')); ?></a>
                    <button type="submit" class="btn btn-primary"><?php echo e(__('Save')); ?></button>
                </div>
            </div>
        </div>
    </div>

    <?php echo Form::close(); ?>




<?php $__env->stopSection(); ?>
<?php $__env->startPush('page-scripts'); ?>
    <script>
        $(document).on('change', 'select[name=type_id]', function () {
            type_id = $(this).val();
            if (type_id == 1) {
                $('.type-depended-elements').show();
                $('.type-depended-elements').each(function (i, el) {
                    $(el).find('input');
                    $(el).find('select').prop('required',true);
                });
            }
            if (type_id == 2 || type_id == 4) {
                $('.type-depended-elements').each(function (i, el) {
                    $(el).find('input').val(null);
                    $(el).find('select').val('').removeAttr('required');
                    $(el).find('select').select2('destroy').select2({
                        placeholder: '<?php echo e(__('Search for an item')); ?>',
                        theme: 'default',
                        allowClear: true,
                        width: '100%'
                    });
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
        $(document).ready(function () {
            $('select[name="type_id"]').change();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.0\resources\views/contractors/edit.blade.php ENDPATH**/ ?>