

@can('material-content-analyze')
@if ($material_word->type_id == 1)
    <button class="btn btn-circle btn-20 btn-success" onclick="add_word('{{$material_word->id}}', 2, 0, event)" title="{{__('Move to stop words')}}"><i class="fas fa-arrow-down"></i></button>
    <button class="btn btn-circle btn-20 btn-danger" onclick="add_word('{{$material_word->id}}', 3, 0, event)" title="{{__('Move to keywords')}}"><i class="fas fa-arrow-down"></i></button>
@elseif ($material_word->type_id == 2)
    <button class="btn btn-circle btn-20 btn-primary" onclick="add_word('{{$material_word->id}}', 1, 0, event)" title="{{__('Delete from stop words')}}"><i class="fas fa-arrow-up"></i></button>
    <button class="btn btn-circle btn-20 btn-danger" onclick="add_word('{{$material_word->id}}', 3, 0, event)" title="{{__('Move to keywords')}}"><i class="fas fa-arrow-down"></i></button>
    @if ($material_word->word->type_id == 1)
        <button class="btn btn-circle btn-20 btn-success float-right" onclick="add_word('{{$material_word->id}}', 0, 2,event)" title="{{__('Make this global')}}"><i class="fas fa-globe-asia"></i></button>
    @else
        <button class="btn btn-circle btn-20 btn-danger float-right" onclick="add_word('{{$material_word->id}}', 0, 1,event)" title="{{__('Make this local')}}"><i class="fas fa-globe-asia"></i></button>
    @endif
@elseif ($material_word->type_id == 3)
    <button class="btn btn-circle btn-20 btn-primary" onclick="add_word('{{$material_word->id}}', 1, 0, event)" title="{{__('Delete from keywords')}}"><i class="fas fa-arrow-up"></i></button>
    <button class="btn btn-circle btn-20 btn-success" onclick="add_word('{{$material_word->id}}', 2, 0, event)" title="{{__('Move to stop words')}}"><i class="fas fa-arrow-up"></i></button>
    @if ($material_word->word->type_id == 1)
        <button class="btn btn-circle btn-20 btn-success float-right" onclick="add_word('{{$material_word->id}}', 0, 3, event)" title="{{__('Make this global')}}"><i class="fas fa-globe-asia"></i></button>
    @else
        <button class="btn btn-circle btn-20 btn-danger float-right" onclick="add_word('{{$material_word->id}}', 0, 1, event)" title="{{__('Make this local')}}"><i class="fas fa-globe-asia"></i></button>
    @endif
@endif
@endcan
