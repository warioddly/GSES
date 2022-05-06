@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Edit Analyze')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="{{ route('materials.analyzes.index') }}"> {{__('Close')}}</a>
                <button type="submit" class="btn btn-primary" form="analyze-form">{{__('Save')}}</button>
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

    {!! Form::model($analyze, ['id'=>'analyze-form', 'method' => 'PATCH', 'route' => ['materials.analyzes.update', $analyze->id], 'enctype'=>'multipart/form-data']) !!}
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
                    {{AppHelper::selectBlade('search_material_id', __('Source Material'), [null=>__('Search for an item')] + $materials, null, true)}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::selectBlade('material_id', __('Found material'), [null=>__('Search for an item')] + $materials, null, true)}}
                </div>
                <div class="col-md-6 px-md-5 form-multi-field">
                    {{AppHelper::textareaBlade('search_text', __('Search text'), null, true)}}
                </div>
                <div class="col-md-6 px-md-5 form-multi-field">
                    {{AppHelper::textareaBlade('result', __('Found text'), null, false, true)}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::textBlade('', __('Match found in module'), $analyze->material ? get_class($analyze->material) : null, false, true)}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::textBlade('', __('Match found in expertise'), $analyze->material && $analyze->material->expertise->count() ? $analyze->material->expertise->first()->name : null, false, true)}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::textBlade('', __('Language'), $analyze->material && $analyze->material->language ? $analyze->material->language->title : null, false, true)}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::textBlade('coefficient', __('Coincidence rate'), null, false, true)}}
                </div>
            </div>
        </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#collapse2" aria-expanded="true" aria-controls="collapse2" class="">
                    <h4>{{__('Conclusion')}}</h4>
                </a>
            </div>
        </div>
        <div id="collapse2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading2" aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 px-md-5 form-multi-field">
                        {{AppHelper::textareaBlade('conclusion', __('Conclusions compared materials'))}}
                    </div>
                </div>
            </div>
            <div class="col-md-12 panel-footer bg-white border-none">
                <div class="row">
                    <div class="col-md-12 py-md-3 px-md-5 text-right">
                        <a href="{{ route('materials.analyzes.index') }}" class="btn btn-secondary">{{__('Close')}}</a>
                        <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}



@endsection
