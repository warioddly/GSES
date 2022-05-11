<?php
$fullClassName = get_class($model);
$className =str_replace('App\Models\\', '', $fullClassName);
?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($permission.'-list')): ?>
    <a class="show-crud-modal" href="#" data-object="<?php echo e('show-'.$className); ?>" data-url="<?php echo e(route($route.'.show', $model->id)); ?>" title="<?php echo e(__('Show')); ?>"><i class="fas fa-search-plus mx-1"></i></a>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($permission.'-edit')): ?>
    <a class="show-crud-modal" data-object="<?php echo e('edit-'.$className); ?>" data-url="<?php echo e(route($route.'.edit', $model->id)); ?>" href="#" title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt mx-1"></i></a>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($permission.'-delete')): ?>
    <a href="#" class="modal-delete" data-object="<?php echo e('delete-'.$className); ?>" data-url="<?php echo e(route($route.'.destroy', $model->id)); ?>" title="<?php echo e(__('Delete')); ?>"><i class="fas fa-trash-alt mx-1"></i></a>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($permission.'-list')): ?>
    <a href="#" onclick="return history('<?php echo route('histories.index', ['model_type'=>get_class($model), 'model_id'=>$model->id]); ?>')" title="<?php echo e(__('History')); ?>"><i class="fas fa-microscope mx-1"></i></a>
<?php endif; ?>
<?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.2\GSES 2.0\resources\views/layouts/ajax-index-actions.blade.php ENDPATH**/ ?>