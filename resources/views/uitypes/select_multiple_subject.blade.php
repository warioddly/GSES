<div class="form-group form-animate-text @error($fieldName) form-animate-error @enderror">
    {{--    @dd($required)--}}
    <div class="input-group">
        {!! Form::select($fieldName.'[]', $options, $values, array('class' => 'form-control subject_select js-states select2'.($errors->has($fieldName)?' error':''), 'multiple'=>'multiple')+($required?['required']:[])+($ajax?['data-ajax'=>$ajax]:[])) !!}
        <span class="bar"></span>
        <div class="input-group-btn">
            <button id="show-subject-modal" type="button" class="btn btn-secondary">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <label>{{$label}}</label>
        @error($fieldName)
        <em class="error">{{ __($message) }}</em>
        @enderror
        <div class="modal fade" id="create-subject-modal" tabindex="-1" role="dialog"
             aria-labelledby="analyzeEditModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                </div>
            </div>
        </div>
    </div>
</div>

@push('page-scripts')
    <script>
        @if($ajax!=null)
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('select[name="{{ $fieldName.'[]' }}"]').select2({
            ajax: {
                url: '{{ $ajax }}',
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
        $('select[name="{{ $fieldName.'[]' }}"]').select2({
            placeholder: '{{__('Search for an item')}}',
            theme: 'default',
            allowClear: true,
            width: '100%'
        });
        @endif
    </script>
    @can('subject-create')
        <script>
            $('#show-subject-modal').click(function () {
                startPreloader();
                $.ajax({
                    method: 'get',
                    url: '{{ route('modal-subject.create') }}',
                    success: (data) => {
                        $('#create-subject-modal .modal-content').html(data);
                        $('#create-subject-modal').modal('show');
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
            $('#create-subject-modal').on('submit', '#modal-form', function (e) {
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
                        $('.subject_select').append(`<option value="${data.id}" selected>${data.subject_case}</option>`);
                        $('.subject_select').select2('destroy').select2({
                            placeholder: '{{__('Search for an item')}}',
                            theme: 'default',
                            allowClear: true,
                        });
                        $('#create-subject-modal').modal('hide');
                        $('#create-subject-modal .modal-content').empty();
                    },
                    error: function (error) {
                        stopPreloader();
                        if (error.status === 422) {
                            $.each(error.responseJSON.errors, function (i, error) {
                                var el = $('#create-subject-modal').find('[name="' + i + '"]');
                                el.parent().append($('<em class="ajax-modal-error error">' + error[0] + '</em>'));
                                $('#create-subject-modal').scrollTop(0);
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
