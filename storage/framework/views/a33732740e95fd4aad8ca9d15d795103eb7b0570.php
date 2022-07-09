<?php $__env->startSection('panel'); ?>
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft"><?php echo e(__('Show Material')); ?></h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="<?php echo e(route('materials.index')); ?>"> <?php echo e(__('Close')); ?></a>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('material-edit')): ?>
                <a class="btn btn-primary" href="<?php echo e(route('materials.edit', $material->id)); ?>"> <?php echo e(__('Edit')); ?></a>
                <?php endif; ?>
            </h3>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1" class="">
                    <h4><?php echo e(__('Basic information')); ?></h4>
                </a>
            </div>
        </div>
        <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1" aria-expanded="true" style="">
            <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Material name'), $material->name)); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Expertise object'), $material->objectType()->value('title'))); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Material type'), $material->type()->value('title'))); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Registration numbers of the decree (definition)'), $material->decree_reg_number)); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Language'), $material->language()->value('title'))); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Material source'), $material->source)); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Status'), $material->status()->value('title'))); ?>

                </div>
            </div>
        </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#collapse2" aria-expanded="true" aria-controls="collapse2" class="">
                    <h4><?php echo e(__('Document')); ?></h4>
                </a>
            </div>
        </div>
        <div id="collapse2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading2" aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 whitespace-pre-line">
                        <?php echo e(AppHelper::showBlade(__('File'), $material->file()->first())); ?>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 whitespace-pre-line">
                        <?php echo e(AppHelper::showBlade(__('Recognized material'), $material->file_text)); ?>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 whitespace-pre-line">
                        <?php echo e(AppHelper::showBlade(__('Commentary on the recognized material'), $material->file_text_comment)); ?>

                    </div>
                    <?php if($material->images()->count()): ?>
                    <div class="col-xs-12 col-sm-12 col-md-12 whitespace-pre-line">
                        <?php echo e(AppHelper::showBlade(__('Material images'), $material->images()->get()->all())); ?>

                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('materials.sections', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.2\GSES 2.0\resources\views/materials/show.blade.php ENDPATH**/ ?>