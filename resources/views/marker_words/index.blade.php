@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Marker words')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            @can('marker-word-list')
            <h3 class="animated fadeInRight"><a class="btn btn-success" href="{{ route('modules.marker_words.create') }}"> {{__('Create New Word')}}</a></h3>
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
                <table class="table table-striped table-bordered" id="marker-word-table" style="width:100%">
                <thead>
                    <tr>
                        <th data-title="{{__('No')}}" width="50">{{__('No')}}</th>
                        <th data-title="{{__('Word')}}">{{__('Word')}}</th>
                        <th data-title="{{__('Declension')}}">{{__('Declension')}}</th>
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
    $('#marker-word-table').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": '{{route('modules.marker_words.index')}}',
        "columns": [
            {data: 'id', name: 'id'},
            {data: 'word', name: 'word'},
            {data: 'declensions', name: 'declensions', orderable: false, searchable: false},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "createdRow": function (row, data, rowIndex) {
            // Per-cell function to do whatever needed with cells
            $.each($('td', row), function (colIndex) {
                var $title = $('#marker-word-table thead tr th:nth-child('+(colIndex+1)+')');
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
