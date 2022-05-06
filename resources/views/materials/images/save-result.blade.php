<div class="modal fade" id="analyzeEditModal" tabindex="-1" role="dialog" aria-labelledby="analyzeEditModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="analyzeEditModalLabel">{{__('Analysis tool')}} - {{$analyze->material()->value('name')}}</h4>
            </div>
            <div class="modal-body p-0">
                {!! Form::model($analyze, ['id'=>'analyze-form', 'method' => 'POST', 'route' => ['materials.images.save', $analyze->material()->value('materials.id')], 'enctype'=>'multipart/form-data']) !!}
                {!! Form::hidden('id', $analyze->id); !!}
                {!! Form::hidden('search_image_id', $analyze->search_image_id); !!}
                {!! Form::hidden('image_id', $analyze->image_id); !!}
                <div class="panel m-0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1" class="">
                                <h4>{{__('Content of materials')}}</h4>
                            </a>
                        </div>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1" aria-expanded="true" style="">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6 px-md-5 form-multi-field">
                                    {{AppHelper::showBlade(__('Source image'), $analyze->searchImage()->first())}}
                                </div>
                                <div class="col-md-6 px-md-5 form-multi-field">
                                    {{AppHelper::showBlade(__('Found image'), $analyze->image()->first())}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel m-0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse2" aria-expanded="true" aria-controls="collapse2" class="">
                                <h4>{{__('Basic information')}}</h4>
                            </a>
                        </div>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading2" aria-expanded="true" style="">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6 px-md-5 form-field">
                                    {{AppHelper::selectBlade('', __('Source Material'), [null=>__('Search for an item')] + $materials, $analyze->searchMaterial()->value('materials.id'), false, true)}}
                                </div>
                                <div class="col-md-6 px-md-5 form-field">
                                    {{AppHelper::selectBlade('', __('Found material'), [null=>__('Search for an item')] + $materials, $analyze->material()->value('materials.id'), false, true)}}
                                </div>
                                <div class="col-md-6 px-md-5 form-field">
                                    {{AppHelper::textBlade('', __('Match found in module'), $analyze->material()->exists() ? get_class($analyze->material()->first()) : null, false, true)}}
                                </div>
                                <div class="col-md-6 px-md-5 form-field">
                                    {{AppHelper::textBlade('', __('Match found in expertise'), $analyze->material()->exists() && $analyze->material()->first()->expertise()->exists() ? $analyze->material()->first()->expertise()->first()->name : null, false, true)}}
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
                @if($analyze->searchMaterial()->exists())
                <div class="panel m-0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse3" aria-expanded="true" aria-controls="collapse3" class="">
                                <h4>{{__('Conclusion')}}</h4>
                            </a>
                        </div>
                    </div>
                    <div id="collapse3" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading3" aria-expanded="true" style="">
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
                @if($analyze->searchMaterial()->exists())
                <button type="button" class="btn btn-primary" id="save-result">{{__('Save comparison result')}}</button>
                @endif
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div>
    </div>
</div>
