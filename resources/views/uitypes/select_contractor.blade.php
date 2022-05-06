@can('contractor-create')
    <div class="form-group form-animate-text @error($fieldName) form-animate-error @enderror contractor-form-group">
        <div class="input-group">
            {!! Form::select($fieldName, $options, $value, array('class' => 'form-control contractor-select js-states select2'.($errors->has($fieldName)?' error':''))+($required?['required']:[])+($readonly?['readonly']:[])+($ajax?['data-ajax'=>$ajax]:[])) !!}
            <div class="input-group-btn">
                <button id="show-contractor-modal" type="button" class="btn btn-secondary">
                    <i class="fas fa-plus"></i></button>
            </div>
        </div>
        <label>{{$label}}</label>
        @error($fieldName)
        <em class="error">{{ __($message) }}</em>
        @enderror
    </div>
    <div class="modal fade" id="create-contractor-modal" tabindex="-1" role="dialog"
         aria-labelledby="analyzeEditModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>
@else
    <div class="form-group form-animate-text @error($fieldName) form-animate-error @enderror">
        {!! Form::select($fieldName, $options, $value, array('class' => 'form-control js-states select2'.($errors->has($fieldName)?' error':''))+($required?['required']:[])+($readonly?['readonly']:[])+($ajax?['data-ajax'=>$ajax]:[])) !!}
        <span class="bar"></span>
        <label>{{$label}}</label>
        @error($fieldName)
        <em class="error">{{ __($message) }}</em>
        @enderror
    </div>
@endcan

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
        });
        @else
        $('select[name="{{ $fieldName }}"]').select2({
            placeholder: '{{__('Search for an item')}}',
            theme: 'default',
            allowClear: true,
        });
        @endif
    </script>
    @can('contractor-create')
        <script>
            $('#show-contractor-modal').click(function () {
                startPreloader();
                $.ajax({
                    method: 'get',
                    url: '{{ route('modal-contractors.create') }}',
                    success: (data) => {
                        $('#create-contractor-modal .modal-content').html(data);
                        $('#create-contractor-modal').modal('show');
                        stopPreloader();
                    },
                    error: function (error) {
                        alert('Server error:' + error.status);
                    }
                });
                return false;
            })
        </script>
        <script>
            $(document).on('change', '#create-contractor-accordion select[name=type_id]', function () {
                type_id = $(this).val();
                if (type_id == 1) {
                    $('.type-depended-elements').show();
                    $('.type-depended-elements').each(function (i, el) {
                        $(el).find('input');
                        $(el).find('select').prop('required', true);
                    });
                }
                if (type_id == 2) {
                    $('.type-depended-elements').each(function (i, el) {
                        $(el).find('input').val(null);
                        $(el).find('select').val('').removeAttr('required');
                        $(el).find('select').select2('destroy').select2({
                            placeholder: '{{__('Search for an item')}}',
                            theme: 'default',
                            allowClear: true,
                            width: '100%'
                        });
                        $(el).find('.select_text > input').val('').removeAttr('required');
                    });
                    $('.type-depended-elements').hide();
                }
                if (type_id == 3) {
                    $('.type-depended-elements').show();
                    $('.type-depended-elements').each(function (i, el) {
                        let input = $(el).find('input');
                        $(el).find('select').prop('required', true);

                        if (input && input.length && input[0].name === 'sub_organ') {
                            $(input[0]).val('').removeAttr('required');
                            $(el).hide();
                        }
                    });
                }
            });
        </script>
        <script>
            $('#create-contractor-modal').on('submit', '#modal-form', function (e) {
                startPreloader();
                $('.ajax-modal-error').remove();
                e.preventDefault();
                $.ajax({
                    method: 'post',
                    url: $(this).attr('action'),
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: (data) => {
                        stopPreloader();
                        $('.contractor-select').append(`<option value="${data.id}" selected>${data.name}</option>`);
                        $('.contractor-select').select2('destroy').select2({
                            placeholder: '{{__('Search for an item')}}',
                            theme: 'default',
                            allowClear: true,
                        });
                        $('#create-contractor-modal').modal('hide');
                        $('#create-contractor-modal .modal-content').empty();
                    },
                    error: function (error) {
                        stopPreloader();
                        if (error.status === 422) {
                            $.each(error.responseJSON.errors, function (i, error) {
                                var el = $('#create-contractor-modal').find('[name="' + i + '"]');
                                el.parent().append($('<em class="ajax-modal-error error">' + error[0] + '</em>'));
                                $('#create-contractor-modal').scrollTop(0);
                            });
                        } else {
                            alert('Server error:' + error.status);
                        }

                    }
                });
                return false;
            })
        </script>
    @endcan
@endpush
