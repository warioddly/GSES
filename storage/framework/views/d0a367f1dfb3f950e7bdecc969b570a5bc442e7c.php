

<?php $__env->startSection('panel'); ?>
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft"><?php echo e(__('Show Expertise')); ?></h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="<?php echo e(route('expertise.index')); ?>"> <?php echo e(__('Close')); ?></a>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('expertise-edit')): ?>
                <a class="btn btn-primary" href="<?php echo e(route('expertise.edit', $expertise->id)); ?>"> <?php echo e(__('Edit')); ?></a>
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
                    <?php echo e(AppHelper::showBlade(__('Expertise name'), $expertise->name)); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Expertise No.'), $expertise->number)); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Case number'), $expertise->case_number)); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Grounds for Appointing an Expertise'), $expertise->reason)); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Registration numbers of the decree (definition)'), $expertise->decree_reg_number)); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Materials receipt date'), $expertise->receipt_date)); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('End of production date'), $expertise->expiration_date)); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Full name of the investigator'), $expertise->contractor()->select(DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))->value('full_name'))); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Expertise type'), $expertise->types()->pluck('title')->all())); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('According to the sequence'), $expertise->sequence()->value('title'))); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('By the composition of the expertise'), $expertise->composition()->value('title'))); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Degree of difficulty'), $expertise->difficulty()->value('title'))); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Responsible'), $expertise->experts()->select(DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))->pluck('full_name')->all())); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Resolution'), $expertise->resolution)); ?>

                </div>
                <div class="col-md-6 px-md-5 form-field">
                    <?php echo e(AppHelper::showBlade(__('Expertise them'), $expertise->them)); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Expertise subjects'), $expertise->subjects()->pluck('subject_case')->all())); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Expertise status'), $expertise->status()->value('title'))); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Reason'), $expertise->status_reason()->value('title'))); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Comment'), $expertise->comment)); ?>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo e(AppHelper::showBlade(__('Article incriminated'), $expertise->article()->value('title'))); ?>

                </div>
            </div>
        </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#collapse2" aria-expanded="true" aria-controls="collapse2" class="">
                    <h4><?php echo e(__('Questions posed to the expertise')); ?></h4>
                </a>
            </div>
        </div>
        <div id="collapse2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading2" aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 whitespace-pre-line">
                        <?php echo e($expertise->questions); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('expertise.sections', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#collapse4" aria-expanded="true" aria-controls="collapse4" class="">
                    <h4><?php echo e(__('Expertise conclusion')); ?></h4>
                </a>
            </div>
        </div>
        <div id="collapse4" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading4" aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <?php if((auth()->user()->hasRole('expert')&&$expertise->vir_experts->where('id',auth()->user()->id))
                     ??auth()->user()->hasRole('Head of Department')): ?>
                            <div class="col-md-6 px-md-5 form-field">
                                <?php echo e(AppHelper::showBlade(__('Conclusion'), $expertise->conclusion)); ?>


                            </div>
                        <?php else: ?>
                            <div class="col-md-6 px-md-5 form-field">
                                <p><?php echo e(__("You don't have access to the conclusion" )); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.0\resources\views/expertise/show.blade.php ENDPATH**/ ?>