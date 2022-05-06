@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Show Profile')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="\"> {{__('Close')}}</a>
                @can('expertise-edit')
                    <a class="btn btn-primary" href="{{ route('profile.edit') }}"> {{__('Edit')}}</a>
                @endcan
            </h3>
        </div>
    </div>
@endsection

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
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
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Last Name'), auth()->user()->last_name)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Name'), auth()->user()->name)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Middle Name'), auth()->user()->middle_name)}}
                    </div>
                    @if(auth()->user()->position)
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            {{AppHelper::showBlade(__('Position'), auth()->user()->position->title)}}
                        </div>
                    @endif
                    @if(auth()->user()->speciality)
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            {{AppHelper::showBlade(__('Speciality'), auth()->user()->speciality->title)}}
                        </div>
                    @endif
                    @if(auth()->user()->specialityNumber)
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            {{AppHelper::showBlade(__('Speciality Number'), auth()->user()->specialityNumber->title)}}
                        </div>
                    @endif
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Academic Degrees'), auth()->user()->academic_degrees)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('speciality Experience'), auth()->user()->speciality_experience)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('expert Experience'), auth()->user()->expert_experience)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('certificate File'), auth()->user()->certificateFile)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('certificate Valid'), auth()->user()->certificate_valid)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Phone'), auth()->user()->phone)}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Email'), auth()->user()->email )}}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {{AppHelper::showBlade(__('Created At'), auth()->user()->created_at->format('d-m-Y'))}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    <div class="panel">--}}
    {{--        <div class="panel-heading">--}}
    {{--            <div class="panel-title">--}}
    {{--                <a role="button" data-toggle="collapse" href="#collapse2" aria-expanded="true" aria-controls="collapse2" class="">--}}
    {{--                    <h4>{{__('Questions posed to the expertise')}}</h4>--}}
    {{--                </a>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--        <div id="collapse2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading2" aria-expanded="true" style="">--}}
    {{--            <div class="panel-body">--}}
    {{--                <div class="row">--}}
    {{--                    <div class="col-xs-12 col-sm-12 col-md-12 whitespace-pre-line">--}}
    {{--                        {{$expertise->questions}}--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

@endsection
