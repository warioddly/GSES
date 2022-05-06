<div class="form-group form-animate-text @error($fieldName) form-animate-error @enderror"
       >
    {!! Form::file($fieldName, array('class' => 'form-text', 'style'=>'opacity:0;position:absolute;z-index:1;')+($required?['required']:[])) !!}
    <div class="input-group">
        @if ($document != null)
            {!! Form::hidden(str_replace(']_id', '_id]', $fieldName.'_id'), $document->id, array('class' => 'form-text file-id')) !!}
            <input type="text" class="form-text file-name{{$errors->has($fieldName)?' error':''}}"
                   value="{{$document->name}}" readonly>
            <span class="input-group-addon"><i class="fas fa-paperclip" title="{{__('Choose')}}"></i></span>
            <span class="input-group-addon file-clear" style="z-index: 2;position: sticky;background: none;"><i
                        class="fas fa-times" title="{{__('Clear')}}"></i></span>
            <span class="input-group-addon file-download" style="z-index: 2;position: sticky;background: none;"><a
                        href="{{route('download-file', $document->name_uuid)}}" target="_blank"
                        title="{{__('Download')}}"
                        style="color:#555555;"><i class="fas fa-download"></i></a></span>
        @else
            <input type="text" class="form-text file-name{{$errors->has($fieldName)?' error':''}}" value="" readonly>
            <span class="input-group-addon"><i class="fas fa-paperclip" title="{{__('Choose')}}"></i></span>
            <span class="input-group-addon file-clear"
                  style="z-index: 2;position: sticky;background: none;display:none;"><i class="fas fa-times"
                                                                                        title="{{__('Clear')}}"></i></span>
        @endif
    </div>
    <span class="bar"></span>
    <label>{{$label}}</label>
    @error($fieldName)
    <em class="error">{{ __($message) }}</em>
    @enderror
</div>

@push('page-scripts')
    <script>
        $('input[name="{{ $fieldName }}"]').parent().find('.file-clear').click(function () {
            $(this).closest('.form-group').find('input[type="file"]').val('').trigger('change');
        });
        $('input[name="{{$fieldName}}"]').change(function () {
            if (this.files.length > 0) {
                var fileName = [];
                for (var file of this.files) {
                    fileName.push(file.name);
                }
                $(this).parent().find('.file-id').val('');
                $(this).parent().find('.file-name').val(fileName.join(', '));
                $(this).parent().find('.file-clear').show();
                $(this).parent().find('.file-download').show();
            } else {
                $(this).parent().find('.file-id').val('');
                $(this).parent().find('.file-name').val('');
                $(this).parent().find('.file-clear').hide();
                $(this).parent().find('.file-download').hide();
            }
        });
    </script>
@endpush
