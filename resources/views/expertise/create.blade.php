@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Create New Expertise')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="{{ route('expertise.index') }}"> {{__('Close')}}</a>
                <button type="submit" class="btn btn-primary" form="expertise-form">{{__('Save')}}</button>
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

    {!! Form::open(array('id'=>'expertise-form', 'route' => 'expertise.store','method'=>'POST', 'enctype'=>'multipart/form-data')) !!}
    {{Form::hidden('id', $expertise->id)}}
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
                        {{AppHelper::textBlade('name', __('Expertise name'), null, true)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::textBlade('number', __('Expertise No.'))}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::textBlade('case_number', __('Case number'))}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::textBlade('reason', __('Grounds for Appointing an Expertise'))}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::textBlade('decree_reg_number', __('Registration numbers of the decree (definition)'))}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::dateBlade('receipt_date', __('Materials receipt date'))}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::dateBlade('start_date', __('Expertise start date'))}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::dateBlade('expiration_date', __('End of production date'))}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{ AppHelper::selectContractor('contractor_id', __('Full name of the investigator'), [null=>__('Search for an item')] + $contractors ,null,true,false) }}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{ AppHelper::selectCover('cover_id', __('Cover letter signed'), [null=>__('Search for an item')] + $covers ,null,true,false) }}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::selectMultipleBlade('types', __('Expertise type'), [null=>__('Search for an item')] + $types, [])}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::selectBlade('composition_id', __('By the composition of the expertise'), [null=>__('Search for an item')] + $compositions)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::selectBlade('sequence_id', __('According to the sequence'), [null=>__('Search for an item')] + $sequences)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::selectBlade('difficulty_id', __('Degree of difficulty'), [null=>__('Search for an item')] + $difficulties)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::selectMultipleBlade('experts', __('Responsible'), $experts, [], true)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::fileBlade('resolution', __('Resolution'))}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::textBlade('them', __('Expertise them'))}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::selectMultipleSubjectBlade('subject_ids', __('Subjects case'), $subjects, [])}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::dependedSelectBlade('status_id', __('Expertise status'), [null=>__('Search for an item')] + $statuses)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::dependedSelectBlade('status_reason_id', __('Reason'), [null=>__('Search for an item')] + $reasons, null, false, 'status_id', $statusRelation)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::textBlade('comment', __('Comment'))}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::selectBlade('article_id', __('Article incriminated'), [null=>__('Search for an item')] + $articles)}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#collapse2" aria-expanded="true" aria-controls="collapse2"
                   class="">
                    <h4>{{__('Questions posed to the expertise')}}</h4>
                </a>
            </div>
        </div>
        <div id="collapse2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading2"
             aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 px-md-5">
                        {{AppHelper::textareaBlade('questions', trans(''))}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('expertise.sections')

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <a role="button" data-toggle="collapse" href="#collapse4" aria-expanded="true" aria-controls="collapse4"
                   class="">
                    <h4>{{__('Expertise conclusion')}}</h4>
                </a>
            </div>
        </div>
        <div id="collapse4" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading4"
             aria-expanded="true" style="">
            <div class="panel-body">
                <div class="row">
                    @if(auth()->user()->hasRole('Head of Department')||
                        (auth()->user()->hasRole('Expert')
                        &&$expertise->vir_experts->where('id',auth()->user()->id)->count()))
                        <div class="col-md-6 px-md-5 form-field">
                            {{AppHelper::fileBlade('conclusion', __('Conclusion'), $expertise->conclusion()->first())}}
                        </div>
                    @else
                        <div class="col-md-6 px-md-5 form-field">
                            <p>{{ __("You don't have access to the conclusion" ) }}</p>
                        </div>
                    @endif
                    <div class="col-md-6 py-md-5 px-md-5 text-right">
                        <button type="button" class="btn btn-primary" style="background-color: #3FB8AF !important;">
                            Сформировать заключение
                        </button>
                        <a href="{{ route('expertise.index') }}" class="btn btn-secondary">{{__('Close')}}</a>
                        <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}



@endsection
