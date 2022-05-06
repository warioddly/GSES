@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Export list of expertises')}}</h3>
    </div>
@endsection
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div id="expert-tab-content" class="tab-content">
        <div class="panel">
            <div class="panel-body">
                <div class="responsive-table">
                    <table class="table table-striped table-bordered" id="expertise-table"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th data-title="{{__('No')}}" width="50">{{__('No')}}</th>
                            <th data-title="{{__('Expertise name')}}">{{__('Expertise name')}}</th>
                            <th data-title="{{__('Expertise No.')}}">{{__('Expertise No.')}}</th>
                            <th data-title="{{__('Case number')}}">{{__('Case number')}}</th>
                            <th data-title="{{__('Reason')}}">{{__('Reason')}}</th>
                            <th data-title="{{__('Registration numbers of the decree (definition)')}}">{{__('Registration numbers of the decree (definition)')}}</th>
                            <th data-title="{{__('Materials receipt date')}}">{{__('Materials receipt date')}}</th>
                            <th data-title="{{__('Expertise start date')}}">{{__('Expertise start date')}}</th>
                            <th data-title="{{__('End of production date')}}">{{__('End of production date')}}</th>
                            <th data-title="{{__('Full name of the investigator')}}">{{__('Full name of the investigator')}}</th>
                            <th data-title="{{__('Expertise type')}}">{{__('Expertise type')}}</th>
                            <th data-title="{{__('By the composition of the expertise')}}">{{__('By the composition of the expertise')}}</th>
                            <th data-title="{{__('According to the sequence')}}">{{__('According to the sequence')}}</th>
                            <th data-title="{{__('Degree of difficulty')}}">{{__('Degree of difficulty')}}</th>
                            <th data-title="{{__('Responsible')}}">{{__('Responsible')}}</th>
                            <th data-title="{{__('Expertise them')}}">{{__('Expertise them')}}</th>
                            <th data-title="{{__('Expertise status')}}">{{__('Expertise status')}}</th>
                            <th data-title="{{__('Questions')}}">{{__('Questions')}}</th>
                            <th data-title="{{__('Reason')}}">{{__('Reason')}}</th>
                            <th data-title="{{__('Comment')}}">{{__('Comment')}}</th>
                            <th data-title="{{__('Article incriminated')}}">{{__('Article incriminated')}}</th>
                            <th data-title="{{__('Creator')}}">{{__('Creator')}}</th>
                            <th data-title="{{__('Expertise subjects')}}">{{__('Expertise subjects')}}</th>
                            <th data-title="{{__('Created at')}}">{{__('Created at')}}</th>
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
@push('page-styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.1/css/dataTables.dateTime.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/searchbuilder/1.3.0/css/searchBuilder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.5.5/css/colReorder.dataTables.min.css">
@endpush
@section('script')
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.3.0/js/dataTables.searchBuilder.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/datetime-moment.js"></script>

    <script src="https://cdn.datatables.net/colreorder/1.5.5/js/dataTables.colReorder.min.js"></script>
    <script>

        let expertiseTable;
        $(document).ready(function () {
            expertiseTable = $('#expertise-table').DataTable({
                "processing": true,
                "serverSide": false,
                dom: 'Q<"other-control-element"B>lfrtip',
                colReorder: {},
                buttons: [
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible',
                            orthogonal: 'export'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible',
                            orthogonal: 'export'
                        }
                    },
                    'colvis'
                ],
                "ajax": "{{ route('new-index') }}",
                "columns": [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'number', name: 'number'},
                    {data: 'case_number', name: 'case_number'},
                    {data: 'reason', name: 'reason'},
                    {data: 'decree_reg_number', name: 'decree_reg_number'},
                    {
                        data: 'receipt_date',
                        render: {_: ".human_format", sb: '.iso8601',},
                        searchBuilder: {orthogonal: 'sb',},
                        searchBuilderType: 'date',
                    },
                    {
                        data: 'start_date',
                        render: {_: ".human_format", sb: '.iso8601',},
                        searchBuilder: {orthogonal: 'sb',},
                        searchBuilderType: 'date',
                    },
                    {
                        data: 'expiration_date',
                        render: {_: ".human_format", sb: '.iso8601',},
                        searchBuilder: {orthogonal: 'sb',},
                        searchBuilderType: 'date',
                    },
                    {data: 'contractor_id', name: 'contractor_id'},
                    {
                        data: 'types',
                        render: {
                            _: "{{"types[, ].title.".app()->getLocale()}}",
                            sb: '{{"types[].title.".app()->getLocale()}}'
                        },
                        searchBuilder: {orthogonal: 'sb'},
                        searchBuilderType: 'array'
                    },
                    {data: 'composition_id', name: 'composition_id'},
                    {data: 'sequence_id', name: 'sequence_id'},
                    {data: 'difficulty_id', name: 'difficulty_id'},
                    {
                        data: 'experts',
                        render: {
                            _: "experts[, ].vir_full_name",
                            sb1: 'experts[].vir_full_name'
                        },
                        searchBuilder: {orthogonal: 'sb1'},
                        searchBuilderType: 'array'
                    },
                    {data: 'them', name: 'them'},
                    {data: 'status_id', name: 'status_id'},
                    {
                        data: 'questions',
                        render: function (data, type, row, meta) {
                            if (data !== null) {
                                if (type === 'display') {
                                    return data.length > 50 ? '<span title="' + data + '">' + data.substr(0, 50) + '...</span>' : data;
                                } else {
                                    return data;
                                }
                            }
                            return "";
                        }
                    },
                    {data: 'status_reason_id', name: 'status_reason_id'},
                    {data: 'comment', name: 'comment'},
                    {data: 'article_id', name: 'article_id'},
                    {data: 'creator_id', name: 'creator_id'},
                    {
                        data: 'subjects',
                        render: {
                            _: "subjects[, ].subject_case",
                            sb: "subjects[].subject_case"
                        },
                        searchBuilder: {orthogonal: 'sb'},
                        searchBuilderType: 'array'
                    },
                    {
                        data: 'created_at',
                        render: {_: ".human_format", sb: '.iso8601',},
                        searchBuilder: {orthogonal: 'sb',},
                        searchBuilderType: 'date',
                    },
                ],
                "order": [[0, "desc"]],
                "language": {
                    "url": "{{asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')}}"
                },
                fixedHeader: true,
                initComplete: function () {
                    $("#expertise-table").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
                }
            });
        });
    </script>
    <script>
        $(document).on('change', '.dtsb-condition', function () {
            $('.dtsp-joiner').html("{{ app()->getLocale() }}" == "ru" ? "И" : "Жана")
        })
    </script>
@endsection

<style>
.other-control-element .dt-button.active {
    background: #2196F3 !important;
    color: #fff !important;
}
</style>
