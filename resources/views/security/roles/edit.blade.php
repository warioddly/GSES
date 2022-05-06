@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Edit Role')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="{{ route('security.roles.index') }}"> {{__('Close')}}</a>
                <button type="submit" class="btn btn-primary" form="roles-form">{{__('Save')}}</button>
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

    {!! Form::model($role, ['id'=>'roles-form', 'method' => 'PATCH','route' => ['security.roles.update', $role->id]]) !!}
    <div class="panel">
        <div class="col-md-12 panel-heading">
            <h4>{{__('Basic information')}}</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6 px-md-5">
                    <div class="form-group form-animate-text @error('name') form-animate-error @enderror">
                        {!! Form::text('name', null, array('class' => 'form-text'.($errors->has('name')?' error':''), 'required')) !!}
                        <span class="bar"></span>
                        <label>{{__('Name')}}</label>
                        @error('name')
                        <em class="error">{{ __($message) }}</em>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 px-md-5">
                    {{AppHelper::selectMultipleBlade('permission[]', __('Permission'), $permission, $rolePermissions, true)}}
                </div>
            </div>
        </div>
        <div class="panel-footer bg-white border-none">
            <div class="row">
                <div class="col-md-12 py-md-3 px-md-5 text-right">
                    <a href="{{ route('security.roles.index') }}" class="btn btn-secondary">{{__('Close')}}</a>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}


@endsection
