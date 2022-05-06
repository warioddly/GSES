@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Edit Subject')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="{{ route('modules.nicknames.index') }}"> {{__('Close')}}</a>
                <button type="submit" class="btn btn-primary" form="modules-nickname-form">{{__('Save')}}</button>
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
    {!! Form::model($nickname, ['id'=>'modules-nickname-form', 'method' => 'PATCH', 'route' => ['modules.nicknames.update', $nickname->id], 'enctype'=>'multipart/form-data']) !!}
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1"
                   class="">
                    <h4>{{__('Basic information')}}</h4>
                </a>
            </div>
        </div>
        <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1"
             aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::textBlade('nickname', __('Subject case'), null, true)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::selectBlade('subject_id', __('Subject'), [null=>__('Search for an item')]+$subjects, true)}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel">
        <div class="panel-footer bg-white border-none">
            <div class="row">
                <div class="col-md-12 py-md-3 px-md-5 text-right">
                    <a href="{{ route('modules.nicknames.index') }}" class="btn btn-secondary">{{__('Close')}}</a>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@endsection
@push('page-scripts')

@endpush
