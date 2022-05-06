@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Edit Expertise')}}</h3>
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

    {!! Form::model($expertise, ['id'=>'expertise-form', 'method' => 'PATCH', 'route' => ['expertise.update', $expertise->id], 'enctype'=>'multipart/form-data']) !!}
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
                        {{AppHelper::selectContractor('contractor_id', __('Full name of the investigator'), [null=>__('Search for an item')] + $contractors, $expertise->contractor->id, true, false)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::selectCover('cover_id', __('Full name of the investigator'), [null=>__('Search for an item')] + $covers, $expertise->cover->id, true, false)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::selectMultipleBlade('types', __('Expertise type'), [null=>__('Search for an item')] + $types, $expertise->types()->pluck('type_id')->all())}}
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
                        {{AppHelper::selectMultipleBlade('experts', __('Responsible'), $experts, $expertise->experts()->pluck('id')->all(), true)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::fileBlade('resolution', __('Resolution'), $expertise->resolution()->first())}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::selectMultipleSubjectBlade('subject_ids', __('Subject case'), $subjects, $expertise->subjects()->pluck('subject_id')->all())}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::selectBlade('article_id', __('Expertise articles'), [null=>__('Search for an item')] + $articles)}}
                    </div>
                    <div class="col-md-6 px-md-5 form-field">
                        {{AppHelper::textBlade('them', __('Expertise them'))}}
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
                    @php
                        $document = null;
                        foreach ($conclusions as $key => $conclusion) {
                            $tempDoc = $conclusion->document()->first();
                            if ($tempDoc && auth()->id() == $tempDoc->creator_id) {
                                $document = $conclusion->document()->first();
                                unset($conclusions[$key]);
                                break;
                            }
                        }
                    @endphp
                    <div class="col-md-12 px-md-5">
                        <ul class="list-group">
                            @foreach($conclusions as $conclusion)
                                @php
                                    $userDoc = $conclusion->document()->first();
                                    $user = $userDoc->user()->first();
                                @endphp
                                <li class="list-group-item">
                                    {{ $user->last_name }} {{ $user->name }} {{ $user->middle_name }}:
                                    @if(auth()->user()->hasRole('Head of Department')||
                                        (auth()->user()->hasRole('Expert')
                                        &&$expertise->vir_experts->where('id',auth()->user()->id)->count()))
                                        <a href="/download-file/{{ $userDoc->name_uuid }}" class="">
                                            {{ $userDoc->name }}
                                        </a>
                                    @else
                                        {{ $userDoc->name }}
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @if(auth()->user()->hasRole('Head of Department')||
                        (auth()->user()->hasRole('Expert')
                        &&$expertise->vir_experts->where('id',auth()->user()->id)->count()))
                        <div class="col-md-6 px-md-5 form-field">
                            {{AppHelper::fileBlade('conclusion', __('Conclusion'), $document)}}
                        </div>
                    @else
                        <div class="col-md-6 px-md-5 form-field">
                            <p>{{ __("You don't have access to the conclusion" ) }}</p>
                        </div>
                    @endif
                    <div class="col-md-6 py-md-5 px-md-5 text-right">
                        <a href="{{ route('modules.reports.generate', ['id' => $expertise->id, 'model' => 'expertise', 'code' => '34543']) }}"
                           class="btn btn-primary"
                           style="background-color: #3FB8AF !important;">{{__('Generate a conclusion')}}</a>
                        <a href="{{ route('expertise.index') }}" class="btn btn-secondary">{{__('Close')}}</a>
                        <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}



@endsection
