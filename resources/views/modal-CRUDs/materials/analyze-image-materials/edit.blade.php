@extends('layouts.modal')

@section('content')
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="analyzeEditModalLabel">{{__('Analysis tool')}}
            - {{$material_analyzes_image->material()->value('name')}}</h4>
    </div>
    <div class="modal-body p-0">
        {!! Form::model($material_analyzes_image, ['id'=>'modal-form', 'method' => 'PATCH', 'route' => ['material.modal.material-analyzes-images.update', $material_analyzes_image->id], 'enctype'=>'multipart/form-data']) !!}
        {!! Form::hidden('id', $material_analyzes_image->id); !!}
        {!! Form::hidden('search_image_id', $material_analyzes_image->search_image_id); !!}
        {!! Form::hidden('image_id', $material_analyzes_image->image_id); !!}
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
                            {{AppHelper::showBlade(__('Source image'), $material_analyzes_image->searchImage()->first())}}
                        </div>
                        <div class="col-md-6 px-md-5 form-multi-field">
                            {{AppHelper::showBlade(__('Found image'), $material_analyzes_image->image()->first())}}
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
                            {{AppHelper::selectBlade('', __('Source Material'), [null=>__('Search for an item')] + $materials, $material_analyzes_image->searchMaterial()->value('materials.id'), false, true)}}
                        </div>
                        <div class="col-md-6 px-md-5 form-field">
                            {{AppHelper::selectBlade('', __('Found material'), [null=>__('Search for an item')] + $materials, $material_analyzes_image->material()->value('materials.id'), false, true)}}
                        </div>
                        <div class="col-md-6 px-md-5 form-field">
                            {{AppHelper::textBlade('', __('Match found in module'), $material_analyzes_image->material()->exists() ? get_class($material_analyzes_image->material()->first()) : null, false, true)}}
                        </div>
                        <div class="col-md-6 px-md-5 form-field">
                            {{AppHelper::textBlade('', __('Match found in expertise'), $material_analyzes_image->material()->exists() && $material_analyzes_image->material()->first()->expertise()->exists() ? $material_analyzes_image->material()->first()->expertise()->first()->name : null, false, true)}}
                        </div>
                        <div class="col-md-6 px-md-5 form-field">
                            {{AppHelper::textBlade('coefficient', __('Coincidence rate'), null, false, true)}}
                        </div>
                        <div class="col-md-6 px-md-5 form-field">
                            {{AppHelper::textBlade('size', __('Original size'), null, false, true)}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($material_analyzes_image->searchMaterial()->exists())
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
        @if($material_analyzes_image->searchMaterial()->exists())
            <button type="submit" class="btn btn-primary" form="modal-form">{{__('Save comparison result')}}</button>
        @endif
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
    </div>


@endsection
