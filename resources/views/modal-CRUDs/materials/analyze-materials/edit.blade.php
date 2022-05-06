@extends('layouts.modal')

@section('content')
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="analyzeEditModalLabel">{{__('Analysis tool')}}
            - {{$material_analyze->material->name}}</h4>
    </div>
    <div class="modal-body p-0">
        {!! Form::model($material_analyze, ['id'=>'modal-form', 'method' => 'PATCH', 'route' => ['material.modal.material-analyzes.update', $material_analyze], 'enctype'=>'multipart/form-data']) !!}
        {!! Form::hidden('id', $material_analyze->id); !!}
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
                            {{AppHelper::htmlBlade('result', __('Found text'), $material_analyze->result)}}
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
                            {{AppHelper::textBlade('', __('Match found in module'), $material_analyze->material ? get_class($material_analyze->material) : null, false, true)}}
                        </div>
                        <div class="col-md-6 px-md-5 form-field">
                            {{AppHelper::textBlade('', __('Match found in expertise'), $material_analyze->material && $material_analyze->material->expertise->count() ? $material_analyze->material->expertise->first()->name : null, false, true)}}
                        </div>
                        <div class="col-md-6 px-md-5 form-field">
                            {{AppHelper::textBlade('', __('Language'), $material_analyze->material && $material_analyze->material->language ? $material_analyze->material->language->title : null, false, true)}}
                        </div>
                        <div class="col-md-6 px-md-5 form-field">
                            {{AppHelper::textBlade('coefficient', __('Coincidence rate'), null, false, true)}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($material_analyze->search_material_id != null)
            <div class="panel m-0">
                <div class="panel-heading">
                    <div class="panel-title">
                        <a role="button" data-toggle="collapse" href="#collapse3" aria-expanded="true"
                           aria-controls="collapse3" class="">
                            <h4>{{__('Conclusion')}}</h4>
                        </a>
                    </div>
                </div>
                <div id="collapse3" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading3"
                     aria-expanded="true" style="">
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
        @if($material_analyze->search_material_id != null)
            <button type="submit" class="btn btn-primary" form="modal-form">{{__('Save comparison result')}}</button>
        @endif
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
    </div>
@endsection
