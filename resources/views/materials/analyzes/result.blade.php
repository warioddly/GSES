@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Material analysis results')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="{{ route('materials.index') }}"> {{__('Close')}}</a>
            </h3>
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
                <table class="table table-striped table-bordered" id="analyze-table" style="width:100%">
                <thead>
                    <tr>
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
    </div>

@endsection

@section('script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#analyze-table').DataTable( {
        "processing": false,
        "serverSide": false,
        "ajax": {
            'url': '{{route('materials.analyzes.search.get', ['material_id'=>$material_id, 'document_id'=>$document_id])}}',
            'beforeSend': function (){
                startPreloader();
            },
            'complete': function (){
                stopPreloader();
            }
        },
        "columns": [
            {data: 'search_material', name: 'search_material'},
            {
                data: 'coefficient', name: 'coefficient',
                render: function ( data, type, row ) {
                    if ( type === 'display' ) {
                        return row.coefficient_render;
                    }
                    return data;
                }
            },
            {data: 'material', name: 'material'},
            {data: 'language', name: 'language'},
            {data: 'conclusion', name: 'conclusion'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "createdRow": function (row, data, rowIndex) {
            $(row).attr('data-material_id', data.material_id);
            // Per-cell function to do whatever needed with cells
            $.each($('td', row), function (colIndex) {
                var $title = $('#analyze-table thead tr th:nth-child('+(colIndex+1)+')');
                // For example, adding data-* attributes to the cell
                $(this).attr('data-title', $title.data('title')??null);
            });
        },
        "order": [[ 1, "desc" ]],
        "language": {
            "url": "{{asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')}}"
        },
    } );

    function showAnalyze(analyze){
        $.post('{{route('materials.analyzes.get_detail')}}', analyze, function(data){
            $('#analyzeEditModal').replaceWith(data);

            $("#analyzeEditModal select.select2:not([multiple])").select2({
                placeholder: '{{__('Search for an item')}}',
                theme: 'default',
                allowClear: true,
                width: '100%'
            });

            $('#analyzeEditModal').modal('show');

            $('#save-result').click(function (){
                save_analyze_result(function(data){
                    $('#analyzeEditModal').modal('hide');
                    $('tr[data-material_id="'+data.material_id+'"] td:nth-child(5)').html(data.conclusion);
                    for (var key in data) {
                        analyze[key] = data[key];
                    }
                });
            });
        });
    }

    function save_analyze_result(callback){
        var form = document.getElementById('analyze-form');
        var formData = new FormData(form);
        $.ajax({
            // Your server script to process the upload
            url: '{{route('materials.analyzes.save')}}',
            type: 'POST',
            // Form data
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).then(callback);
    }
</script>
    <div id="analyzeEditModal"></div>
@endsection
