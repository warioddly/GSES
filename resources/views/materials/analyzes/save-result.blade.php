<div class="modal fade" id="analyzeEditModal" tabindex="-1" role="dialog" aria-labelledby="analyzeEditModalLabel">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="analyzeEditModalLabel">{{__('Analysis tool')}}
                    - {{$analyze->material->name}}</h4>
            </div>
            <div class="modal-body p-0">
                {!! Form::model($analyze, ['id'=>'analyze-form', 'method' => 'POST', 'route' => 'materials.analyzes.save', 'enctype'=>'multipart/form-data']) !!}
                {!! Form::hidden('id', $analyze->id); !!}
                <div class="panel m-0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse1" aria-expanded="true"
                               aria-controls="collapse1" class="">
                                <h4>{{__('Content of materials')}}</h4>
                            </a>
                        </div>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1"
                         aria-expanded="true" style="">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6 px-md-5 form-multi-field">
                                    {{AppHelper::textareaBlade('search_text', __('Search text'), null, false, true)}}
                                </div>
                                <div class="col-md-6 px-md-5 form-multi-field">
                                    {{AppHelper::htmlBlade('result', __('Found text'), $analyze->result)}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel m-0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse2" aria-expanded="true"
                               aria-controls="collapse2" class="">
                                <h4>{{__('Basic information')}}</h4>
                            </a>
                        </div>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading2"
                         aria-expanded="true" style="">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6 px-md-5 form-field">
                                    {{AppHelper::selectBlade('search_material_id', __('Source Material'), [null=>__('Search for an item')] + $materials, null, false, true)}}
                                </div>
                                <div class="col-md-6 px-md-5 form-field">
                                    {{AppHelper::selectBlade('material_id', __('Found material'), [null=>__('Search for an item')] + $materials, null, false, true)}}
                                </div>
                                <div class="col-md-6 px-md-5 form-field">
                                    {{AppHelper::textBlade('', __('Match found in module'), $analyze->material ? get_class($analyze->material) : null, false, true)}}
                                </div>
                                <div class="col-md-6 px-md-5 form-field">
                                    {{AppHelper::textBlade('', __('Match found in expertise'), $analyze->material && $analyze->material->expertise->count() ? $analyze->material->expertise->first()->name : null, false, true)}}
                                </div>
                                <div class="col-md-6 px-md-5 form-field">
                                    {{AppHelper::textBlade('', __('Language'), $analyze->material && $analyze->material->language ? $analyze->material->language->title : null, false, true)}}
                                </div>
                                <div class="col-md-6 px-md-5 form-field">
                                    {{AppHelper::textBlade('coefficient', __('Coincidence rate'), null, false, true)}}
                                </div>
                                @foreach($analyze->material->n_expertises as $expertise)
                                    <div class="px-md-5" style="display: inline-block">
                                        <span>{{ $loop->index+1 }}. </span><a href="{{ route('expertise.show', $expertise->id) }}">{{ $expertise->name }}</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel m-0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse3" aria-expanded="true"
                               aria-controls="collapse3" class="">
                                <h4>{{__('Expert conclusion')}}</h4>
                            </a>
                        </div>
                    </div>
                    <div id="collapse3" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading3"
                         aria-expanded="true" style="">
                        <div class="panel-body">
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
                                        <th data-title="{{__('Expert')}}">{{__('Expert')}}</th>
                                        <th data-title="{{__('Created at')}}">{{__('Created at')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                <script>
                                    // Заключения экспертов
                                    $('#conclusion-table').DataTable({
                                        "processing": true,
                                        "serverSide": true,
                                        "ajax": '{{route('material.modal.conclusions.index', ['material'=>$analyze->material ? $analyze->material->id : 0])}}',
                                        "columns": [
                                            {data: 'id', name: 'id'},
                                            {data: 'materials', name: 'materials'},
                                            {data: 'file', name: 'file'},
                                            {data: 'options', name: 'options'},
                                            {data: 'result', name: 'result'},
                                            {data: 'status', name: 'status'},
                                            {data: 'experts', name: 'experts'},
                                            {data: 'created_at', name: 'created_at'},
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
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                @if($analyze->search_material_id != null)
                    <div class="panel m-0">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a role="button" data-toggle="collapse" href="#collapse4" aria-expanded="true"
                                   aria-controls="collapse4" class="">
                                    <h4>{{__('Conclusion')}}</h4>
                                </a>
                            </div>
                        </div>
                        <div id="collapse4" class="panel-collapse collapse in" role="tabpanel"
                             aria-labelledby="heading4" aria-expanded="true" style="">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 px-md-5 form-multi-field">
                                        {{AppHelper::textareaBlade('conclusion', __('Conclusions compared materials'))}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                @if($analyze->search_material_id != null)
                    <button type="button" class="btn btn-primary"
                            id="save-result">{{__('Save comparison result')}}</button>
                @endif
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div>
    </div>
</div>
