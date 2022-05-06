@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12" style="display: flex; align-items: center">
        <h3 class="animated fadeInLeft">{{__('Materials')}}</h3>
        <h3 class="ml-3">
            <a class="btn btn-link" href="{{ route('export-materials') }}">
                {{__('Go to export')}}
            </a>
        </h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            @can('material-create')
                <h3 class="animated fadeInRight">
                    <a class="btn btn-success" href="{{ route('materials.create') }}">
                        {{__('Create New Material')}}
                    </a>
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
            <div>
                <table class="table table-striped table-bordered" id="material-table" style="width:100%">
                    <thead>
                    <tr>
                        <th data-title="{{__('No')}}" width="50">{{__('No')}}</th>
                        <th data-title="{{__('Material name')}}">{{__('Material name')}}</th>
                        <th data-title="{{__('Object type')}}">{{__('Object type')}}</th>
                        <th data-title="{{__('Material type')}}">{{__('Material type')}}</th>
                        <th data-title="{{__('Language')}}">{{__('Language')}}</th>
                        <th data-title="{{__('Source')}}">{{__('Source')}}</th>
                        <th data-title="{{__('Document')}}">{{__('Document')}}</th>
                        <th data-title="{{__('Comment')}}">{{__('Comment')}}</th>
                        <th data-title="{{__('Status')}}">{{__('Status')}}</th>
                        <th data-title="{{__('Created at')}}">{{__('Created at')}}</th>
                        <th data-title="{{__('Content analyze')}}">{{__('Content analyze')}}</th>
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
        $(document).ready(function () {
            $('#material-table').DataTable({
                "processing": true,
                "serverSide": true,
                "oSearch": {"sSearch": '{{request()->input('search')}}'},
                "ajax": '{{route('materials.index')}}',
                "columns": [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'object_type', name: 'object_type'},
                    {data: 'type', name: 'type'},
                    {data: 'language', name: 'language'},
                    {data: 'source', name: 'source'},
                    {data: 'file', name: 'file'},
                    {data: 'file_text_comment', name: 'file_text_comment'},
                    {data: 'status', name: 'status'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'words', name: 'words'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                "createdRow": function (row, data, rowIndex) {
                    // Per-cell function to do whatever needed with cells
                    $.each($('td', row), function (colIndex) {
                        var $title = $('#material-table thead tr th:nth-child(' + (colIndex + 1) + ')');
                        // For example, adding data-* attributes to the cell
                        $(this).attr('data-title', $title.data('title') ?? null);
                    });
                },
                "order": [[0, "desc"]],
                "language": {
                    "url": "{{asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')}}"
                },
                initComplete: function () {
                    $("#material-table").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
                    var api = this.api();

                    // For each column
                    api
                        .columns()
                        .eq(0)
                        .each(function (colIdx) {
                            // Set the header cell to contain the input element
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            if (colIdx === 11) {
                                $(cell).empty();
                                return false;
                            }
                            if (colIdx === 0) {
                                $(cell).html('<input type="text" style="width: 100%"/>');
                            } else {
                                $(cell).html('<input type="text" />');
                            }
                            // On every keypress in this input
                            $(
                                'input',
                                $('.filters th').eq($(api.column(colIdx).header()).index())
                            )
                                .off('keyup change')
                                .on('keyup change', function (e) {
                                    e.stopPropagation();
                                    // Get the search value
                                    $(this).attr('title', $(this).val());
                                    var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api
                                        .column(colIdx)
                                        .search(
                                            this.value != ''
                                                ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                : '',
                                            this.value != '',
                                            this.value == ''
                                        )
                                        .draw();

                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(cursorPosition, cursorPosition);
                                });

                        });
                },
            });
            $('#material-table thead tr').clone(true).addClass('filters').appendTo('#material-table thead');
        })
    </script>
@endsection
