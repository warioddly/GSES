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

    <!-- start: Css -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('asset/css/bootstrap.min.css')); ?>">

    <!-- plugins -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('asset/css/plugins/font-awesome.min.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('asset/css/plugins/simple-line-icons.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('asset/css/plugins/animate.min.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('asset/css/plugins/icheck/skins/flat/aero.css')); ?>"/>
    <link href="<?php echo e(asset('asset/css/style.css')); ?>" rel="stylesheet">
    <!-- end: Css -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body id="mimin" class="dashboard form-signin-wrapper" style="background: #ffffff!important;">

<div class="container">
    <?php echo $__env->yieldContent('content'); ?>
</div>

<!-- end: Content -->
<!-- start: Javascript -->
<script src="<?php echo e(asset('asset/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('asset/js/jquery.ui.min.js')); ?>"></script>
<script src="<?php echo e(asset('asset/js/bootstrap.min.js')); ?>"></script>

<script src="<?php echo e(asset('asset/js/plugins/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('asset/js/plugins/icheck.min.js')); ?>"></script>

<!-- custom -->
<script src="<?php echo e(asset('asset/js/main.js')); ?>"></script>
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
<?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.0\resources\views/layouts/auth.blade.php ENDPATH**/ ?>