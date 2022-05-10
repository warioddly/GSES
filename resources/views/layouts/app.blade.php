<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="description" content="{{ __('website') }}">
    <meta name="author" content="Put In Byte">
    <meta name="keyword" content="суд,экспертиза,гсэс">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('website') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/bootstrap.min.css') }}">

    <!-- plugins -->
    {{--    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/plugins/font-awesome.min.css')  }}"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/plugins/icheck/skins/flat/red.css')  }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/plugins/dropzone.css')  }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/plugins/simple-line-icons.css')  }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/plugins/animate.min.css')  }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/plugins/fullcalendar.min.css')  }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/plugins/datatables.bootstrap.min.css')  }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/plugins/select2.min.css')  }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/plugins/jquery.datetimepicker.css')  }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/style.css')  }}">

@stack('page-styles')
    <!-- end: Css -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>




</head>

<body id="mimin" class="{{explode('.', Route::currentRouteName())[0]}} @guest guest @else logged-in @endguest">

<!-- start: Header -->
@include('layouts.header')

<!-- end: Header -->
<div class="container-fluid mimin-wrapper">

    <!-- start:Left Menu -->
    <div id="left-menu">
        <div class="sub-left-menu scroll" style="overflow: hidden; outline: none; cursor: -webkit-grab;">
            @include('layouts.sidebar')
        </div>
    </div>
    <!-- end: Left Menu -->


    <!-- start: content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                @if(session()->has('accessError'))
                    <div class="alert alert-danger">
                        <p>{{   session()->get('accessError') }}</p>
                    </div>
                @endif
                @yield('panel')
            </div>
        </div>

        <div class="col-md-12" style="padding:20px;">
            @yield('content')
        </div>
    </div>
    <!-- end: content -->


    <!-- start: right menu -->
@include('layouts.right-menu')
<!-- end: right menu -->

</div>

<!-- start: Mobile -->
<div id="mimin-mobile" class="reverse">
    <div class="mimin-mobile-menu-list">
        <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
            @include('layouts.sidebar')
        </div>
    </div>
</div>
<button id="mimin-mobile-menu-opener" class="animated rubberBand btn btn-circle btn-danger">
    <span class="fa fa-bars"></span>
</button>
<!-- end: Mobile -->

@include('layouts.scripts')
@yield('script')
@stack('page-scripts')
@include('layouts.history')
<div id="layout-preloader" style="display: none">
    <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

</body>
</html>
