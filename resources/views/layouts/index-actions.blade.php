@can($permission.'-list')
    <a href="{{route($route.'.show',$model->id)}}" title="{{__('Show')}}" class="row-show"><i class="fas fa-search-plus mx-1"></i></a>
@endcan
@can($permission.'-edit')
    <a href="{{route($route.'.edit',$model->id)}}" title="{{__('Edit')}}" class="row-edit"><i class="fas fa-pencil-alt mx-1"></i></a>
@endcan
@can($permission.'-delete')
    {!! Form::open(['method' => 'DELETE','route' => [$route.'.destroy', $model->id],'style'=>'display:inline']); !!}
    {!! Form::button('<i class="fas fa-trash-alt"></i>', ['type'=>'submit', 'class' => 'btn btn-danger hidden', 'title'=>__('Delete'), 'onclick'=>"return confirm('".__('Are you sure want to delete this?')."')"]); !!}
    <a href="#" onclick="$(this).prev().click()" title="{{__('Delete')}}" class="row-delete"><i class="fas fa-trash-alt mx-1"></i></a>
    {!! Form::close(); !!}
@endcan
@can($permission.'-list')
    @if (method_exists($model, 'histories'))
        <a href="#" onclick="return history('{!! route('histories.index', ['model_type'=>get_class($model), 'model_id'=>$model->id]) !!}')" title="{{__('History')}}" class="row-history"><i class="fas fa-microscope mx-1"></i></a>
    @elseif(method_exists($model, 'operations'))
        <a href="#" onclick="return history('{!! route('histories.index', ['model_type'=>get_class($model), 'model_id'=>$model->id]) !!}')" title="{{__('History')}}" class="row-history"><i class="fas fa-history mx-1"></i></a>
    @endif
@endcan
