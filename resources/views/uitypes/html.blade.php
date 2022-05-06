



<div class="form-group form-animate-text @error($fieldName) form-animate-error @enderror">
    {!! Form::textarea($fieldName, $value, array('class' => 'hide form-text'.($errors->has($fieldName)?' error':''), 'readonly')) !!}
    <div class="html-element form-text" tabindex="0">{!! $value !!}</div>
    <span class="bar"></span>
    <label>{{$label}}</label>
    @error($fieldName)
    <em class="error">{{ __($message) }}</em>
    @enderror
</div>
