

<?php $__env->startSection('content'); ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="analyzeEditModalLabel"><?php echo e(__('Create сourt decision')); ?></h4>
</div>
<div class="modal-body p-0">
    <?php echo Form::open(['id'=>'modal-form', 'method' => 'POST', 'route' => 'expertise.modal.decisions.store', 'enctype'=>'multipart/form-data']); ?>

    <div class="panel m-0">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#create-conclusion-modal" aria-expanded="true"
                   aria-controls="collapse1"
                   class="">
                    <h4><?php echo e(__('Basic information')); ?></h4>
                </a>
            </div>
        </div>
        <div id="create-conclusion-modal" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1"
             aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::dependedSelectBlade(
                            'court_id',
                            __('Court'),
                            [null=>__('Search for an item')]+$courtDecision,
                            null,
                            true
                           )); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::dependedSelectBlade(
                                'court_name_id',
                                __('Court name'),
                                [null=>__('Search for an item')] + $courtNames,
                                null,
                                true, 'court_id', $courtRelation, '#CRUD-modal')); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::dateBlade('date', __('Date'), null, true)); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::textBlade('comment', __('Comment'), null, false)); ?>

                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        <?php echo e(AppHelper::fileBlade('file', __('Attach source file'), null, true)); ?>

                    </div>
                    <input type="hidden" name="expertise_id" value="<?php echo e($expertise_id); ?>">
                </div>
            </div>
        </div>
    </div>

    <?php echo Form::close(); ?>

</div>
<div class="modal-footer">
    <button type="submit" form="modal-form" class="btn btn-primary"><?php echo e(__('Create')); ?></button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IMO\PhpstormProjects\gses\resources\views/modal-CRUDs/expertise/judges-decision/create.blade.php ENDPATH**/ ?>