@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Create New User')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="{{ route('security.users.index') }}"> {{__('Close')}}</a>
                <button type="submit" class="btn btn-primary" form="users-form">{{__('Save')}}</button>
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

    {!! Form::open(array('id'=>'users-form', 'route' => 'security.users.store','method'=>'POST', 'enctype'=>'multipart/form-data')) !!}

    <div class="panel">
        <div class="panel-heading">
            <h4>{{__('Basic information')}}</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::textBlade('last_name', __('Surname'), null, true)}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::textBlade('name', __('Name'), null, true)}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::textBlade('middle_name', __('Middle name'))}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::textBlade('phone', __('Phone'))}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::textBlade('email', __('Email'))}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::selectMultipleBlade('roles', __('Role'), $roles, [])}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::passwordBlade('password', __('Password'), true)}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::passwordBlade('confirm-password', __('Confirm Password'), true)}}
                </div>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <h4>{{__('Additional information')}}</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::selectBlade('position_id', __('Position'), [null=>__('Search for an item')] + $userPositions)}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::selectBlade('speciality_number_id', __('Specialty nomenclature number'), [null=>__('Search for an item')] + $userSpecialityNumbers)}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::selectBlade('speciality_id', __('Name of the specialty of higher specialized education'), [null=>__('Search for an item')] + $userSpecialities)}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::textBlade('academic_degrees', __('Availability of academic degrees and titles'))}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::textBlade('speciality_experience', __('Work experience in the specialty'))}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::textBlade('expert_experience', __('Experience of expert activity'))}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::fileBlade('certificate_file', __('Competence certificate'))}}
                </div>
                <div class="col-md-6 px-md-5 form-field">
                    {{AppHelper::textBlade('certificate_valid', __('Certificate validity period'))}}
                </div>
            </div>
        </div>
        <div class="col-md-12 panel-footer bg-white border-none">
            <div class="row">
                <div class="col-md-12 py-md-3 px-md-5 text-right">
                    <a href="{{ route('security.users.index') }}" class="btn btn-secondary">{{__('Close')}}</a>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}



@endsection
