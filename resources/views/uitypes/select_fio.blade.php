<div class="select_fio form-group form-animate-text @error($fieldName) form-animate-error @enderror">
    {!!
        Form::text($fieldName, null, [
            'class' => 'form-text'.($errors->has($fieldName)?' error':''),
            'required' => $required,
            'readonly' => $readonly
        ])
    !!}
    <ul class="list-group hidden"></ul>
    <span class="bar"></span>
    <label>{{$label}}</label>
    @error($fieldName)
    <em class="error">{{ __($message) }}</em>
    @enderror
</div>

@push('page-scripts')
<script>
    (function ($) {
        $(document).ready(function() {
            let timer = null;
            let listJson = [];
            const list = $('.modal .select_fio .list-group');
            const text = $('.modal input[name="{{ $fieldName }}"]');
            const name = $('.modal input[name="name"]');
            const midName = $('.modal input[name="middle_name"]');

            text.on('keyup focusin', function(e) {
                const textValue = $(e.target).val();
                if (timer) {
                    clearTimeout(timer);
                }

                timer = setTimeout(function() {
                    list.children().remove();
                    if (textValue && textValue.length > 2) {
                        $.get('/contractors?searchText=' + $(e.target).val(), function(data) {
                            listJson = data.data;
                            listJson.forEach(function(v, k) {
                                list.append(`
                                    <a href="#" class="list-group-item" data-key="${k}">
                                        ${v.last_name ? v.last_name : ''}
                                        ${v.name ? v.name : ''}
                                        ${v.middle_name ? v.middle_name : ''}
                                    </a>
                                `);
                            });
                            list.children().each(function(k, v) {
                                $(v).click(function(e) {
                                    e.preventDefault();
                                    const key = $(e.target).attr('data-key');
                                    text.val(listJson[key].last_name);
                                    name.val(listJson[key].name);
                                    midName.val(listJson[key].middle_name);
                                });
                            });
                        });
                    }
                    
                }, 500);

                list.removeClass('hidden');
            });

            $('body').click(function(e) {
                if ($(e.target).attr('name') != '{{ $fieldName }}') {
                    list.addClass('hidden');
                }
            });
        });
    })(jQuery);
</script>
@endpush
