<?php $__env->startSection('title','My Payslips'); ?>
<?php $__env->startSection('page-title','My Payslips'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1>My Payslips</h1>
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">My Payslips</li>
        </ol></nav>
    </div>
    <form method="GET" class="d-flex gap-2">
        <select name="year" class="form-select form-select-sm">
            <option value="">All Years</option>
            <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($y); ?>" <?php echo e(request('year')==$y?'selected':''); ?>><?php echo e($y); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
    </form>
</div>

<div class="row g-3">
    <?php $__empty_1 = true; $__currentLoopData = $payrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="col-md-6 col-lg-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="mb-0 fw-700"><?php echo e($pay->month_name); ?> <?php echo e($pay->year); ?></h6>
                    <?php echo $pay->status_badge; ?>

                </div>
                <div class="d-flex justify-content-between mb-2 small">
                    <span class="text-muted">Gross Pay</span>
                    <span class="fw-500">₱<?php echo e(number_format($pay->gross_salary,2)); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2 small">
                    <span class="text-muted">Deductions</span>
                    <span class="text-danger">-₱<?php echo e(number_format($pay->total_deductions,2)); ?></span>
                </div>
                <div class="border-top pt-2 d-flex justify-content-between">
                    <span class="fw-600">Net Pay</span>
                    <span class="fw-700" style="color:#253D90;font-size:1.05rem;">₱<?php echo e(number_format($pay->net_salary,2)); ?></span>
                </div>
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <span class="text-muted small"><?php echo e($pay->days_worked); ?>d worked</span>
                    <a href="<?php echo e(route('payroll.show',$pay)); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye me-1"></i>View Payslip</a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-12">
        <div class="card"><div class="card-body text-center text-muted py-5">
            <i class="bi bi-wallet2 display-4 d-block mb-3"></i>No payslips found.
        </div></div>
    </div>
    <?php endif; ?>
</div>

<?php if($payrolls->hasPages()): ?>
<div class="mt-3 d-flex justify-content-center"><?php echo e($payrolls->links()); ?></div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marco\Desktop\Laravel\hrms\resources\views/payroll/my.blade.php ENDPATH**/ ?>