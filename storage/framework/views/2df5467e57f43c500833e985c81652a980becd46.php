<nav class="navbar navbar-default header navbar-fixed-top" style="max-width: 100vw;">
    <div class="col-md-12 nav-wrapper">
        <div class="navbar-header" style="width:100%;">
            <div class="opener-left-menu is-open">
                <span class="top"></span>
                <span class="middle"></span>
                <span class="bottom"></span>
            </div>
            <a href="<?php echo e(route('dashboard')); ?>" class="navbar-brand">
                <b><?php echo e(__('website')); ?></b>
            </a>

            <ul class="nav navbar-nav search-nav">
                <li>
                    <?php echo Form::open(array('id'=>'search-form', 'route' => 'materials.index','method'=>'GET')); ?>

                    <div class="search">
                        <span class="fa fa-search icon-search" style="font-size:23px;"></span>
                        <div class="form-group form-animate-text">
                            <?php echo Form::text('search', '', array('id'=>'search-input', 'class'=>'form-text')); ?>

                            <span class="bar"></span>
                            <label class="label-search"><b><?php echo __('Search'); ?></b></label>
                        </div>
                    </div>
                    <?php echo Form::close(); ?>

                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right user-nav">
                <li class="user-nav">
                    <a href="<?php echo e(asset('asset/media/ГСЭС_в-обучение.mp4')); ?>" title="<?php echo e(__('video lesson')); ?>" download class="px-0">
                        <i class="far fa-question-circle" style="padding-top: 15%;font-size: 20px"></i></a>
                </li>
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="flag-icon flag-icon-<?php echo e(Config::get('languages')[App::getLocale()]['flag-icon']); ?>"></span> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu lang-dropdown">
                        <?php $__currentLoopData = Config::get('languages'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($lang != App::getLocale()): ?>
                                <li><a class="dropdown-item" href="<?php echo e(route('lang.switch', $lang)); ?>"><span class="flag-icon flag-icon-<?php echo e($language['flag-icon']); ?>"></span> <?php echo e($language['display']); ?></a></li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
                <li class="user-name"><span><?php echo e(Auth::user()->name); ?></span></li>
                <li class="dropdown avatar-dropdown pr-3">
                    <img src="<?php echo e(url('asset/img/avatar.jpg')); ?>" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"/>
                    <ul class="dropdown-menu user-dropdown">
                        <li><a href="<?php echo e(route('profile.show')); ?>"><span class="fa fa-user"></span> <?php echo e(__('My Profile')); ?></a></li>
                        <li><a href="#"><span class="fa fa-calendar"></span> <?php echo e(__('My Calendar')); ?></a></li>
                        <li role="separator" class="divider"></li>
                        <li class="more">
                            <ul>
                                <li><a href="" title="<?php echo e(__('Settings')); ?>"><span class="fa fa-cogs"></span></a></li>
                                <li><a href="" title="<?php echo e(__('Password')); ?>"><span class="fa fa-lock"></span></a></li>
                                <li><a href="<?php echo e(route('logout')); ?>" title="<?php echo e(__('Logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span class="fa fa-power-off"></span></a></li>
                            </ul>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                <?php echo csrf_field(); ?>
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
<?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.0\resources\views/layouts/header.blade.php ENDPATH**/ ?>