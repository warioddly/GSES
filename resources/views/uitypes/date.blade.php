



<div class="form-group form-animate-text @error($fieldName) form-animate-error @enderror">
    {!! Form::text($fieldName, $value, array('autocomplete'=>'off', 'class' => 'form-text datepicker'.($errors->has($fieldName)?' error':''))+($required?['required']:[])+($readonly?['readonly']:[])) !!}
    <span class="bar"></span>
    <label>{{$label}}</label>
    @error($fieldName)
    <em class="error">{{ __($message) }}</em>
    @enderror
</div>

@push('page-scripts')
<script>
    var lang = $('html').attr('lang');
    $.datetimepicker.setLocale(lang);

    $('input[name="{{ $fieldName }}"]').datetimepicker({
        timepicker: false,
        mask: '39-19-9999',
        format: 'd-m-Y',
        dayOfWeekStart: 1
    }).each(function(){ if (this.value == '__-__-____') $(this).val(''); });

    $('.datetimepicker').datetimepicker({
        timepicker: true,
        mask: '39-19-9999 29:59',
        format: 'd-m-Y H:i',
        dayOfWeekStart: 1
    }).each(function(){ if (this.value == '__-__-____ __:__') $(this).val(''); });
</script>
@endpush
