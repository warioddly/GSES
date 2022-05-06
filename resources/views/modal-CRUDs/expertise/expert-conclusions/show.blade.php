@extends('layouts.modal')

@section('content')
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="analyzeEditModalLabel">{{__('Show Conclusion')}}</h4>
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
                        {{AppHelper::showBlade(__('Material'), $conclusion->material ? $conclusion->material->name : '')}}
                    </div>
                    <!--div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Status'), $conclusion->status->title)}}
                    </div-->
{{--                    <div class="col-xs-12 col-sm-12 col-md-12">--}}
{{--                        {{AppHelper::showBlade(__('Experts'), $conclusion->experts()->select(DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))->pluck('full_name')->all())}}--}}
{{--                    </div>--}}
                    <!--div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Document'), $conclusion->file->name)}}
                    </div-->
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Conclusion'), $conclusion->options()->pluck('title')->all())}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Conclusion text'), $conclusion->result)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Created at'), $conclusion->created_at->format('d-m-Y'))}}
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

