

<?php $__env->startSection('content'); ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="analyzeEditModalLabel"><?php echo e(__('Create Contractor')); ?></h4>
    </div>
    <div class="modal-body p-0">
        <form id="modal-form" method="POST" enctype="multipart/form-data"
              action="<?php echo e(route('modal-subject.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="panel m-0">
                <div class="panel-heading">
                    <div class="panel-title">
                        <a role="button" data-toggle="collapse" href="#create-contractor-accordion"
                           aria-expanded="true"
                           aria-controls="collapse1"
                           class="">
                            <h4><?php echo e(__('Basic information')); ?></h4>
                        </a>
                    </div>
                </div>
                <div id="create-contractor-accordion" class="panel-collapse collapse in" role="tabpanel"
                     aria-labelledby="heading1"
                     aria-expanded="true" style="">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 px-md-5 form-field type-depended-elements">
                                <?php echo e(AppHelper::textBlade('subject_case', __('Subject case'), null, false)); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="submit" form="modal-form" class="btn btn-primary"><?php echo e(__('Create')); ?></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IMO\PhpstormProjects\gses\resources\views/modal-CRUDs/subjects/create.blade.php ENDPATH**/ ?>