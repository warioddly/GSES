@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Alias')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            @can('subject-create')
                <h3 class="animated fadeInRight"><a class="btn btn-success"
                                                    href="{{ route('modules.nicknames.create') }}"> {{__('Create New Subject')}}</a>
                </h3>
            @endcan
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
        <div class="panel-body">
            <div class="responsive-table">
                <table class="table table-striped table-bordered" id="nickname-table" style="width:100%">
                    <thead>
                    <tr>
                        <th data-title="{{__('No')}}" width="50">{{__('No')}}</th>
                        <th data-title="{{__('Alias')}}">{{__('Alias')}}</th>
                        <th data-title="{{__('Subject')}}">{{__('Subject')}}</th>
                        <th data-title="{{__('Creator')}}">{{__('Creator')}}</th>
                        <th data-title="{{__('Created at')}}">{{__('Created at')}}</th>
                        <th style="width:180px;">{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $('#nickname-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '{{route('modules.nicknames.index')}}',
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'nickname', name: 'nickname'},
                {data: 'subject_id', name: 'subject_id'},
                {data: 'user_id', name: 'user_id'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "order": [[0, "desc"]],
            "language": {
                "url": "{{asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')}}"
            }
        });
    </script>
@endsection
