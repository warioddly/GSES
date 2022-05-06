@extends('layouts.modal')

@section('content')
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="analyzeEditModalLabel">{{__('Show Material')}}</h4>
</div>
<div class="modal-body p-0">
    <div class="panel m-0">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#create-conclusion-modal" aria-expanded="true"
                   aria-controls="collapse1"
                   class="">
                    <h4>{{__('Basic information')}}</h4>
                </a>
            </div>
        </div>
        <div id="create-conclusion-modal" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1"
             aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Name'), $material->name)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Object type'), $material->objectType->title)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Type'),  $material->type->title)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Source'),  $material->source)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Language'), $material->language->title)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('File'), $material->file)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Status'), $material->status->title)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Creator'),  $material->creator->last_name.' '.$material->creator->name.' '.$material->creator->middle_name)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Created at'), $material->created_at->format('d-m-Y'))}}
                    </div>
                    @if ($material->images()->count())
                    <div class="col-xs-12 col-sm-12 col-md-12 whitespace-pre-line">
                        {{AppHelper::showBlade(__('Material images'), $material->images()->get()->all())}}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="show-crud-modal btn btn-primary" href="#" data-object="edit-Material"
        data-url="{{ route('expertise.modal.materials.edit', $material->id) }}">
        {{ __('Edit') }}
    </a>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
</div>
@endsection
