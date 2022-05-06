<div class="form-group form-animate-text @error($fieldName) form-animate-error @enderror">
    {!! Form::select($fieldName, $options, $value, array('class' => 'form-control js-states select2'.($errors->has($fieldName)?' error':''))+($required?['required']:[])) !!}
    <span class="bar"></span>
    <label>{{$label}}</label>
    @error($fieldName)
    <em class="error">{{ __($message) }}</em>
    @enderror
</div>
<style>
    .select2-container--default .select2-results__option[aria-disabled=true] {
        display: none;
    }
</style>
@push('page-scripts')
    <script>
        $('select[name="{{ $fieldName }}"]').select2({
            placeholder: '{{__('Search for an item')}}',
            allowClear: true,
            theme: 'default',
            width: '100%',
        });

        @if($parentSelect)

        $('{{ $formArea }} '+'select[name={{ $parentSelect  }}]').change(function () {
            let currentSelect = $('{{ $formArea }} '+'select[name={{ $fieldName }}]');
            let dependencyRelation = @json($dependencies);
            let keys = [];
            let selectedId = $(this).find(":selected").val();
            for (const [key, value] of Object.entries(dependencyRelation)) {
                if (value[0] == selectedId) {
                    keys.push(value[1]);
                }
            }
            currentSelect.val("");
            currentSelect.find('option').prop('disabled', true);

            currentSelect.find('option').each(function () {
                if (keys.includes(parseInt($(this).val())) || $(this).val() == '') {
                    $(this).prop('disabled', false);

                }
            });
            currentSelect.select2('destroy').select2({
                placeholder: '{{__('Search for an item')}}',
                allowClear: true,
                theme: 'default',
                width: '100%',
            });
        });
        //clear all options for create
        $(document).ready(function () {
            let currentSelect = $('{{ $formArea }} '+'select[name={{ $fieldName }}]');
            let parentSelect = $('{{ $formArea }} '+'select[name={{ $parentSelect }}]');
            let dependencyRelation = @json($dependencies);
            let keys = [];
            let selectedId = parentSelect.val();
            for (const [key, value] of Object.entries(dependencyRelation)) {
                if (value[0] == selectedId) {
                    keys.push(value[1]);
                }
            }

            currentSelect.find('option').prop('disabled', true);
            currentSelect.find('option').each(function () {
                if (keys.includes(parseInt($(this).val())) || $(this).val() == '') {
                    $(this).prop('disabled', false);
                }
            });
            currentSelect.select2('destroy').select2({
                placeholder: '{{__('Search for an item')}}',
                allowClear: true,
                theme: 'default',
                width: '100%',
            });
        });
        @endif
    </script>
@endpush
