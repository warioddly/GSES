@php
    $count = $material->words()->where('type_id', '=', 3)->count();
@endphp
@if ($count > 0)
<a href="{{route('materials.content', $material->id)}}"><span class="badge badge-danger" title="{{__('Keywords')}}">{{$count}}</span></a>
@elseif (trim($material->file_text))
<a href="{{route('materials.content', $material->id)}}">{{__('Analyze')}}</a>
@endif
