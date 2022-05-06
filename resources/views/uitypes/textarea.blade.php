



<div class="form-group form-animate-text @error($fieldName) form-animate-error @enderror">
    {!! Form::textarea($fieldName, $value, array('class' => 'form-text'.($errors->has($fieldName)?' error':''))+($required?['required']:[])+($readonly?['readonly']:[])) !!}
    <span class="bar"></span>
    <label>{{$label}}</label>
    @error($fieldName)
    <em class="error">{{ __($message) }}</em>
    @enderror
</div>
