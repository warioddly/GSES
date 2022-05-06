@extends('layouts.modal')

@section('content')
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="analyzeEditModalLabel">{{__('Edit Material')}}</h4>
</div>
<div class="modal-body p-0">
    {!! Form::model($material, ['id'=>'modal-form', 'method' => 'PATCH', 'route' => ['expertise.modal.materials.update',$material->id], 'enctype'=>'multipart/form-data']) !!}
    <div class="panel m-0">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#edit-material-modal1" aria-expanded="true" aria-controls="collapse1"
                   class="">
                    <h4>{{__('Basic information')}}</h4>
                </a>
            </div>
        </div>
        <div id="edit-material-modal1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1"
             aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::textBlade('name', __('Material name'), null, true)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::dependedSelectBlade('object_type_id', __('Object type'), [null=>__('Search for an item')]+$objectTypes, null,true)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::dependedSelectBlade('type_id', __('Source'), [null=>__('Search for an item')]+$types, null,true, 'object_type_id', $typeRelation,'#CRUD-modal')}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::textBlade('source', __('Material source'), null, true)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::selectBlade('language_id', __('Language'), [null=>__('Search for an item')]+$languages, null,true)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::selectBlade('status_id', __('Status'), [null=>__('Search for an item')]+$statuses, null,true)}}
                    </div>
                    <input type="hidden" name="expertise_id" value="{{ $expertise_id }}">
                </div>
            </div>
        </div>
    </div>

    <div class="panel m-0">
        <div class="panel-heading">
            <div class="panel-title" style="display: flex; justify-content: space-between; align-items: center">
                <a role="button" data-toggle="collapse" href="#edit-material-modal2" aria-expanded="true" aria-controls="collapse2"
                    class="" style="flex-grow: 1">
                    <h4>{{__('Document')}}</h4>
                </a>
                <div class="fileTextEvents mx-3">
                    <a href="#" class="resizeFull m-1 p-1" style="color: inherit" title="{{ __('Fullscreen') }}">
                        <i class="glyphicon glyphicon-resize-full" />
                    </a>
                    <a href="#" class="resizeSmall m-1 p-1 hidden" style="color: inherit" title="{{ __('Unfullscreen') }}">
                        <i class="glyphicon glyphicon-resize-small" />
                    </a>
                    <a href="#" class="compare m-1 p-1" style="color: inherit" title="{{ __('Compare') }}">
                        <i class="glyphicon glyphicon-transfer" />
                    </a>
                </div>
            </div>
        </div>
        <div id="edit-material-modal2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading2" aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::fileBlade('file', __('Attach source file'), $material->file, false)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::textBlade('file_text_comment', __('Commentary on the recognized material'))}}
                    </div>
                    <div class="col-md-12 px-md-5 form-multi-field">
                        {{AppHelper::textareaBlade('file_text', __('Recognized material'))}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
</div>
<div class="modal-footer">
    <a href="{{route('materials.edit', $material->id)}}" class="btn btn-danger" target="_blank">{{__('Go to the material')}}</a>
    <button type="submit" form="modal-form" class="btn btn-primary">{{__('Save')}}</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
</div>
@endsection

@push('page-scripts')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('input[name="file"]').change(function(){
            if (this.files.length > 0) {
                if(this.files[0].name.substr(this.files[0].name.length - 4)=='.zip'){
                    alert('{{__("When changing the material, you can not use the archive")}}');
                    $(this).val('').trigger('change');
                    return;
                }
                startPreloader();
                var form_data = new FormData();
                form_data.append('file', this.files[0]);
                $.ajax({
                    url: '{{route('materials.analyzes.extract')}}', // <-- point to server-side PHP script
                    dataType: 'json',  // <-- what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function (data) {
                        stopPreloader();
                        if (!data.result_array.error) {
                            $('textarea[name="file_text"]').text(data.result_array.file_text);
                        } else {
                            $('textarea[name="file_text"]').text('');
                            alert(data.result_array.error);
                        }
                    }
                });
            }
            else {
                $('textarea[name="file_text"]').text('');
            }
        });

        $('.fileTextEvents > .resizeFull').click(function(e) {
            e.preventDefault();
            const fileText = $('textarea[name=file_text]');

            $('#modal-form > .panel').addClass('hidden');
            fileText.parents('.panel').removeClass('hidden');
            fileText.attr('rows', 20);
            $(this).addClass('hidden');
            $('.fileTextEvents > .resizeSmall').removeClass('hidden');
        });
        $('.fileTextEvents > .resizeSmall').click(function(e) {
            e.preventDefault();
            const fileText = $('textarea[name=file_text]');

            $('#modal-form > .panel').removeClass('hidden');
            fileText.attr('rows', 10);
            $(this).addClass('hidden');
            $('.fileTextEvents > .resizeFull').removeClass('hidden');
        });
        $('.fileTextEvents > a.compare').click(function(e) {
            e.preventDefault();
            console.log($(e.target));
        });
    </script>

@endpush
