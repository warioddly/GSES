<div class="form-group form-animate-text @error($fieldName) form-animate-error @enderror">
    @if($type=='text')
        {!! Form::text($fieldName, $value, array('class' => 'form-text'.($errors->has($fieldName)?' error':''))+($required?['required']:[])+($readonly?['readonly']:[])) !!}
    @elseif($type=='tel')
        {!! Form::tel($fieldName, $value, array(
                                                    'class' => 'form-text'.($errors->has($fieldName)?' error':''))+
                                                    ($required?['required']:[])+
                                                    ($readonly?['readonly']:[])) !!}
    @else
        {!! Form::email($fieldName, $value, array(
                                                    'class' => 'form-text'.($errors->has($fieldName)?' error':''))+
                                                    ($required?['required']:[])+
                                                    ($readonly?['readonly']:[])) !!}
    @endif
    <span class="bar"></span>
    <label>{{$label}}</label>
    @error($fieldName)
    <em class="error">{{ __($message) }}</em>
    @enderror
</div>
@push('page-scripts')
    <script>
        $(document).ready(function () {
            $.mask.definitions['9'] = '';
            $.mask.definitions['d'] = '[0-9]';
            $('input[type="tel"]').mask("996ddddddddd").change();
        })
    </script>
@endpush
