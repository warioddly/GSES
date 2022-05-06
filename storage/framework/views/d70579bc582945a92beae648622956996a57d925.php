

<?php $__env->startSection('content'); ?>

<form class="form-signin" method="POST" action="<?php echo e(route('password.email')); ?>" style="padding-top: 10%;">
    <?php echo csrf_field(); ?>
    <div class="panel periodic-login">
        <div class="panel-body text-center">
            <?php if(session('status')): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-xs-4 col-sm-4">
                    <img  src="<?php echo e(url('asset/img/GSES.jpg')); ?>" style="height: 80px"/>
                </div>
                <div class="col-xs-8 col-sm-8">
                    <div class="atomic-number" style="text-align: center;font-size: xx-large;line-height: 80px;"><?php echo e(config('app.name', 'Laravel')); ?></div>
                </div>
            </div>
            <div class="atomic-number" style="text-align: center;font-size: x-large;margin-top: 10px;"><?php echo e(__('Reset Password')); ?></div>
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
            <input type="submit" class="btn col-xs-12 col-md-12" value="<?php echo e(__('Send Password Reset Link')); ?>" style="margin-top: 13px;white-space: normal;"/>
        </div>
    </div>
</form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IMO\PhpstormProjects\GSES 2.0\resources\views/auth/passwords/email.blade.php ENDPATH**/ ?>