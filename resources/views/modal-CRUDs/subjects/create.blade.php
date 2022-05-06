@extends('layouts.modal')

@section('content')
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="analyzeEditModalLabel">{{__('Create Contractor')}}ЦФ</h4>
    </div>
    <div class="modal-body p-0">
        <form id="modal-form" method="POST" enctype="multipart/form-data"
              action="{{ route('modal-subject.store') }}">
            @csrf
            <div class="panel m-0">
                <div class="panel-heading">
                    <div class="panel-title">
                        <a role="button" data-toggle="collapse" href="#create-contractor-accordion"
                           aria-expanded="true"
                           aria-controls="collapse1"
                           class="">
                            <h4>{{__('Basic information')}}</h4>
                        </a>
                    </div>
                </div>
                <div id="create-contractor-accordion" class="panel-collapse collapse in" role="tabpanel"
                     aria-labelledby="heading1"
                     aria-expanded="true" style="">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 px-md-5 form-field type-depended-elements">
                                {{AppHelper::textBlade('subject_case', __('Subject case'), null, false)}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="submit" form="modal-form" class="btn btn-primary">{{__('Create')}}</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
    </div>
@endsection
