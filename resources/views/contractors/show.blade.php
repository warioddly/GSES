@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Show Contractor')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="{{ route('modules.contractors.index') }}"> {{__('Close')}}</a>
                @can('contractor-edit')
                <a class="btn btn-primary" href="{{ route('modules.contractors.edit', $contractor->id) }}"> {{__('Edit')}}</a>
                @endcan
            </h3>
        </div>
    </div>
@endsection

@section('content')

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1" class="">
                    <h4>{{__('Basic information')}}</h4>
                </a>
            </div>
        </div>
        <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1" aria-expanded="true" style="">
            <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Contractor organ'), $contractor->organ)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Contractor last_name'), $contractor->last_name)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Contractor name'), $contractor->name)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Contractor middle_name'), $contractor->middle_name)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Contractor phone'), $contractor->phone)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Contractor position'), $contractor->position)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Contractor phone'), $contractor->phone)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Contractor email'), $contractor->email)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Contractor creator'), $contractor->creator->name)}}
                </div>
            </div>
        </div>
        </div>
    </div>

{{--    <div class="panel">--}}
{{--        <div class="panel-heading">--}}
{{--            <div class="panel-title">--}}
{{--                <a role="button" data-toggle="collapse" href="#collapse2" aria-expanded="true" aria-controls="collapse2" class="">--}}
{{--                    <h4>{{__('Document')}}</h4>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div id="collapse2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading2" aria-expanded="true" style="">--}}
{{--            <div class="panel-body">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-xs-12 col-sm-12 col-md-12 whitespace-pre-line">--}}
{{--                        {{AppHelper::showBlade(__('File'), $material->file()->first())}}--}}
{{--                    </div>--}}
{{--                    <div class="col-xs-12 col-sm-12 col-md-12 whitespace-pre-line">--}}
{{--                        {{AppHelper::showBlade(__('Recognized material'), $material->file_text)}}--}}
{{--                    </div>--}}
{{--                    <div class="col-xs-12 col-sm-12 col-md-12 whitespace-pre-line">--}}
{{--                        {{AppHelper::showBlade(__('Commentary on the recognized material'), $material->file_text_comment)}}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
