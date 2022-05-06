



<div class="form-group form-animate-text @error($fieldName) form-animate-error @enderror">
    {!! Form::password($fieldName, array('class' => 'form-text'.($errors->has($fieldName)?' error':''))+($required?['required']:[])) !!}
    <span class="bar"></span>
    <label>{{$label}}</label>
    @error($fieldName)
    <em class="error">{{ __($message) }}</em>
    @enderror
</div>
