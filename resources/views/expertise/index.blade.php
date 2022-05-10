@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12" style="display: flex; align-items: center">
        <h3 class="animated fadeInLeft">{{__('List of expertise')}}</h3>
        <h3 class="ml-3">
            <a class="btn btn-link" href="{{ route('new-index') }}">
                {{__('Go to export')}}
            </a>
        </h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            @can('expertise-create')
                <h3 class="animated fadeInRight">
                    <a class="btn btn-success" href="{{ route('expertise.create') }}">
                        {{__('Create New Expertise')}}
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
    <div id="expert-tabs-container" class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
        <ul id="expert-tabs" class="nav nav-tabs nav-tabs-responsive" role="tablist">
            <li role="presentation" class="active">
                <a href="#" data-id="0" class="expert-filter-btn" role="tab" data-toggle="tab" aria-controls="home"
                   aria-expanded="true">
                    <span class="text">{{ __('All Responsible') }}</span>
                </a>
            </li>
            @foreach($experts as $expert)
                <li role="presentation">
                    <a href="#" data-id="{{ $expert->id }}" class="expert-filter-btn" role="tab" data-toggle="tab"
                        aria-controls="home" aria-expanded="true">
                        <span class="text">
                            {{$expert->last_name. ' ' . mb_substr($expert->name, 0,1) .'.'}}
                        </span>
                        <span class="badge" title="{{ __('total') }}" style="font-size: 11px; background-color: #2196F3;">
                            {{ $expert->expertiseTotal ? $expert->expertiseTotal : 0 }}
                        </span>
                    </a>
                </li>
            @endforeach

        </ul>
        <div id="expert-tab-content" class="tab-content">

            <div class="panel">
                <div class="panel-body">
                    <div>
                        <table class="table table-striped table-bordered" id="expertise-table"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th data-title="{{__('No')}}" style="max-width: 50px">{{__('No')}}</th>
                                <th data-title="{{__('Expertise name')}}">{{__('Expertise name')}}</th>
                                <th data-title="{{__('Expertise No.')}}">{{__('Expertise No.')}}</th>
                                <th data-title="{{__('Case number')}}">{{__('Case number')}}</th>
                                <th data-title="{{__('Expertise type')}}">{{__('Expertise type')}}</th>
                                <th data-title="{{__('Full name of the investigator')}}">{{__('Full name of the investigator')}}</th>
                                <th data-title="{{__('Date of receipt of materials')}}">{{__('Date of receipt of materials')}}</th>
                                <th data-title="{{__('End of production date')}}">{{__('End of production date')}}</th>
                                <th data-title="{{__('Expertise subjects')}}">{{__('Expertise subjects')}}</th>
                                <th data-title="{{__('Article incriminated')}}">{{__('Article incriminated')}}</th>
                                <th data-title="{{__('Expertise status')}}">{{__('Expertise status')}}</th>
                                <th data-title="{{__('Responsible')}}">{{__('Responsible')}}</th>
                                <th data-title="{{__('Created at')}}">{{__('Created at')}}</th>
                                <th style="width:180px;">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let expertiseTable;
        $(document).ready(function () {
            let $target = $('li.active a.expert-filter-btn');
            let $tabs = $target.closest('.nav-tabs-responsive');
            let $current = $target.closest('li');
            let $parent = $current.closest('li.dropdown');
            $current = $parent.length > 0 ? $parent : $current;
            let $next = $current.next();
            let $prev = $current.prev();
            let updateDropdownMenu = function ($el, position) {
                $el
                    .find('.dropdown-menu')
                    .removeClass('pull-xs-left pull-xs-center pull-xs-right')
                    .addClass('pull-xs-' + position);
            };

            $tabs.find('>li').removeClass('next prev');
            $prev.addClass('prev');
            $next.addClass('next');

            updateDropdownMenu($prev, 'left');
            updateDropdownMenu($current, 'center');
            updateDropdownMenu($next, 'right');
            $('#expertise-table thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#expertise-table thead');
            initDefaultTable();
        });

        function initDefaultTable(url = '{{route('expertise.index')}}') {
            expertiseTable = $('#expertise-table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": url,
                "columns": [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'number', name: 'number'},
                    {data: 'case_number', name: 'case_number'},
                    {data: 'type', name: 'type'},
                    {data: 'contractor', name: 'contractor'},
                    {data: 'receipt_date', name: 'receipt_date'},
                    {data: 'expiration_date', name: 'expiration_date'},
                    {data: 'subjects', name: 'subjects'},
                    {data: 'article', name: 'article'},
                    {data: 'status', name: 'status'},
                    {data: 'experts', name: 'experts'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                "createdRow": function (row, data, rowIndex) {
                    // Per-cell function to do whatever needed with cells
                    $.each($('td', row), function (colIndex) {
                        var $title = $('#expertise-table thead tr th:nth-child(' + (colIndex + 1) + ')');
                        // For example, adding data-* attributes to the cell
                        $(this).attr('data-title', $title.data('title') ?? null);
                    });
                },
                "order": [[0, "desc"]],
                "language": {
                    "url": "{{asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')}}"
                },
                initComplete: function () {
                    $("#expertise-table").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
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
                            if (colIdx === 10) {
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
        }
    </script>
    <script>
        $(document).on('click', '.expert-filter-btn', function () {
            startPreloader();
            expertiseTable.destroy();
            let expert_id = $(this).data('id');
            if (expert_id == "0") {
                initDefaultTable();
            } else {
                initDefaultTable(window.location.origin + '/index-by-expert/' + expert_id);
            }
            stopPreloader();
        });
    </script>
    <script>
        (function ($) {
            'use strict';
            $(document).on('show.bs.tab', '.nav-tabs-responsive [data-toggle="tab"]', function (e) {
                let $target = $(e.target);
                let $tabs = $target.closest('.nav-tabs-responsive');
                let $current = $target.closest('li');
                let $parent = $current.closest('li.dropdown');
                $current = $parent.length > 0 ? $parent : $current;
                let $next = $current.next();
                let $prev = $current.prev();
                let updateDropdownMenu = function ($el, position) {
                    $el
                        .find('.dropdown-menu')
                        .removeClass('pull-xs-left pull-xs-center pull-xs-right')
                        .addClass('pull-xs-' + position);
                };

                $tabs.find('>li').removeClass('next prev');
                $prev.addClass('prev');
                $next.addClass('next');

                updateDropdownMenu($prev, 'left');
                updateDropdownMenu($current, 'center');
                updateDropdownMenu($next, 'right');
            });

        })(jQuery);
    </script>
@endsection
