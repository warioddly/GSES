@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Conduct a new analysis')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="{{ route('dashboard') }}"> {{__('Close')}}</a>
                <button type="submit" class="btn btn-primary" form="analyze-form">{{__('Search')}}</button>
            </h3>
        </div>
    </div>
@endsection

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>{{__('Whoops!')}}</strong> {{__('There were some problems with your input.')}}
        </div>
    @endif

    {!! Form::open(array('id'=>'analyze-form', 'route' => 'materials.analyzes.search','method'=>'POST', 'enctype'=>'multipart/form-data')) !!}

    <div class="row">
        <div class="col-md-6">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">
                        <a role="button" data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1" class="">
                            <h4>{{__('Basic information')}}</h4>
                        </a>
                    </div>
                </div>
                <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1" aria-expanded="true" style="">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 px-md-5 form-field">
                                {{AppHelper::fileBlade('document', __('Source Material'))}}
                            </div>
                            <div class="col-md-12 px-md-5 form-multi-field">
                                {{AppHelper::textareaBlade('text', __('Search text'))}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 panel-footer bg-white border-none">
                        <div class="row">
                            <div class="col-md-12 py-md-3 px-md-5 text-right">
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">{{__('Close')}}</a>
                                <button type="submit" name="type" value="text" class="btn btn-success">{{__('Analyze materials')}}</button>
                                <button type="submit" name="type" value="image" class="btn btn-primary">{{__('Analyze images')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}



@endsection

@section('script')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('input[name="document"]').change(function(){
            if (this.files.length > 0) {
                startPreloader();
                var form_data = new FormData();
                form_data.append('file', this.files[0]);
                $.ajax({
                    url: '{{route('materials.analyzes.extract')}}', // <-- point to server-side PHP script
                    dataType: 'json',  // <-- what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function (data) {
                        stopPreloader();
                        if (!data.result_array.error) {
                            $('textarea[name="text"]').text(data.result_array.file_text);
                        } else {
                            $('textarea[name="text"]').text('');
                            alert(data.result_array.error);
                        }
                    }
                });
            }
            else {
                $('textarea[name="text"]').text('');
            }
        });
    </script>

@endsection
