@extends('layouts.modal')

@section('content')
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="analyzeEditModalLabel">{{__('Edit Decision')}}</h4>
</div>
<div class="modal-body p-0">
    {!! Form::model($decision, ['id'=>'modal-form', 'method' => 'PATCH', 'route' => ['material.modal.decisions.update',$decision->id], 'enctype'=>'multipart/form-data']) !!}
    <div class="panel m-0">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#create-conclusion-modal" aria-expanded="true" aria-controls="collapse1"
                   class="">
                    <h4>{{__('Basic information')}}</h4>
                </a>
            </div>
        </div>
        <div id="create-conclusion-modal" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1"
             aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::selectBlade('article_id', __('Article'), [null=>__('Search for an item')]+$articles, null,true)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::selectBlade('court_decision_id', __('Material classification'), [null=>__('Search for an item')]+$courtDecision, null,true)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::selectBlade('status_id', __('Status'), [null=>__('Search for an item')]+$statuses, null,true)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::dateBlade('date', __('Date court decision'), $decision->date->format('d-m-Y'), true)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::textBlade('comment', __('Comment'), null, false)}}
                    </div>
                    <input type="hidden" name="material_id" value="{{ $material_id }}">
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
</div>
<div class="modal-footer">
    <button type="submit" form="modal-form" class="btn btn-primary">{{__('Save')}}</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
</div>
@endsection
