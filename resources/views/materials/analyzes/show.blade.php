@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Show Analyze')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="{{ route('materials.analyzes.index') }}"> {{__('Close')}}</a>
                @can('material-analyze-edit')
                <a class="btn btn-primary" href="{{ route('materials.analyzes.edit', $analyze->id) }}"> {{__('Edit')}}</a>
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
                    {{AppHelper::showBlade(__('Source Material'), $analyze->search_material()->value('name'))}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Found Material'), $analyze->material()->value('name'))}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Search text'), $analyze->search_text)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Found text'), $analyze->result)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Match found in module'), $analyze->material ? get_class($analyze->material) : null)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Match found in expertise'), $analyze->material && $analyze->material->expertise->count() > 0 ? $analyze->material->expertise->name : null)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Language'), $analyze->material && $analyze->material->language ? $analyze->materia->language->title : null)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Coincidence rate'), $analyze->coefficient.'%')}}
                </div>
            </div>
        </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#collapse2" aria-expanded="true" aria-controls="collapse2" class="">
                    <h4>{{__('Conclusions compared materials')}}</h4>
                </a>
            </div>
        </div>
        <div id="collapse2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading2" aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 whitespace-pre-line">
                        {{AppHelper::showBlade(__('Conclusion'), $analyze->conclusion)}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
