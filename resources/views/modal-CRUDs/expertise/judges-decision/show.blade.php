@extends('layouts.modal')

@section('content')
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="analyzeEditModalLabel">{{__('Show Decision')}}</h4>
</div>
<div class="modal-body p-0">
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
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Material'), $decision->expertise->name)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Court'), $decision->court->title)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Court name'), $decision->courtName->title)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Date exp court decision'), $decision->date->format('d-m-Y'))}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Comment'), $decision->comment)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('File'), $decision->file)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Creator'), $decision->creator()->value(DB::raw("GROUP_CONCAT(CONCAT_WS(' ', last_name, name, middle_name) SEPARATOR ', ')")))}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Created at'), $decision->created_at->format('d-m-Y'))}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
</div>
@endsection

