

<?php $__env->startSection('content'); ?>
<form class="form-signin" method="POST" action="<?php echo e(route('login')); ?>" style="padding-top: 10%;">
    <?php echo csrf_field(); ?>
    <div class="panel periodic-login">
        <div class="panel-body text-center">
            <div class="row">
                <div class="col-xs-4 col-sm-4">
                    <img  src="<?php echo e(url('asset/img/GSES.jpg')); ?>" style="height: 80px"/>
                </div>
                <div class="col-xs-8 col-sm-8">
                    <div class="atomic-number" style="text-align: center;font-size: xx-large;line-height: 80px;"><?php echo e(config('app.name', 'Laravel')); ?></div>
                </div>
            </div>
            <div class="form-group form-animate-text <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> has-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" style="margin-top:20px !important;">
                <input type="email" name="email" id="email" class="form-text" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="help-block" role="alert">
                    <strong><?php echo e($message); ?></strong>
                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <span class="bar"></span>
                <label><?php echo e(__('E-Mail Address')); ?></label>
            </div>
            <div class="form-group form-animate-text <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> has-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" style="margin-top:10px !important;">
                <input type="password" id="password" class="form-text" name="password" required autocomplete="current-password">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="help-block" role="alert">
                    <strong><?php echo e($message); ?></strong>
                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <span class="bar"></span>
                <label><?php echo e(__('Password')); ?></label>
            </div>
            <label class="pull-left">
                <input type="checkbox" id="remember" name="remember" class="icheck pull-left" <?php echo e(old('remember') ? 'checked' : ''); ?>/>
                <?php echo e(__('Remember Me')); ?>

            </label>
            <input type="submit" class="btn col-xs-12 col-md-12" value="<?php echo e(__('Login')); ?>" style="margin-top: 13px;"/>
        </div>
        <?php if(Route::has('password.request')): ?>
            <div class="text-center" style="padding:5px;" >
                <a href="<?php echo e(route('password.request')); ?>"><?php echo e(__('Forgot Your Password?')); ?> </a>
                <?php if(Route::has('register')): ?>
                    <a class="delimiter"> | </a>
                    <a href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a>
                <?php endif; ?>
                <a class="delimiter"> | </a>
                <span class="login-lang">
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
                </span>
            </div>
        <?php endif; ?>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.2\GSES 2.0\resources\views/auth/login.blade.php ENDPATH**/ ?>