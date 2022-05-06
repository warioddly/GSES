@extends('layouts.modal')

@section('content')
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="analyzeEditModalLabel">{{__('Create Contractor')}}</h4>
    </div>
    <div class="modal-body p-0">
        <form id="modal-form" method="POST" enctype="multipart/form-data"
              action="{{ route('modal-contractors.store') }}">
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
                            <div class="col-md-6 px-md-5 form-field">
                                {{AppHelper::selectBlade('type_id', __('Type'), [null=>__('Search for an item')]+$types, null, true)}}
                            </div>
                            <div class="col-md-6 px-md-5 form-field type-depended-elements">
                                {{AppHelper::selectText('organ_id', __('Contractor organ'), [null=>__('Search for an item')]+$organs, null, true)}}
                            </div>
                            <div class="col-md-6 px-md-5 form-field">
                                {{AppHelper::dependedSelectBlade('region_id', __('Region'), [null=>__('Search for an item')] + $regions, null, true)}}
                            </div>
                            <div class="col-md-6 px-md-5 form-field">
                                {{AppHelper::dependedSelectBlade('district_id', __('District'), [null=>__('Search for an item')] + $districts, null, true, 'region_id', $typeRelation)}}
                            </div>
                            <div class="col-md-6 px-md-5 form-field type-depended-elements">
                                {{AppHelper::textBlade('sub_organ', __('Subdivision name'), null, false)}}
                            </div>
                            <div class="col-md-6 px-md-5 form-field">
                                {{AppHelper::selectFIO('last_name', __('Contractor last name'), [null=>__('Search for an item')], null, true)}}
                            </div>
                            <div class="col-md-6 px-md-5 form-field">
                                {{AppHelper::textBlade('name', __('Contractor name'), null, true)}}
                            </div>
                            <div class="col-md-6 px-md-5 form-field">
                                {{AppHelper::textBlade('middle_name', __('Contractor middle name'), null, false)}}
                            </div>
                            <div class="col-md-6 px-md-5 form-field type-depended-elements">
                                {{AppHelper::textBlade('position', __('Contractor position'), null, false)}}
                            </div>
                            <div class="col-md-6 px-md-5 form-field">
                                {{AppHelper::textBlade('phone', __('Contractor phone'), null, false)}}
                            </div>
                            <div class="col-md-6 px-md-5 form-field">
                                {{AppHelper::textBlade('email', __('Contractor email'), null, false)}}
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
