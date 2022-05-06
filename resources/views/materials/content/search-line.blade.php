@if (count($lines) > 0)
<div class="list-group">
    @foreach($lines as $line)
    <button type="button" class="list-group-item" onclick="set_position({{$line[1]}})">...{!! $line[0] !!}...</button>
    @endforeach
</div>
@endif
