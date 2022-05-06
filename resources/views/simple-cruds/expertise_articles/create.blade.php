@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Create New article')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="{{ route('modules.expertiseArticles.index') }}"> {{__('Close')}}</a>
                <button type="submit" class="btn btn-primary" form="article-form">{{__('Save')}}</button>
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

    {!! Form::open(array('id'=>'article-form', 'route' => 'modules.expertiseArticles.store','method'=>'POST', 'enctype'=>'multipart/form-data')) !!}

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
                        {{AppHelper::textBlade('title', __('Expertise article'), null, true)}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 panel-footer bg-white border-none">
            <div class="row">
                <div class="col-md-12 py-md-3 px-md-5 text-right">
                    <a href="{{ route('modules.expertiseArticles.index') }}" class="btn btn-secondary">{{__('Close')}}</a>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@endsection
@push('page-scripts')
    <script>

    </script>
@endpush
