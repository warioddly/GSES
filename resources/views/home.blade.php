@extends('layouts.app')

@section('panel')
    <div class="col-md-6 col-sm-12">
        <h3 class="animated fadeInLeft">{{__('Dashboard')}}</h3>
        <p class="animated fadeInDown"><span class="fa fa-pencil-square"></span> {{__('Fast navigation buttons')}}</p>

        <ul class="nav navbar-nav">
            <li><a href="{{route('expertise.create')}}" >{{__('Create New Expertise')}}</a></li>
            <li><a href="{{route('expertise.index')}}" >{{__('Expertise list')}}</a></li>
            <li><a href="{{route('materials.index')}}" >{{__('Material list')}}</a></li>
            <li><a href="{{route('materials.analyzes.analyze')}}">{{__('Conduct an analysis')}}</a></li>

        </ul>
    </div>
@endsection

@section('content')
    <div class="col-md-12 padding-0">
        <div class="col-md-8 padding-0">
            <div class="col-md-12 padding-0">
                <div class="col-md-6">
                    <div class="panel box-v1">
                        <div class="panel-heading bg-white border-none">
                            <div class="col-md-12 col-sm-12 col-xs-12 text-left padding-0">
                                <h4 class="text-left">{{__('Expertise in total')}}</h4>
                            </div>
                        </div>
                        <div class="panel-body text-center">
                            <h1>{{ $expertiseStatus[null] }}</h1>
                            <p>{{__('All expertises')}}</p>
                            <hr/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel box-v1">
                        <div class="panel-heading bg-white border-none">
                            <div class="col-md-12 col-sm-12 col-xs-12 text-left padding-0">
                                <h4 class="text-left">{{__('Expertise in progress')}}</h4>
                            </div>
                        </div>
                        <div class="panel-body text-center">
                            <h1>{{($expertiseStatus[1]+$expertiseStatus[2])}}</h1>
                            <p>{{__('Submitted for execution')}}</p>
                            <hr/>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4">


            <div class="col-md-12 padding-0">
                <div class="panel box-v3" style="padding: 0px !important;">
                    <div class="panel-heading bg-white border-none">
                        <h4>{{__('Expertise statuses')}}</h4>
                    </div>
                    <div class="panel-body">

                        <div class="media">
                            <div class="media-left">
                                <span class="icon-envelope icons" style="font-size:2em;"></span>
                            </div>
                            <div class="media-body">
                                <h5 class="media-heading">{{__('In production')}}</h5>
                                <div class="progress progress-mini">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="{{($expertiseStatus[1]+$expertiseStatus[2])}}" aria-valuemin="0" aria-valuemax="{{$expertiseStatus[null]}}" style="width: {{AppHelper::percent($expertiseStatus[1]+$expertiseStatus[2], $expertiseStatus[null])}}%;">
                                        <span class="sr-only">{{AppHelper::percent($expertiseStatus[1]+$expertiseStatus[2], $expertiseStatus[null])}}% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="media">
                            <div class="media-left">
                                <span class="icon-energy icons" style="font-size:2em;"></span>
                            </div>
                            <div class="media-body">
                                <h5 class="media-heading">{{__('Return without performance')}}</h5>
                                <div class="progress progress-mini">
                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="{{($expertiseStatus[3]+$expertiseStatus[4])}}" aria-valuemin="0" aria-valuemax="{{$expertiseStatus[null]}}" style="width: {{AppHelper::percent($expertiseStatus[3]+$expertiseStatus[4], $expertiseStatus[null])}}%;">
                                        <span class="sr-only">{{AppHelper::percent($expertiseStatus[3]+$expertiseStatus[4], $expertiseStatus[null])}}% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="media">
                            <div class="media-left">
                                <span class="icon-pie-chart icons" style="font-size:2em;"></span>
                            </div>
                            <div class="media-body">
                                <h5 class="media-heading">{{__('Completed')}}</h5>
                                <div class="progress progress-mini">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$expertiseStatus[5]}}" aria-valuemin="0" aria-valuemax="{{$expertiseStatus[null]}}" style="width: {{AppHelper::percent($expertiseStatus[5], $expertiseStatus[null])}}%;">
                                        <span class="sr-only">{{AppHelper::percent($expertiseStatus[5],$expertiseStatus[null])}}% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>

                </div>
            </div>


        </div>
    </div>
    <div class="col-md-12 card-wrap padding-0">
        <div class="col-md-6">
            <div class="panel">
                <div class="panel-heading bg-white border-none" style="padding:20px;">
                    <div class="col-md-12 col-sm-12 col-sm-12 text-left">
                        <h4>{{__('Total number of assigned expertise')}}</h4>
                    </div>
                </div>
                <div class="panel-body" style="padding-bottom:50px;">
                    <div id="canvas-holder1">
                        <canvas class="expertise-month-chart" style="margin-top:30px;height:200px;">
                            {{ json_encode($expertiseMonths) }}
                        </canvas>
                    </div>
                    <div class="col-md-12" style="padding-top:20px;">
                        @foreach($expertiseContractors as $contractor)
                        <div class="col-md-3 col-sm-4 col-xs-6 text-center">
                            <h2 style="line-height:.4;">{{ $contractor->total }}</h2>
                            <small>{{json_decode($contractor->organ, true)[app()->getLocale()]}}</small>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel">
                <div class="panel-heading bg-white border-none" style="padding:20px;">
                    <div class="col-md-12 col-sm-12 col-sm-12 text-left">
                        <h4>{{__('Information by region')}}</h4>
                    </div>
                </div>

                <div class="panel-body" style="padding-bottom:50px;">
                    <div id="canvas-holder1">
                        <canvas class="expertise-region-chart">
                            {{json_encode($expertiseRegions)}}
                        </canvas>
                    </div>

                    <div class="col-md-12 padding-0" >

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h4>
                                <p>{{__('Total number of assigned expertise')}}</p>
                                @php($years = ['rgb(21,50,186,0.5)', 'rgb(21,113,186,0.5)', 'rgb(21,186,103,0.4)'])
                                @foreach($expertiseYears as $year => $total)
                                <p style="color: {{array_shift($years)}};font-weight: bolder;">{{$year}} {{__('year')}} - {{trans_choice('{0} no expertise|[1,*] :value expertise', $total, ['value'=>$total])}}</p>
                                @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12" style="display: none;">
        <div class="panel bg-green text-white">
            <div class="panel-body">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="maps" style="height:300px;">
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <canvas class="doughnut-chart hidden-xs"></canvas>
                    <div class="col-md-12">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <h1>72.993</h1>
                            <p>People</p>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <h1>12.000</h1>
                            <p>Active</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
