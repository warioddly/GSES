@extends('layouts.modal')

@section('content')
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="analyzeEditModalLabel">{{__('Create сourt decision')}}</h4>
</div>
<div class="modal-body p-0">
    {!! Form::open(['id'=>'modal-form', 'method' => 'POST', 'route' => 'expertise.modal.decisions.store', 'enctype'=>'multipart/form-data']) !!}
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
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::dependedSelectBlade(
                            'court_id',
                            __('Court'),
                            [null=>__('Search for an item')]+$courtDecision,
                            null,
                            true
                           )}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::dependedSelectBlade(
                                'court_name_id',
                                __('Court name'),
                                [null=>__('Search for an item')] + $courtNames,
                                null,
                                true, 'court_id', $courtRelation, '#CRUD-modal')}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::dateBlade('date', __('Date'), null, true)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::textBlade('comment', __('Comment'), null, false)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::fileBlade('file', __('Attach source file'), null, true)}}
                    </div>
                    <input type="hidden" name="expertise_id" value="{{ $expertise_id }}">
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
</div>
<div class="modal-footer">
    <button type="submit" form="modal-form" class="btn btn-primary">{{__('Create')}}</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
</div>
@endsection
