@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Show Expertise')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="{{ route('expertise.index') }}"> {{__('Close')}}</a>
                @can('expertise-edit')
                <a class="btn btn-primary" href="{{ route('expertise.edit', $expertise->id) }}"> {{__('Edit')}}</a>
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
                    {{AppHelper::showBlade(__('Expertise name'), $expertise->name)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Expertise No.'), $expertise->number)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Case number'), $expertise->case_number)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Grounds for Appointing an Expertise'), $expertise->reason)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Registration numbers of the decree (definition)'), $expertise->decree_reg_number)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Materials receipt date'), $expertise->receipt_date)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('End of production date'), $expertise->expiration_date)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Full name of the investigator'), $expertise->contractor()->select(DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))->value('full_name'))}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Expertise type'), $expertise->types()->pluck('title')->all())}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('According to the sequence'), $expertise->sequence()->value('title'))}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('By the composition of the expertise'), $expertise->composition()->value('title'))}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Degree of difficulty'), $expertise->difficulty()->value('title'))}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Responsible'), $expertise->experts()->select(DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))->pluck('full_name')->all())}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Resolution'), $expertise->resolution)}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::showBlade(__('Expertise them'), $expertise->them)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Expertise subjects'), $expertise->subjects()->pluck('subject_case')->all())}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Expertise status'), $expertise->status()->value('title'))}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Reason'), $expertise->status_reason()->value('title'))}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Comment'), $expertise->comment)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Article incriminated'), $expertise->article()->value('title'))}}
                </div>
            </div>
        </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#collapse2" aria-expanded="true" aria-controls="collapse2" class="">
                    <h4>{{__('Questions posed to the expertise')}}</h4>
                </a>
            </div>
        </div>
        <div id="collapse2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading2" aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 whitespace-pre-line">
                        {{$expertise->questions}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('expertise.sections')

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#collapse4" aria-expanded="true" aria-controls="collapse4" class="">
                    <h4>{{__('Expertise conclusion')}}</h4>
                </a>
            </div>
        </div>
        <div id="collapse4" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading4" aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        @if((auth()->user()->hasRole('expert')&&$expertise->vir_experts->where('id',auth()->user()->id))
                     ??auth()->user()->hasRole('Head of Department'))
                            <div class="col-md-6 px-md-5 form-field">
                                {{AppHelper::showBlade(__('Conclusion'), $expertise->conclusion)}}
{{--                                {{AppHelper::fileBlade('conclusion', __('Conclusion'), $expertise->conclusion()->first())}}--}}
                            </div>
                        @else
                            <div class="col-md-6 px-md-5 form-field">
                                <p>{{ __("You don't have access to the conclusion" ) }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
