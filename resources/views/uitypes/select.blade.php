<div class="form-group form-animate-text @error($fieldName) form-animate-error @enderror">
    {!! Form::select($fieldName, $options, $value, array('class' => 'form-control js-states select2'.($errors->has($fieldName)?' error':''))+($required?['required']:[])+($readonly?['readonly']:[])+($ajax?['data-ajax'=>$ajax]:[])) !!}
    <span class="bar"></span>
    <label>{{$label}}</label>
    @error($fieldName)
    <em class="error">{{ __($message) }}</em>
    @enderror
</div>
@push('page-scripts')
<script>
    @if ($ajax)
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $('select[name="{{ $fieldName }}"]').select2({
        ajax: {
            url: '{{$ajax}}',
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    _token: CSRF_TOKEN,
                    search: params.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        },
        placeholder: '{{__('Search for an item')}}',
        allowClear: true,
        theme: 'default',
        width: '100%'
    });
    @else
    $('select[name="{{ $fieldName }}"]').select2({
        placeholder: '{{__('Search for an item')}}',
        theme: 'default',
        allowClear: true,
        width: '100%'
    });
    @endif
</script>
@endpush
