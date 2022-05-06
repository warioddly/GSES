<div class="history-meta">
    <?php $__currentLoopData = $history->meta?:[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $change): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p style="background: #d1ebfd;" class="p-1">
            [<strong><?php echo e(trans(ucfirst(str_replace('_',' ',str_replace(['_id'], '', $change['key']))))); ?></strong>]
            :
            <?php if($change['old']): ?>
                <span style="color: darkred;">
            <?php if(strpos($change['key'], '_id') !== false): ?>
                        <?php if($relationship = AppHelper::getFieldRelationship($history->model(), $change['key'])): ?>
                            <?php if($model = $relationship->getRelated()->where(['id'=>$change['old']])->first()): ?>
                                <?php if($model instanceof App\Models\Document): ?>
                                    <?php echo e(AppHelper::showBlade('', $model)); ?>

                                <?php elseif($model->title): ?>
                                    <?php echo e($model->title); ?>

                                <?php elseif($model->name): ?>
                                    <?php echo e($model->name); ?>

                                <?php endif; ?>
                            <?php else: ?>
                                <?php echo e($change['old']); ?>

                            <?php endif; ?>
                        <?php else: ?>
                            <?php echo e($history->model()); ?>:
                            <?php echo e($change['old']); ?>

                        <?php endif; ?>
                    <?php else: ?>
                        <?php echo e($change['old']); ?>

                    <?php endif; ?>
        </span> =>
            <?php endif; ?>
            <?php if($change['new']): ?>
                <span style="color: darkgreen;">
            <?php if(strpos($change['key'], '_id') !== false): ?>
                        <?php if($relationship = AppHelper::getFieldRelationship($history->model(), $change['key'])): ?>
                            <?php if($model = $relationship->getRelated()->where(['id'=>$change['new']])->first()): ?>
                                <?php if($model instanceof App\Models\Document): ?>
                                    <?php echo e(AppHelper::showBlade('', $model)); ?>

                                <?php elseif($model->title): ?>
                                    <?php echo e($model->title); ?>

                                <?php elseif($model->name): ?>
                                    <?php echo e($model->name); ?>

                                <?php endif; ?>
                            <?php else: ?>
                                <?php echo e($change['new']); ?>

                            <?php endif; ?>
                        <?php else: ?>
                            <?php echo e($change['new']); ?>

                        <?php endif; ?>
                    <?php else: ?>
                        <?php echo e($change['new']); ?>

                    <?php endif; ?>
        </span>
            <?php endif; ?>
        </p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH C:\Users\IMO\PhpstormProjects\gses\resources\views/uitypes/history_meta.blade.php ENDPATH**/ ?>