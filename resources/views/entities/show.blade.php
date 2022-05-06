@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Show Material')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="{{ route('materials.index') }}"> {{__('Close')}}</a>
                @can('material-edit')
                <a class="btn btn-primary" href="{{ route('materials.edit', $material->id) }}"> {{__('Edit')}}</a>
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
                    {{AppHelper::showBlade(__('Material name'), $material->name)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Expertise object'), $material->objectType()->value('title'))}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Material type'), $material->type()->value('title'))}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Registration numbers of the decree (definition)'), $material->decree_reg_number)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Language'), $material->language()->value('title'))}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Material source'), $material->source)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Status'), $material->status()->value('title'))}}
                </div>
            </div>
        </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#collapse2" aria-expanded="true" aria-controls="collapse2" class="">
                    <h4>{{__('Document')}}</h4>
                </a>
            </div>
        </div>
        <div id="collapse2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading2" aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 whitespace-pre-line">
                        {{AppHelper::showBlade(__('File'), $material->file()->first())}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 whitespace-pre-line">
                        {{AppHelper::showBlade(__('Recognized material'), $material->file_text)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 whitespace-pre-line">
                        {{AppHelper::showBlade(__('Commentary on the recognized material'), $material->file_text_comment)}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
