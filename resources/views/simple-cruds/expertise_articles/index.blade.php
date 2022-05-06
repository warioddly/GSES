@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Articles')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            @can('subject-create')
                <h3 class="animated fadeInRight"><a class="btn btn-success"
                                                    href="{{ route('modules.expertiseArticles.create') }}"> {{__('Create New article')}}</a>
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
    @if ($errors->any())
        <div class="alert alert-danger">
            {!! implode('', $errors->all('<div>:message</div>')) !!}
        </div>
    @endif
    <div class="panel">
        <div class="panel-body">
            <div class="responsive-table">
                <table class="table table-striped table-bordered" id="article-table" style="width:100%">
                    <thead>
                    <tr>
                        <th data-title="{{__('No')}}" width="50">{{__('No')}}</th>
                        <th data-title="{{__('Article')}}">{{__('Article')}}</th>
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
        $('#article-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '{{route('modules.expertiseArticles.index')}}',
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'title', name: 'title'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "order": [[0, "desc"]],
            "language": {
                "url": "{{asset('asset/js/plugins/datatables/i18n/'.app()->getLocale().'.json')}}"
            }
        });
    </script>
@endsection
