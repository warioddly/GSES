<div class="select_text form-group form-animate-text @error($fieldName) form-animate-error @enderror">
    {!! Form::text($fieldName, $value, ['class' => 'hidden']) !!}
    {!!
        Form::text($fieldName.'_text', null, [
            'class' => 'form-text'.($errors->has($fieldName)?' error':''),
            'required' => $required,
            'readonly' => $readonly
        ])
    !!}
    <ul class="list-group hidden">
        @foreach ($options as $id => $option)
            @if($loop->index > 0)
            <a href="#" class="list-group-item hidden" data-id="{{ $id }}">
                {{ $option['title'][app()->getLocale()] }}
            </a>
            @endif
        @endforeach
    </ul>
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
            let listJson = @json($options);
            const list = $('.modal .select_text .list-group');
            const field = $('.modal input[name="{{ $fieldName }}"]');
            const text = $('.modal input[name="{{ $fieldName }}_text"]');
            const type = $('.modal select[name="type_id"]');

            function select(typedText, clear = true) {
                typedText = !typedText ? '' : typedText.trim();
                if (clear && typedText && typedText.length > 1) {
                    field.val('');
                }

                list.children().each(function(k, v) {
                    const itemText = $(v).text().trim();
                    if (
                        typedText && typedText.length > 1 &&
                        itemText.toLowerCase().includes(typedText.toLowerCase()) &&
                        type.val() == listJson[$(v).attr('data-id')].type_id
                    ) {
                        $(v).click(function(e) {
                            e.preventDefault();

                            text.val(itemText);
                            field.val($(e.target).attr('data-id'));
                        });
                        $(v).removeClass('hidden');
                    } else {
                        $(v).addClass('hidden');
                    }
                });
            }

            text.on('keyup focusin', function(e) {
                if (timer) {
                    clearTimeout(timer);
                }

                timer = setTimeout(function() {
                    select($(e.target).val(), e.type === 'focusin' ? false : true);
                }, 500);

                list.removeClass('hidden');
            });

            $('body').click(function(e) {
                if ($(e.target).attr('name') != '{{ $fieldName }}_text') {
                    list.addClass('hidden');
                }
            });
        });
    })(jQuery);
</script>
@endpush
