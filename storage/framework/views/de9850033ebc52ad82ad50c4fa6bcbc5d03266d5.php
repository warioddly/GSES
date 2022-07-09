<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($permission.'-list')): ?>
    <a href="<?php echo e(route($route.'.show',$model->id)); ?>" title="<?php echo e(__('Show')); ?>" class="row-show"><i class="fas fa-search-plus mx-1"></i></a>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($permission.'-edit')): ?>
    <a href="<?php echo e(route($route.'.edit',$model->id)); ?>" title="<?php echo e(__('Edit')); ?>" class="row-edit"><i class="fas fa-pencil-alt mx-1"></i></a>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($permission.'-delete')): ?>
    <?php echo Form::open(['method' => 'DELETE','route' => [$route.'.destroy', $model->id],'style'=>'display:inline']); ?>

    <?php echo Form::button('<i class="fas fa-trash-alt"></i>', ['type'=>'submit', 'class' => 'btn btn-danger hidden', 'title'=>__('Delete'), 'onclick'=>"return confirm('".__('Are you sure want to delete this?')."')"]); ?>

    <a href="#" onclick="$(this).prev().click()" title="<?php echo e(__('Delete')); ?>" class="row-delete"><i class="fas fa-trash-alt mx-1"></i></a>
    <?php echo Form::close(); ?>

<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($permission.'-list')): ?>
    <?php if(method_exists($model, 'histories')): ?>
        <a href="#" onclick="return history('<?php echo route('histories.index', ['model_type'=>get_class($model), 'model_id'=>$model->id]); ?>')" title="<?php echo e(__('History')); ?>" class="row-history"><i class="fas fa-microscope mx-1"></i></a>
    <?php elseif(method_exists($model, 'operations')): ?>
        <a href="#" onclick="return history('<?php echo route('histories.index', ['model_type'=>get_class($model), 'model_id'=>$model->id]); ?>')" title="<?php echo e(__('History')); ?>" class="row-history"><i class="fas fa-history mx-1"></i></a>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.0\resources\views/layouts/index-actions.blade.php ENDPATH**/ ?>