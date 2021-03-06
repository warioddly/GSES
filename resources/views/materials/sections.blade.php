<div class="panel tabs-area" style="margin-top: 0; !important;">
    <ul id="tabs" class="nav nav-tabs nav-tabs-v3" role="tablist"
        style="padding-top: 0; !important;background: #F9F9F9;">
        <li role="presentation" class="active">
            <a href="#tabs-area1" id="tabs-1" role="tab" data-toggle="tab" aria-expanded="true">
                <h4>{{__('Material expertise')}} (<span
                            id="count-expertise">{{$material->expertise()->where('created', true)->count()}}</span>)
                </h4>
            </a>
        </li>
        <li role="presentation">
            <a href="#tabs-area2" id="tabs-2" role="tab" data-toggle="tab" aria-expanded="true">
                <h4>{{__('Expert conclusion') }} (<span
                            id="count-conclusions">{{$material->conclusions->count()}}</span>)</h4>
            </a>
        </li>
        <li role="presentation">
            <a href="#tabs-area3" id="tabs-3" role="tab" data-toggle="tab" aria-expanded="true">
                <h4>{{__('Court decision')}} (<span id="count-decisions">{{$material->decisions()->count()}}</span>)
                </h4></a>
        </li>
        <li role="presentation">
            <a href="#tabs-area5" id="tabs-5" role="tab" data-toggle="tab" aria-expanded="true">
                <h4>{{__('Analyze materials')}} (<span
                            id="count-analyze-materials">{{$material->analyzes()->count()}}</span>)
                </h4></a>
        </li>
        <li role="presentation">
            <a href="#tabs-area6" id="tabs-6" role="tab" data-toggle="tab" aria-expanded="true">
                <h4>{{__('Analyze images')}} (<span
                            id="count-analyze-images">{{$material->analyzeImages()->count()}}</span>)
                </h4>
            </a>
        </li>
        <li role="presentation">
            <a href="#tabs-area4" id="tabs-4" role="tab" data-toggle="tab" aria-expanded="true"><h4>{{__('History')}}
                    ({{$material->histories()->count()}})</h4></a>
        </li>
    </ul>
    <div id="tabsDemo4Content" class="tab-content tab-content-v3">
        <div role="tabpanel" class="tab-pane fade active in" id="tabs-area1" aria-labelledby="tabs-area1"
             style="padding: 15px;">
            <!-------- ???????????????????? ?????????????????? -------->
            <div class="responsive-table">
                <table id="expertise-table" class="display" style="width:100%">
                    <thead>
                    <tr>
                        <th data-title="{{__('No')}}" width="50">{{__('No')}}</th>
                        <th data-title="{{__('Expertise name')}}">{{__('Expertise name')}}</th>
                        <th data-title="{{__('Expertise No.')}}">{{__('Expertise No.')}}</th>
                        <th data-title="{{__('Case number')}}">{{__('Case number')}}</th>
                        <th data-title="{{__('Expertise type')}}">{{__('Expertise type')}}</th>
                        <th data-title="{{__('Registration numbers of the decree (definition)')}}">{{__('Registration numbers of the decree (definition)')}}</th>
                        <th data-title="{{__('Date of receipt of materials')}}">{{__('Date of receipt of materials')}}</th>
                        <th data-title="{{__('Expertise status')}}">{{__('Expertise status')}}</th>
                        <th data-title="{{__('Expertise subjects')}}">{{__('Expertise subjects')}}</th>
                        <th data-title="{{__('Created at')}}">{{__('Created at')}}</th>
                        <th style="width:180px;">{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody></tbody>

                </table>
                <div>
                    <a class="btn create-expertise"
                       href="{{route('expertise.create') . '?material_id=' . $material->id}}">
                        {{__('Create New Expertise')}}
                    </a>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="tabs-area2" aria-labelledby="tabs-area2" style="padding: 15px;">
            <!-------- ???????????????????? ?????????????????? -------->
            <div class="responsive-table">
                <table id="conclusion-table" class="display" style="width:100%">
                    <thead>
                    <tr>
                        <th data-title="{{__('No')}}">{{__('No')}}</th>
                        <th data-title="{{__('Material')}}">{{__('Material')}}</th>
                        <th data-title="{{__('Document')}}">{{__('Document')}}</th>
                        <th data-title="{{__('Conclusion')}}">{{__('Conclusion')}}</th>
                        <th data-title="{{__('Conclusion text')}}">{{__('Conclusion text')}}</th>
                        <th data-title="{{__('Status')}}">{{__('Status')}}</th>
                        {{--                        <th data-title="{{__('Expert')}}">{{__('Expert')}}</th>--}}
                        <th data-title="{{__('Created at')}}">{{__('Created at')}}</th>
                        <th data-title="{{__('Action')}}">{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div>
                    <button class="btn show-crud-modal"
                            data-url="{{ route('material.modal.conclusions.create') }}">{{__('add conclusion')}}
                    </button>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="tabs-area3" aria-labelledby="tabs-area3" style="padding: 15px;">
            <!-------- ???????????????? ???????????????????? -------->
            <div class="responsive-table">
                <table id="decision-table" class="display" style="width:100%">
                    <thead>
                    <tr>
                        <th data-title="{{__('No')}}">{{__('No')}}</th>
                        <th data-title="{{__('Article')}}">{{__('Article')}}</th>
                        <th data-title="{{__('Court decision')}}">{{__('Court decision')}}</th>
                        <th data-title="{{__('Comment')}}">{{__('Comment')}}</th>
                        <th data-title="{{__('Status')}}">{{__('Status')}}</th>
                        <th data-title="{{__('Date')}}">{{__('Date')}}</th>
                        <th data-title="{{__('Created by')}}">{{__('Created by')}}</th>
                        <th data-title="{{__('Created at')}}">{{__('Created at')}}</th>
                        <th data-title="{{__('Action')}}">{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div>
                    <button class="btn show-crud-modal"
                            data-url="{{ route('material.modal.decisions.create') }}">{{__('add decision')}}
                    </button>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="tabs-area5" aria-labelledby="tabs-area5" style="padding: 15px;">
            <!-------- ???????????? ???????????????????? -------->
            <div class="responsive-table">
                <table id="analyze-materials" class="display" style="width:100%">
                    <thead>
                    <tr>
                        <th data-title="{{__('No')}}">{{__('No')}}</th>
                        <th data-title="{{__('Source Material')}}">{{__('Source Material')}}</th>
                        <th data-title="{{__('Coincidence rate')}}">{{__('Coincidence rate')}}</th>
                        <th data-title="{{__('Found Material')}}">{{__('Found Material')}}</th>
                        <th data-title="{{__('Language')}}">{{__('Language')}}</th>
                        <th data-title="{{__('Conclusion')}}">{{__('Conclusion')}}</th>
                        <th style="width:180px;">{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="tabs-area6" aria-labelledby="tabs-area6" style="padding: 15px;">
            <!-------- ???????????? ???????????????????????? -------->
            <div class="responsive-table">
                <table id="analyze-images" class="display" style="width:100%">
                    <thead>
                    <tr>
                        <th data-title="{{__('No')}}">{{__('No')}}</th>
                        <th data-title="{{__('Source Material')}}">{{__('Source Material')}}</th>
                        <th data-title="{{__('Source image')}}">{{__('Source image')}}</th>
                        <th data-title="{{__('Coincidence rate')}}">{{__('Coincidence rate')}}</th>
                        <th data-title="{{__('Found image')}}">{{__('Found image')}}</th>
                        <th data-title="{{__('Image name')}}">{{__('Image name')}}</th>
                        <th data-title="{{__('Original size')}}">{{__('Original size')}}</th>
                        <th data-title="{{__('Found Material')}}">{{__('Found Material')}}</th>
                        <th data-title="{{__('Conclusion')}}">{{__('Conclusion')}}</th>
                        <th style="width:180px;">{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="tabs-area4" aria-labelledby="tabs-area4" style="padding: 15px;">
            <!-------- ?????????????? -------->
            <div class="responsive-table">
                <table id="material-history-table" class="display" style="width:100%">
                    <thead>
                    <tr>
                        <th data-title="{{__('No')}}">{{__('No')}}</th>
                        <th data-title="{{__('Message')}}">{{__('Message')}}</th>
                        {{--                        <th data-title="{{__('Model')}}">{{__('Model')}}</th>--}}
                        <th data-title="{{__('Data')}}">{{__('Data')}}</th>
                        <th data-title="{{__('User')}}">{{__('User')}}</th>
                        <th data-title="{{__('Date')}}">{{__('Date')}}</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="CRUD-modal" role="dialog" aria-labelledby="analyzeEditModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>


@section('script')
    <script>
        // ????????????????????
        $('#expertise-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '{{route('material.modal.expertise.index', ['material'=>$material->id])}}',
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'number', name: 'number'},
                {data: 'case_number', name: 'case_number'},
                {data: 'type', name: 'type'},
                {data: 'decree_reg_number', name: 'decree_reg_number'},
                {data: 'receipt_date', name: 'receipt_date'},
                {data: 'status', name: 'status'},
                {data: 'subjects', name: 'subjects'},
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
            }
        });

        // ???????????????????? ??????????????????
        let conclusionsTable = $('#conclusion-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '{{route('material.modal.conclusions.index', ['material'=>$material->id])}}',
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'materials', name: 'materials'},
                {data: 'file', name: 'file'},
                {data: 'options', name: 'options'},
                {data: 'result', name: 'result'},
                {data: 'status', name: 'status'},
                // {data: 'experts', name: 'experts'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "createdRow": function (row, data, rowIndex) {
                // Per-cell function to do whatever needed with cells
                $.each($('td', row), function (colIndex) {
                    var $title = $('#conclusion-table thead tr th:nth-child(' + (colIndex + 1) + ')');
                    // For example, adding data-* attributes to the cell
                    $(this).attr('data-title', $title.data('title') ?? null);
                });
            },
            "order": [[0, "desc"]],
            "language": {
                "url": "{{asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')}}"
            }
        });

        // ???????????????? ????????????????????
        let decisionsTable = $('#decision-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '{{route('material.modal.decisions.index', ['material'=>$material->id])}}',
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'article', name: 'article'},
                {data: 'court_decision', name: 'court_decision'},
                {data: 'comment', name: 'comment'},
                {data: 'status', name: 'status'},
                {data: 'date', name: 'date'},
                {data: 'creator', name: 'creator'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "createdRow": function (row, data, rowIndex) {
                // Per-cell function to do whatever needed with cells
                $.each($('td', row), function (colIndex) {
                    var $title = $('#decision-table thead tr th:nth-child(' + (colIndex + 1) + ')');
                    // For example, adding data-* attributes to the cell
                    $(this).attr('data-title', $title.data('title') ?? null);
                });
            },
            "order": [[0, "desc"]],
            "language": {
                "url": "{{asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')}}"
            }
        });
        //???????????? ????????????????????
        let analyzeMaterialsTable = $('#analyze-materials').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '{{route('material.modal.material-analyzes.index', ['material'=>$material->id])}}',
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'search_material', name: 'search_material'},
                {
                    data: 'coefficient', name: 'coefficient',
                },
                {data: 'material', name: 'material'},
                {data: 'language', name: 'language'},
                {data: 'conclusion', name: 'conclusion'},
                {data: 'action', name: 'action'},
            ],
            "createdRow": function (row, data, rowIndex) {
                // Per-cell function to do whatever needed with cells
                $.each($('td', row), function (colIndex) {
                    var $title = $('#decision-table thead tr th:nth-child(' + (colIndex + 1) + ')');
                    // For example, adding data-* attributes to the cell
                    $(this).attr('data-title', $title.data('title') ?? null);
                });
            },
            "order": [[0, "desc"]],
            "language": {
                "url": "{{asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')}}"
            }
        });
        //???????????? ??????????????????????
        let analyzeImagesTable = $('#analyze-images').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '{{route('material.modal.material-analyzes-images.index', ['material'=>$material->id])}}',
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'search_material', name: 'search_material'},
                {data: 'search_image', name: 'search_image', orderable: false, searchable: false},
                {
                    data: 'coefficient', name: 'coefficient',
                },
                {data: 'image', name: 'image', orderable: false, searchable: false},
                {data: 'image_name', name: 'image_name'},
                {
                    data: 'size', name: 'size',
                },
                {data: 'material', name: 'material'},
                {data: 'conclusion', name: 'conclusion'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "createdRow": function (row, data, rowIndex) {
                // Per-cell function to do whatever needed with cells
                $.each($('td', row), function (colIndex) {
                    var $title = $('#decision-table thead tr th:nth-child(' + (colIndex + 1) + ')');
                    // For example, adding data-* attributes to the cell
                    $(this).attr('data-title', $title.data('title') ?? null);
                });
            },
            "order": [[0, "desc"]],
            "language": {
                "url": "{{asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')}}"
            }
        });

        // ??????????????
        $('#material-history-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '{!! route('histories.index', ['model_type' => get_class($material), 'model_id' => $material->id]) !!}',
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'message', name: 'message'},
                // {data: 'model_type', name: 'model_type'},
                {data: 'meta', name: 'meta'},
                {data: 'user', name: 'user'},
                {data: 'performed_at', name: 'performed_at'},
            ],
            "createdRow": function (row, data, rowIndex) {
                // Per-cell function to do whatever needed with cells
                $.each($('td', row), function (colIndex) {
                    var $title = $('#material-history-table thead tr th:nth-child(' + (colIndex + 1) + ')');
                    // For example, adding data-* attributes to the cell
                    $(this).attr('data-title', $title.data('title') ?? null);
                });
            },
            "order": [[0, "desc"]],
            "language": {
                "url": "{{asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')}}"
            }
        });
        //
    </script>
    {{--show CRUD modal--}}
    <script>
        let modalClass = '';
        $(document).on('click', '.show-crud-modal', function (e) {
            e.preventDefault();
            startPreloader();
            modalClass = $(this).data('modal');
            if (modalClass != undefined) {
                $('#CRUD-modal .modal-dialog').removeClass('modal-lg');
            }
            $.ajax({
                method: 'get',
                url: $(this).data('url'),
                data: {
                    'material_id': '{{ $material->id }}',
                },
                success: (data) => {
                    $('#CRUD-modal .modal-dialog').addClass(modalClass);
                    $('#CRUD-modal .modal-content').html(data);
                    $('#CRUD-modal').modal('show');
                    $(this).prop('disabled', false);
                    stopPreloader();
                },
                error: function (error) {
                    alert('Server error:' + error.status);
                }
            });
        });
    </script>
    {{--store and edit--}}
    <script>
        $('#CRUD-modal').on('submit', '#modal-form', function (e) {
            startPreloader();
            e.preventDefault();
            $.ajax({
                method: 'post',
                url: $(this).attr('action'),
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: (data) => {
                    if (data.entity === 'conclusion') {
                        if (data.action === 'stored') {
                            $('#count-conclusions').text(parseInt($('#count-conclusions').text()) + 1);
                        }
                        conclusionsTable.ajax.reload();
                    }
                    if (data.entity === 'decision') {
                        if (data.action === 'stored') {
                            $('#count-decisions').text(parseInt($('#count-decisions').text()) + 1);
                        }
                        decisionsTable.ajax.reload();
                    }
                    if (data.entity === 'analyze-material') {
                        analyzeMaterialsTable.ajax.reload();
                    }
                    if (data.entity === 'material_analyze_image') {
                        analyzeImagesTable.ajax.reload();
                    }
                    $('#CRUD-modal').modal('hide');
                    stopPreloader();
                },
                error: function (error) {
                    stopPreloader();
                    if (error.status === 422) {
                        $.each(error.responseJSON.errors, function (i, error) {
                            var el = $('#CRUD-modal').find('[name="' + i + '"]');
                            if (el.length == 0) {
                                el = $('#CRUD-modal').find('[name="' + i + '[]"]');
                            }
                            if (el.length != 0) {
                                el.parent().append($('<em class="ajax-modal-error error">' + error[0] + '</em>'));
                            } else {
                                alert(error[0]);
                                // $('#errors-container').append('<em class="ajax-modal-error error">' + error[0] + '</em>');
                            }
                            $('#CRUD-modal').scrollTop(0);
                        });
                    } else {
                        alert('Server error:' + error.status);
                    }
                }
            })
        })
    </script>
    {{-- delete conclusions, expertises, decisions--}}
    <script>
        $(document).on('click', '.modal-delete', function (e) {
            e.preventDefault();
            if (!confirm('???? ?????????????????????????? ???????????? ???????????????')) {
                return;
            }
            startPreloader();
            $.ajax({
                method: 'delete',
                url: $(this).data('url') + "?material_id=" + "{{ $material->id }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: (data) => {
                    if (data === 'conclusion') {
                        conclusionsTable.ajax.reload();
                        $('#count-conclusions').text(parseInt($('#count-conclusions').text()) - 1);
                    } else if (data === 'expertise') {
                        conclusionsTable.ajax.reload();
                        $('#count-expertise').text(parseInt($('#count-expertise').text()) - 1);
                    } else if (data === 'decision') {
                        decisionsTable.ajax.reload();
                        $('#count-decisions').text(parseInt($('#count-decisions').text()) - 1);
                    } else if (data === 'analyze_material') {
                        analyzeMaterialsTable.ajax.reload();
                        $('#count-analyze-materials').text(parseInt($('#count-analyze-materials').text()) - 1);
                    } else if (data === 'material_analyze_image') {
                        analyzeImagesTable.ajax.reload();
                        $('#count-analyze-images').text(parseInt($('#count-analyze-images').text()) - 1);
                    }
                    stopPreloader();
                },
                error: function (error) {
                    if (error.status === 422) {
                        alert(error.responseJSON.errors);
                    } else {
                        alert('Server error:' + error.status);
                    }
                    stopPreloader()
                }
            })
        })
    </script>
    {{--  clear modal after hidden  --}}
    <script>
        $('#CRUD-modal').on('hidden.bs.modal', function () {
            $(this).find('.modal-content').empty();
            $(this).find('.modal-dialog').addClass('modal-lg');
            $(this).find('.modal-dialog').removeClass(modalClass);
            modalClass = undefined;
        });
    </script>
@endsection
