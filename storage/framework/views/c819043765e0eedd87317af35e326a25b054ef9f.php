<?php $__env->startSection('panel'); ?>
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft"><?php echo e(__('Edit User')); ?></h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="<?php echo e(route('security.users.index')); ?>"> <?php echo e(__('Close')); ?></a>
                <button type="submit" class="btn btn-primary" form="users-form"><?php echo e(__('Save')); ?></button>
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

    <?php echo Form::model($user, ['id'=>'users-form', 'method' => 'PATCH', 'route' => ['security.users.update', $user->id], 'enctype'=>'multipart/form-data']); ?>

    <div class="panel">
        <div class="panel-heading">
            <h4><?php echo e(__('Basic information')); ?></h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6 px-md-5 form-field">
                    <?php echo e(AppHelper::textBlade('last_name', __('Surname'), null, true)); ?>

                </div>
                <div class="col-md-6 px-md-5 form-field">
                    <?php echo e(AppHelper::textBlade('name', __('Name'), null, true)); ?>

                </div>
                <div class="col-md-6 px-md-5 form-field">
                    <?php echo e(AppHelper::textBlade('middle_name', __('Middle name'))); ?>

                </div>
                <div class="col-md-6 px-md-5 form-field">
                    <?php echo e(AppHelper::textBlade('phone', __('Phone'))); ?>

                </div>
                <div class="col-md-6 px-md-5 form-field">
                    <?php echo e(AppHelper::textBlade('email', __('Email'))); ?>

                </div>
                <div class="col-md-6 px-md-5 form-field">
                    <?php echo e(AppHelper::selectMultipleBlade('roles', __('Role'), $roles, $userRole)); ?>

                </div>
                <div class="col-md-6 px-md-5 form-field">
                    <?php echo e(AppHelper::selectBlade('status_id', __('Status'),$statuses)); ?>

                </div>
                <div class="col-md-6 px-md-5 form-field">
                    <?php echo e(AppHelper::passwordBlade('password', __('Password'))); ?>

                </div>
                <div class="col-md-6 px-md-5 form-field">
                    <?php echo e(AppHelper::passwordBlade('confirm-password', __('Confirm Password'))); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <h4><?php echo e(__('Additional information')); ?></h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6 px-md-5 form-field">
                    <?php echo e(AppHelper::selectBlade('position_id', __('Position'), [null=>__('Search for an item')] + $userPositions, $user->position()->value('id'))); ?>

                </div>
                <div class="col-md-6 px-md-5 form-field">
                    <?php echo e(AppHelper::selectBlade('speciality_number_id', __('Specialty nomenclature number'), [null=>__('Search for an item')] + $userSpecialityNumbers, $user->specialityNumber()->value('id'))); ?>

                </div>
                <div class="col-md-6 px-md-5 form-field">
                    <?php echo e(AppHelper::selectBlade('speciality_id', __('Name of the specialty of higher specialized education'), [null=>__('Search for an item')] + $userSpecialities, $user->speciality()->value('id'))); ?>

                </div>
                <div class="col-md-6 px-md-5 form-field">
                    <?php echo e(AppHelper::textBlade('academic_degrees', __('Availability of academic degrees and titles'))); ?>

                </div>
                <div class="col-md-6 px-md-5 form-field">
                    <?php echo e(AppHelper::textBlade('speciality_experience', __('Work experience in the specialty'))); ?>

                </div>
                <div class="col-md-6 px-md-5 form-field">
                    <?php echo e(AppHelper::textBlade('expert_experience', __('Experience of expert activity'))); ?>

                </div>
                <div class="col-md-6 px-md-5 form-field">
                    <?php echo e(AppHelper::fileBlade('certificate_file', __('Competence certificate'), $user->certificateFile()->first())); ?>

                </div>
                <div class="col-md-6 px-md-5 form-field">
                    <?php echo e(AppHelper::textBlade('certificate_valid', __('Certificate validity period'))); ?>

                </div>
            </div>
        </div>
        <div class="panel-footer bg-white border-none">
            <div class="row">
                <div class="col-md-12 py-md-3 px-md-5 text-right">
                    <a href="<?php echo e(route('security.users.index')); ?>" class="btn btn-secondary"><?php echo e(__('Close')); ?></a>
                    <button type="submit" class="btn btn-primary"><?php echo e(__('Save')); ?></button>
                </div>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IMO\PhpstormProjects\gses\resources\views/security/users/edit.blade.php ENDPATH**/ ?>