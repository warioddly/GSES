<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="description" content="<?php echo e(__('website')); ?>">
    <meta name="author" content="Put In Byte">
    <meta name="keyword" content="суд,экспертиза,гсэс">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(__('website')); ?></title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('asset/css/bootstrap.min.css')); ?>">

    <!-- plugins -->
    
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('asset/css/plugins/icheck/skins/flat/red.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('asset/css/plugins/dropzone.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('asset/css/plugins/simple-line-icons.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('asset/css/plugins/animate.min.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('asset/css/plugins/fullcalendar.min.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('asset/css/plugins/datatables.bootstrap.min.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('asset/css/plugins/select2.min.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('asset/css/plugins/jquery.datetimepicker.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('asset/css/style.css')); ?>">
    <?php echo $__env->yieldPushContent('page-styles'); ?>
    <!-- end: Css -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
</head>

<body id="mimin" class="<?php echo e(explode('.', Route::currentRouteName())[0]); ?> <?php if(auth()->guard()->guest()): ?> guest <?php else: ?> logged-in <?php endif; ?>">
<!-- start: Header -->
<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- end: Header -->
<div class="container-fluid mimin-wrapper">

    <!-- start:Left Menu -->
    <div id="left-menu">
        <div class="sub-left-menu scroll" style="overflow: hidden; outline: none; cursor: -webkit-grab;">
            <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    <!-- end: Left Menu -->


    <!-- start: content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <?php if(session()->has('accessError')): ?>
                    <div class="alert alert-danger">
                        <p><?php echo e(session()->get('accessError')); ?></p>
                    </div>
                <?php endif; ?>
                <?php echo $__env->yieldContent('panel'); ?>
            </div>
        </div>

        <div class="col-md-12" style="padding:20px;">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
    <!-- end: content -->


    <!-- start: right menu -->
<?php echo $__env->make('layouts.right-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- end: right menu -->

</div>

<!-- start: Mobile -->
<div id="mimin-mobile" class="reverse">
    <div class="mimin-mobile-menu-list">
        <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
            <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>
<button id="mimin-mobile-menu-opener" class="animated rubberBand btn btn-circle btn-danger">
    <span class="fa fa-bars"></span>
</button>
<!-- end: Mobile -->

<?php echo $__env->make('layouts.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('script'); ?>
<?php echo $__env->yieldPushContent('page-scripts'); ?>
<?php echo $__env->make('layouts.history', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div id="layout-preloader" style="display: none">
    <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\Users\IMO\PhpstormProjects\gses\resources\views/layouts/app.blade.php ENDPATH**/ ?>