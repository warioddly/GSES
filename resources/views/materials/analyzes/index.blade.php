@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Material analyzes')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            @can('material-analyze-create')
            <h3 class="animated fadeInRight"><a class="btn btn-success" href="{{ route('materials.analyzes.create') }}"> {{__('Create New Analyze')}}</a></h3>
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
    @if ($message = Session::get('warning'))
        <div class="alert alert-warning">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="panel">
        <div class="panel-body">
            <div class="responsive-table">
                <table class="table table-striped table-bordered" id="analyze-table" style="width:100%">
                <thead>
                    <tr>
                        <th data-title="{{__('No')}}" width="50">{{__('No')}}</th>
                        <th data-title="{{__('Source Material')}}">{{__('Source Material')}}</th>
                        <th data-title="{{__('Coincidence rate')}}">{{__('Coincidence rate')}}</th>
                        <th data-title="{{__('Found Material')}}">{{__('Found Material')}}</th>
                        <th data-title="{{__('Language')}}">{{__('Language')}}</th>
                        <th data-title="{{__('Conclusion')}}">{{__('Conclusion')}}</th>
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
    $('#analyze-table').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": '{{route('materials.analyzes.index')}}',
        "columns": [
            {data: 'id', name: 'id'},
            {data: 'search_material', name: 'search_material'},
            {data: 'coefficient', name: 'coefficient'},
            {data: 'material', name: 'material'},
            {data: 'language', name: 'language'},
            {data: 'conclusion', name: 'conclusion'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "createdRow": function (row, data, rowIndex) {
            // Per-cell function to do whatever needed with cells
            $.each($('td', row), function (colIndex) {
                var $title = $('#analyze-table thead tr th:nth-child('+(colIndex+1)+')');
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
