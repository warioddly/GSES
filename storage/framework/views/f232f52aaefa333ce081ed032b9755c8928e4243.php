

<?php $__env->startSection('panel'); ?>
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft"><?php echo e(__('Create New Nickname')); ?></h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="<?php echo e(route('modules.nicknames.index')); ?>"> <?php echo e(__('Close')); ?></a>
                <button type="submit" class="btn btn-primary" form="nickname-form"><?php echo e(__('Save')); ?></button>
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

    <?php echo Form::open(array('id'=>'nickname-form', 'route' => 'modules.nicknames.store','method'=>'POST', 'enctype'=>'multipart/form-data')); ?>


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
                        <?php echo e(AppHelper::textBlade('nickname', __('Nickname'), null, true)); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::selectBlade('subject_id', __('Subject'), [null=>__('Search for an item')]+$subjects, true)); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 panel-footer bg-white border-none">
            <div class="row">
                <div class="col-md-12 py-md-3 px-md-5 text-right">
                    <a href="<?php echo e(route('modules.nicknames.index')); ?>" class="btn btn-secondary"><?php echo e(__('Close')); ?></a>
                    <button type="submit" class="btn btn-primary"><?php echo e(__('Save')); ?></button>
                </div>
            </div>
        </div>
    </div>

    <?php echo Form::close(); ?>


<?php $__env->stopSection(); ?>
<?php $__env->startPush('page-scripts'); ?>
    <script>

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IMO\PhpstormProjects\gses\resources\views/nicknames/create.blade.php ENDPATH**/ ?>