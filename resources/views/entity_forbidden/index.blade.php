@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Counterparties')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            @can('contractor-create')
            <h3 class="animated fadeInRight"><a class="btn btn-success" href="{{ route('modules.contractors.create') }}"> {{__('Create New Contractor')}}</a></h3>
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
                <table class="table table-striped table-bordered" id="contractor-table" style="width:100%">
                <thead>
                    <tr>
                        <th data-title="{{__('No')}}" width="50">{{__('No')}}</th>
                        <th data-title="{{__('Type')}}">{{__('Type')}}</th>
                        <th data-title="{{__('Name of body, institution')}}">{{__('Name of body, institution')}}</th>
                        <th data-title="{{__('Surname')}}">{{__('Surname')}}</th>
                        <th data-title="{{__('Name')}}">{{__('Name')}}</th>
                        <th data-title="{{__('Middle name')}}">{{__('Middle name')}}</th>
                        <th data-title="{{__('Position')}}">{{__('Position')}}</th>
                        <th data-title="{{__('Phone number')}}">{{__('Phone number')}}</th>
                        <th data-title="{{__('Email')}}">{{__('Email')}}</th>
                        <th data-title="{{__('Created at')}}">{{__('Created at')}}</th>
                        <th data-title="{{__('Created by')}}">{{__('Created by')}}</th>
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
    $('#contractor-table').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": '{{route('modules.contractors.index')}}',
        "columns": [
            {data: 'id', name: 'id'},
            {data: 'type', name: 'type'},
            {data: 'organ', name: 'organ'},
            {data: 'last_name', name: 'last_name'},
            {data: 'name', name: 'name'},
            {data: 'middle_name', name: 'middle_name'},
            {data: 'position', name: 'position'},
            {data: 'phone', name: 'phone'},
            {data: 'email', name: 'email'},
            {data: 'created_at', name: 'created_at'},
            {data: 'creator', name: 'creator'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "createdRow": function (row, data, rowIndex) {
            // Per-cell function to do whatever needed with cells
            $.each($('td', row), function (colIndex) {
                var $title = $('#contractor-table thead tr th:nth-child('+(colIndex+1)+')');
                // For example, adding data-* attributes to the cell
                $(this).attr('data-title', $title.data('title')??null);
            });
        },
        "order": [[ 0, "desc" ]],
        "language": {
            "url": "{{asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')}}"
        }
    } );
</script>
@endsection
