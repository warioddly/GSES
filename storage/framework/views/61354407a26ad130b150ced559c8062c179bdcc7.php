

<?php $__env->startSection('content'); ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="analyzeEditModalLabel"><?php echo e(__('Show Analyze')); ?></h4>
</div>
<div class="modal-body p-0">
    <div class="panel m-0">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#create-conclusion-modal" aria-expanded="true" aria-controls="collapse1"
                   class="">
                    <h4><?php echo e(__('Basic information')); ?></h4>
                </a>
            </div>
        </div>
        <div id="create-conclusion-modal" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1"
             aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <?php echo e(AppHelper::showBlade(__('Source Material'), $material_analyzes_image->searchImage()->first())); ?>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <?php echo e(AppHelper::showBlade(__('Source image'), $material_analyzes_image->searchMaterial()->first())); ?>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <?php echo e(AppHelper::showBlade(__('Coincidence rate'), $material_analyzes_image->coefficient)); ?>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <?php echo e(AppHelper::showBlade(__('Found image'), $material_analyzes_image->image()->first())); ?>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <?php echo e(AppHelper::showBlade(__('Image name'), $material_analyzes_image->image()->first()->name)); ?>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <?php echo e(AppHelper::showBlade(__('Size'),  $material_analyzes_image->size)); ?>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <?php echo e(AppHelper::showBlade(__('Found Material'),  $material_analyzes_image->material()->first())); ?>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <?php echo e(AppHelper::showBlade(__('Conclusion'), $material_analyzes_image->conclusion)); ?>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <?php echo e(AppHelper::showBlade(__('Created at'), $material_analyzes_image->created_at->format('d-m-Y'))); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IMO\PhpstormProjects\gses\resources\views/modal-CRUDs/materials/analyze-image-materials/show.blade.php ENDPATH**/ ?>