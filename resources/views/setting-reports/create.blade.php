@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Create New Settings Report')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="{{ route('settings.reports.index') }}"> {{__('Close')}}</a>
                <button type="submit" class="btn btn-primary" form="settings-reports-form">{{__('Save')}}</button>
            </h3>
        </div>
    </div>
@endsection

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>{{__('Whoops!')}}</strong> {{__('There were some problems with your input.')}}
        </div>
    @endif

    {!! Form::open(array('id'=>'settings-reports-form', 'route' => 'settings.reports.store','method'=>'POST', 'enctype'=>'multipart/form-data')) !!}

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
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::textBlade('name', __('Report name'), null, true)}}
                </div>
                <div class="col-md-12 px-md-5 form-multi-field">
                    {{AppHelper::textareaBlade('query', __('Report query'), null, true, false)}}
                </div>
                <div class="col-md-12 px-md-5 form-multi-field">
                    {{AppHelper::textareaBlade('template', __('Report template'), null, false, false)}}
                </div>
                <div class="col-md-12 px-md-5 form-multi-field">
                    {{AppHelper::textareaBlade('description', __('Report description'), null, false, false)}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::selectBlade(
                        'status_id',
                        __('Status'),
                        [null=>__('Search for an item')]+$statuses, null, true)}}
                </div>
            </div>
        </div>
        </div>
        <div class="col-md-12 panel-footer bg-white border-none">
            <div class="row">
                <div class="col-md-12 py-md-3 px-md-5 text-right">
                    <a href="{{ route('settings.reports.index') }}" class="btn btn-secondary">{{__('Close')}}</a>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}



@endsection
