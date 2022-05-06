@if(!empty($marker_word->declensions()))
@foreach($marker_word->declensions()->pluck('word')->all() as $declension)
    <label class="badge badge-success">{{$declension}}</label>
@endforeach
@endif
