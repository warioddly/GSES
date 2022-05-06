@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Show Word')}}</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="pull-right">
            <h3 class="animated fadeInRight">
                <a class="btn btn-default" href="{{ route('modules.marker_black_words.index') }}"> {{__('Close')}}</a>
                @can('marker-black-word-edit')
                <a class="btn btn-primary" href="{{ route('modules.marker_black_words.edit', $marker_word->id) }}"> {{__('Edit')}}</a>
                @endcan
            </h3>
        </div>
    </div>
@endsection

@section('content')

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
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Word'), $marker_word->word)}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {{AppHelper::showBlade(__('Declension'), $marker_word->declensions()->pluck('word')->all())}}
                </div>

            </div>
        </div>
        </div>
    </div>
@endsection
