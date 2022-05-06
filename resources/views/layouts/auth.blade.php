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

    <!-- start: Css -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/bootstrap.min.css')}}">

    <!-- plugins -->
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/font-awesome.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/simple-line-icons.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/animate.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/icheck/skins/flat/aero.css')}}"/>
    <link href="{{asset('asset/css/style.css')}}" rel="stylesheet">
    <!-- end: Css -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body id="mimin" class="dashboard form-signin-wrapper" style="background: #ffffff!important;">

<div class="container">
    @yield('content')
</div>

<!-- end: Content -->
<!-- start: Javascript -->
<script src="{{asset('asset/js/jquery.min.js')}}"></script>
<script src="{{asset('asset/js/jquery.ui.min.js')}}"></script>
<script src="{{asset('asset/js/bootstrap.min.js')}}"></script>

<script src="{{asset('asset/js/plugins/moment.min.js')}}"></script>
<script src="{{asset('asset/js/plugins/icheck.min.js')}}"></script>

<!-- custom -->
<script src="{{asset('asset/js/main.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('input').iCheck({
            checkboxClass: 'icheckbox_flat-aero',
            radioClass: 'iradio_flat-aero'
        });
    });
</script>
<!-- end: Javascript -->
</body>
</html>
