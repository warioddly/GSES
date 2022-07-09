@if($label!='')
<div class="form-group">
    <strong>{{$label}}:</strong>
@endif
    @if(is_object($value) or is_array($value))
        @if ($value instanceof App\Models\Document)
            @if ($value->isImage())
                <a class="thumbnail" style="width: fit-content; max-width: 100%;">
                    <img onclick="ImageToModal2(event)"  src="{{ route('view-file', $value->name_uuid )}}" style="width: inherit;">
                </a>
            @elseif($value->extension == 'mp4' || $value->extension == 'mov' || $value->extension == 'mpeg'
                    || $value->extension == 'avi' || $value->extension == 'ogg' || $value->extension == 'wmv')
                <a onclick="VideoToModal2(event)" class="video" href="{{ route('view-file', $value->name_uuid)}}">{{$value->name}}</a>
            @elseif($value->extension == 'm4a' || $value->extension == 'mp3' || $value->extension == 'flac'
                || $value->extension == 'wav' || $value->extension == 'wma' || $value->extension == 'aac')
                <a onclick="AudioToModal2(event)" class="audio" href="{{ route('view-file', $value->name_uuid)}}">{{$value->name}}</a>
            @else
                <a href="{{ route('download-file', $value->name_uuid)}}">{{$value->name}}</a>
            @endif
        @elseif ($value instanceof App\Models\Material)
                <a href="{{route('materials.show', $value->id)}}" target="_blank">{{$value->name}}</a>
        @elseif(!empty($value))
            @if (end($value) instanceof App\Models\Document)
            <div class="row">
                @foreach($value as $v)
                    <div class="col-xs-6 col-md-1">
                    @if ($v->isImage())
                        <a href="{{route('download-file', $v->name_uuid)}}" class="thumbnail"><img src="{{route('view-file', $v->name_uuid)}}" style="max-width: 100%;" data-holder-rendered="true"></a>
                    @else
                        <a href="{{route('download-file', $v->name_uuid)}}" class="">{{$v->name}}</a>
                    @endif
                    </div>
                @endforeach
            </div>
            @else
                @foreach($value as $v)
                    <label class="badge badge-info">{{ $v }}</label>
                @endforeach
            @endif
        @endif
    @else
    {{ $value }}
    @endif
@if($label!='')
</div>
@endif
