@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Content analyze')}}: {{$material->name}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="{{ route('materials.index') }}"> {{__('Close')}}</a>
                @can('material-content-analyze')
                    <button type="submit" class="btn btn-primary" form="content-form"> {{__('Reset analysis')}}</button>
                    {!! Form::open(array('id'=>'content-form', 'route' => ['materials.content', $material->id],'method'=>'GET')) !!}
                    {!! Form::hidden('reset', 1) !!}
                    {!! Form::close() !!}
                @endcan
            </h3>
        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-6">
            {{-- Narker words --}}
            <div class="panel">
                <div class="panel-heading bg-primary">
                    <div class="panel-title">
                        <a role="button" data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1" class="">
                            <h4 class="text-white">{{__('Marker words')}}</h4>
                        </a>
                    </div>
                </div>
                <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1" aria-expanded="true" style="">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="responsive-table">
                                    <table class="table table-striped table-bordered table-selected" id="marker-word-table" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th data-title="{{__('Word')}}">{{__('Word')}}</th>
                                            <th data-title="{{__('Frequency')}}">{{__('Frequency')}}</th>
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
            </div>

            {{-- Marker stop words --}}
            <div class="panel">
                <div class="panel-heading bg-success">
                    <div class="panel-title">
                        <a role="button" data-toggle="collapse" href="#collapse2" aria-expanded="true" aria-controls="collapse2" class="">
                            <h4 class="text-white">{{__('Stop words')}}</h4>
                        </a>
                    </div>
                </div>
                <div id="collapse2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading2" aria-expanded="true" style="">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="responsive-table">
                                    <table class="table table-striped table-bordered table-selected" id="marker-stop-word-table" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th data-title="{{__('Word')}}">{{__('Word')}}</th>
                                            <th data-title="{{__('Frequency')}}">{{__('Frequency')}}</th>
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
            </div>

            {{-- Marker black words --}}
            <div class="panel">
                <div class="panel-heading bg-danger">
                    <div class="panel-title">
                        <a role="button" data-toggle="collapse" href="#collapse3" aria-expanded="true" aria-controls="collapse3" class="">
                            <h4 class="text-white">{{__('Keywords')}}</h4>
                        </a>
                    </div>
                </div>
                <div id="collapse3" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading3" aria-expanded="true" style="">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="responsive-table">
                                    <table class="table table-striped table-bordered table-selected" id="marker-black-word-table" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th data-title="{{__('Word')}}">{{__('Word')}}</th>
                                            <th data-title="{{__('Frequency')}}">{{__('Frequency')}}</th>
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
            </div>

        </div>
        <div class="col-md-6">
            <div class="panel">
                <div class="panel-heading bg-teal">
                    <div class="panel-title">
                        <a role="button" data-toggle="collapse" href="#collapse4" aria-expanded="true" aria-controls="collapse4" class="">
                            <h4 class="text-white">{{__('Material text')}}</h4>
                        </a>
                    </div>
                </div>
                <div id="collapse4" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading4" aria-expanded="true" style="">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 search-list large-html">
                                <div id="text-lines"></div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 large-html">
                                {{AppHelper::htmlBlade('file_text', '', $material->file_text)}}
                            </div>
                        </div>
                    </div>
                </div>
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

                var tableWord = $('#marker-word-table').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        'url':'{{route('materials.marker_words')}}?material_id={{$material->id}}&type_id=1',
                        'data': function(data){
                            data.word_count = $('#marker-word-filter-word-count').val();
                        }
                    },
                    "columns": [
                        {data: 'word', name: 'word'},
                        {data: 'frequency', name: 'frequency'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ],
                    "createdRow": function (row, data, rowIndex) {
                        $(row).attr('data-id', data.id);
                        // Per-cell function to do whatever needed with cells
                        $.each($('td', row), function (colIndex) {
                            var $title = $('#marker-word-table thead tr th:nth-child('+(colIndex+1)+')');
                            // For example, adding data-* attributes to the cell
                            $(this).attr('data-title', $title.data('title')??null);
                        });
                    },
                    "order": [[ 1, "desc" ]],
                    "language": {
                        "url": "{{asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')}}",
                    },
                    "pagingType": "simple",
                    "initComplete": function () {
                        $('#marker-word-table_filter input').before('<select id="marker-word-filter-word-count" class="form-control input-sm"><option value="" selected>{{__('All')}}</option><option value="1">{{__('1 word')}}</option><option value="2">{{__('2 words')}}</option><option value="3">{{__('3 words')}}</option></select>');

                        $('#marker-word-filter-word-count').change(function(){
                            tableWord.draw();
                        });
                    }
                } );

                var tableStop = $('#marker-stop-word-table').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        'url':'{{route('materials.marker_words')}}?material_id={{$material->id}}&type_id=2',
                        'data': function(data){
                            data.word_count = $('#marker-stop-word-filter-word-count').val();
                        }
                    },
                    "columns": [
                        {data: 'word', name: 'word'},
                        {data: 'frequency', name: 'frequency'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ],
                    "createdRow": function (row, data, rowIndex) {
                        $(row).attr('data-id', data.id);
                        // Per-cell function to do whatever needed with cells
                        $.each($('td', row), function (colIndex) {
                            var $title = $('#marker-stop-word-table thead tr th:nth-child('+(colIndex+1)+')');
                            // For example, adding data-* attributes to the cell
                            $(this).attr('data-title', $title.data('title')??null);
                        });
                    },
                    "order": [[ 1, "desc" ]],
                    "language": {
                        "url": "{{asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')}}",
                    },
                    "pagingType": "simple",
                    "initComplete": function () {
                        $('#marker-stop-word-table_filter input').before('<select id="marker-stop-word-filter-word-count" class="form-control input-sm"><option value="" selected>{{__('All')}}</option><option value="1">{{__('1 word')}}</option><option value="2">{{__('2 words')}}</option><option value="3">{{__('3 words')}}</option></select>');

                        $('#marker-stop-word-filter-word-count').change(function(){
                            tableStop.draw();
                        });
                    }
                } );

                var tableBlack = $('#marker-black-word-table').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        'url':'{{route('materials.marker_words')}}?material_id={{$material->id}}&type_id=3',
                        'data': function(data){
                            data.word_count = $('#marker-black-word-filter-word-count').val();
                        }
                    },
                    "columns": [
                        {data: 'word', name: 'word'},
                        {data: 'frequency', name: 'frequency'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ],
                    "createdRow": function (row, data, rowIndex) {
                        $(row).attr('data-id', data.id);
                        // Per-cell function to do whatever needed with cells
                        $.each($('td', row), function (colIndex) {
                            var $title = $('#marker-black-word-table thead tr th:nth-child('+(colIndex+1)+')');
                            // For example, adding data-* attributes to the cell
                            $(this).attr('data-title', $title.data('title')??null);
                        });
                    },
                    "order": [[ 1, "desc" ]],
                    "language": {
                        "url": "{{asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')}}"
                    },
                    "pagingType": "simple",
                    "initComplete": function () {
                        $('#marker-black-word-table_filter input').before('<select id="marker-black-word-filter-word-count" class="form-control input-sm"><option value="" selected>{{__('All')}}</option><option value="1">{{__('1 word')}}</option><option value="2">{{__('2 words')}}</option><option value="3">{{__('3 words')}}</option></select>');

                        $('#marker-black-word-filter-word-count').change(function(){
                            tableBlack.draw();
                        });
                    }
                } );

                $('.table-selected tbody').on( 'click', 'tr', function () {
                    if ( $(this).hasClass('selected') ) {
                        $(this).removeClass('selected');
                        highlight(this.dataset.id, true);
                    }
                    else {
                        $('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                        highlight(this.dataset.id);
                    }
                } );

                function highlight(id, clear) {
                    clear = clear ? 1 : 0;
                    $.get('{{ route('materials.content.highlight', $material->id) }}?material_word_id='+id+'&clear='+clear, function(data){
                        $('.large-html textarea[name="file_text"]').val(data.text);
                        $('.large-html .html-element').html(data.text);
                        $('#text-lines').html(data.lines);
                    });
                }

                function set_position(position) {
                    $('.large-html .html-element em').css('backgroundColor', '');
                    $('.large-html .html-element em').css('color', '');
                    $("#pos-"+position).css({'backgroundColor': 'red', 'color': '#fff'});
                    $('.large-html .html-element').stop(true, true).animate({
                        scrollTop: $('.large-html .html-element').scrollTop() + $("#pos-"+position).position().top - 100
                    }, 500);
                }

                function add_word(id, type_id, word_type_id, event) {
                    event.stopPropagation();
                    $.post('{{ route('materials.content.move_word', $material->id) }}','material_word_id='+id+'&type_id='+type_id+'&word_type_id='+word_type_id, function(data){
                        if (data.success) {
                            tableWord.ajax.reload(null, false);
                            tableStop.ajax.reload(null, false);
                            tableBlack.ajax.reload(null, false);
                        }
                        else {
                            alert(data.result || data);
                        }
                    });
                }

                $('#content-form').submit(function (){
                    startPreloader();
                });

            </script>
            @if ($reset)
                <script>
                    $(document).ready(function(){
                        $('#content-form').submit();
                    });
                </script>
            @endif
@endsection
