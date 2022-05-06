@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Analyze images of material')}}: {{$material->name}}</h3>
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
    <div class="row">
    @forelse($material->images()->get()->all() as $i => $image)
        <div class="col-md-2">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">
                        <a role="button" data-toggle="collapse" href="#collapse{{$i}}" aria-expanded="true" aria-controls="collapse{{$i}}" class="">
                            <h4>{{$image->name}}</h4>
                        </a>
                    </div>
                </div>
                <div id="collapse{{$i}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading{{$i}}" aria-expanded="true" style="">
                    <div class="panel-body">
                        {{AppHelper::showBlade('', $image)}}
                    </div>
                    <div class="panel-footer text-right">
                        <a href="{{ route('materials.images', [$material->id, 'image_id'=>$image->id]) }}" class="btn btn-sm btn-danger">{{__('Analyze')}}</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-md-12">
            <div class="alert alert-warning" role="alert">
                <strong>{{__('Sorry!')}}</strong> {{__('No images found in material.')}}
            </div>
        </div>
    @endforelse
    </div>
@endsection
