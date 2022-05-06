@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Edit Material')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="{{ route('modules.marker_black_words.index') }}"> {{__('Close')}}</a>
                <button type="submit" class="btn btn-primary" form="black-world-form">{{__('Save')}}</button>
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

    {!! Form::model($markerBlackWord, ['id'=>'black-world-form', 'method' => 'PATCH', 'route' => ['modules.marker_black_words.update', $markerBlackWord->id], 'enctype'=>'multipart/form-data']) !!}
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
                    {{AppHelper::textBlade('word', __('Word'), null, true)}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::textBlade('comment', __('Comment'), null, false)}}
                </div>
                <div class="col-md-12 px-md-5 form-multi-field">
                    {{AppHelper::textareaBlade('declension', __('Declension'), null, false, false)}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::selectBlade('terminology_id', __('Terminology'), [null=>__('Search for an item')] + $terminologies, null, true)}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::selectBlade('language_id', __('Language'), [null=>__('Search for an item')] + $languages, null, true)}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::selectBlade('status_id', __('Status'), [null=>__('Search for an item')] + $statuses), null, true}}
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="panel">
        <div class="panel-footer bg-white border-none">
            <div class="row">
                <div class="col-md-12 py-md-3 px-md-5 text-right">
                    <a href="{{ route('modules.marker_black_words.index') }}" class="btn btn-secondary">{{__('Close')}}</a>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}



@endsection
