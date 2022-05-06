@php
$fullClassName = get_class($model);
$className =str_replace('App\Models\\', '', $fullClassName);
@endphp
@can($permission.'-list')
    <a class="show-crud-modal" href="#" data-object="{{ 'show-'.$className }}" data-url="{{ route($route.'.show', $model->id) }}" title="{{__('Show')}}"><i class="fas fa-search-plus mx-1"></i></a>
@endcan
@can($permission.'-edit')
    <a class="show-crud-modal" data-object="{{ 'edit-'.$className }}" data-url="{{ route($route.'.edit', $model->id) }}" href="#" title="{{__('Edit')}}"><i class="fas fa-pencil-alt mx-1"></i></a>
@endcan
@can($permission.'-delete')
    <a href="#" class="modal-delete" data-object="{{ 'delete-'.$className }}" data-url="{{ route($route.'.destroy', $model->id) }}" title="{{__('Delete')}}"><i class="fas fa-trash-alt mx-1"></i></a>
@endcan
@can($permission.'-list')
    <a href="#" onclick="return history('{!! route('histories.index', ['model_type'=>get_class($model), 'model_id'=>$model->id]) !!}')" title="{{__('History')}}"><i class="fas fa-microscope mx-1"></i></a>
@endcan
