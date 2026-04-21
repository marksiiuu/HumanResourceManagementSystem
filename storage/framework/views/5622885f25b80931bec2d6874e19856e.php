<?php $__env->startSection('title', 'Reset Password'); ?>
<?php $__env->startSection('content'); ?>
<h2>Forgot Password?</h2>
<p class="subtitle">Enter your email and we'll send you a reset link.</p>
<?php if(session('status')): ?>
    <div class="alert alert-success mb-3"><i class="bi bi-check-circle me-2"></i><?php echo e(session('status')); ?></div>
<?php endif; ?>
<form method="POST" action="<?php echo e(route('password.email')); ?>">
    <?php echo csrf_field(); ?>
    <div class="mb-4">
        <label class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   value="<?php echo e(old('email')); ?>" placeholder="your@email.com" required autofocus>
        </div>
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <button type="submit" class="btn btn-primary btn-auth"><i class="bi bi-send me-2"></i>Send Reset Link</button>
</form>
<div class="auth-footer"><a href="<?php echo e(route('login')); ?>"><i class="bi bi-arrow-left me-1"></i>Back to Login</a></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marco\Desktop\Laravel\hrms\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>