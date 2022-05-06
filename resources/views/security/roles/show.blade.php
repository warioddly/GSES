@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Show Role')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="{{ route('security.roles.index') }}"> {{__('Close')}}</a>
                @can('role-edit')
                    <a class="btn btn-primary" href="{{ route('security.roles.edit', $role->id) }}"> {{__('Edit')}}</a>
                @endcan
            </h3>
        </div>
    </div>
@endsection

@section('content')

    <div class="panel">
        <div class="panel-heading">
            <h4>{{__('Basic information')}}</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        {{ $role->name }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Permissions:</strong>
                        @if(!empty($rolePermissions))
                            @foreach($rolePermissions as $v)
                                <label class="label label-success">{{ $v->name }}</label>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
