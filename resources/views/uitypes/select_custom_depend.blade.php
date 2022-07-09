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

    .select2-container--default .select2-results__group[aria-disabled=true]{
        display: none;
    }

    .select2-container .select2-selection--single .select2-selection__clear{
        font-size: 1.5em;
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
            let childDependencyRelation = @json($childOptionRelation);
            let types = @json($types);
            let childTypes = @json($childOption);
            let typesVal = [];
            let childTypeVal = [];
            let selectedId = $(this).find(":selected").val();
            for (const [key, value] of Object.entries(dependencyRelation)) {
                if (value[0] == selectedId) {
                    typesVal.push(types[value[1]].trimEnd());
                    for (const [key_2, value_2] of Object.entries(childDependencyRelation)) {
                        if (value[1] == value_2[0]) {
                            childTypeVal.push(childTypes[value_2[1]].trimEnd());
                        }
                    }
                }
            }

            currentSelect.val("");
            currentSelect.find('option').prop('disabled', true);
            currentSelect.find('optgroup').prop('disabled', true);

            currentSelect.find('optgroup').each(function (index_1, elementOptgroup) {
                if (typesVal.includes(elementOptgroup.label) || elementOptgroup.label == '') {
                    $(elementOptgroup).prop('disabled', false);

                    $(elementOptgroup).find('option').each(function (index_2, elementOption) {
                        if (childTypeVal.includes(elementOption.label) || elementOption.label == '') {
                            $(elementOption).prop('disabled', false);
                        }
                    });
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
            let childDependencyRelation = @json($childOptionRelation);
            let types = @json($types);
            let childTypes = @json($childOption);
            let typesVal = [];
            let childTypeVal = [];
            let selectedId = parentSelect.val();
            for (const [key, value] of Object.entries(dependencyRelation)) {
                if (value[0] == selectedId) {
                    typesVal.push(types[value[1]].trimEnd());
                    for (const [key_2, value_2] of Object.entries(childDependencyRelation)) {
                        if (value[1] == value_2[0]) {
                            childTypeVal.push(childTypes[value_2[1]].trimEnd());
                        }
                    }
                }
            }

            currentSelect.val("");
            currentSelect.find('option').prop('disabled', true);
            currentSelect.find('optgroup').prop('disabled', true);

            currentSelect.find('optgroup').each(function (index_1, elementOptgroup) {
                if (typesVal.includes(elementOptgroup.label) || elementOptgroup.label == '') {
                    $(elementOptgroup).prop('disabled', false);

                    $(elementOptgroup).find('option').each(function (index_2, elementOption) {
                        if (childTypeVal.includes(elementOption.label) || elementOption.label == '') {
                            $(elementOption).prop('disabled', false);
                        }
                    });
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
