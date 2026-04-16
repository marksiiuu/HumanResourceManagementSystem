<?php $__env->startSection('title','Payroll'); ?>
<?php $__env->startSection('page-title','Payroll Management'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1>Payroll Records</h1>
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Home</a></li>
            <li class="breadcrumb-item active">Payroll</li>
        </ol></nav>
    </div>
    <a href="<?php echo e(route('payroll.create')); ?>" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Generate Payroll</a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-3">
                <select name="employee_id" class="form-select form-select-sm">
                    <option value="">All Employees</option>
                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($emp->id); ?>" <?php echo e(request('employee_id')==$emp->id?'selected':''); ?>><?php echo e($emp->full_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="year" class="form-select form-select-sm">
                    <option value="">All Years</option>
                    <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($y); ?>" <?php echo e(request('year')==$y?'selected':''); ?>><?php echo e($y); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="month" class="form-select form-select-sm">
                    <option value="">All Months</option>
                    <?php for($m=1;$m<=12;$m++): ?>
                    <option value="<?php echo e($m); ?>" <?php echo e(request('month')==$m?'selected':''); ?>><?php echo e(date('F',mktime(0,0,0,$m,1))); ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="pay_period" class="form-select form-select-sm">
                    <option value="">All Schedules</option>
                    <option value="semi_monthly" <?php echo e(request('pay_period')=='semi_monthly'?'selected':''); ?>>Semi-Monthly</option>
                    <option value="monthly" <?php echo e(request('pay_period')=='monthly'?'selected':''); ?>>Monthly</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <?php $__currentLoopData = ['draft','processed','paid']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s); ?>" <?php echo e(request('status')==$s?'selected':''); ?>><?php echo e(ucfirst($s)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                <a href="<?php echo e(route('payroll.index')); ?>" class="btn btn-outline-secondary btn-sm ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h6><i class="bi bi-cash-stack me-2"></i>Payroll Records</h6>
        <span class="badge bg-secondary"><?php echo e($payrolls->total()); ?> records</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Period</th>
                    <th>Schedule</th>
                    <th>Basic</th>
                    <th>Gross</th>
                    <th>Deductions</th>
                    <th>Net Pay</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $payrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($pay->employee->full_name)); ?>&background=253D90&color=fff&size=34&bold=true"
                                 class="rounded-circle" style="width:34px;height:34px;">
                            <div>
                                <div class="small fw-600"><?php echo e($pay->employee->full_name); ?></div>
                                <div class="text-muted" style="font-size:.72rem;"><?php echo e($pay->employee->department?->name); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="small">
                        <?php echo e($pay->month_name); ?> <?php echo e($pay->year); ?>

                        <?php if($pay->pay_period_type && $pay->pay_period_type !== 'full'): ?>
                        <div class="text-muted" style="font-size:.7rem;"><?php echo e($pay->pay_period_type === 'first' ? '1st Half (1–15)' : '2nd Half (16–End)'); ?></div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border" style="font-size:.68rem;">
                            <?php echo e($pay->pay_period === 'semi_monthly' ? 'Semi-Monthly' : 'Monthly'); ?>

                        </span>
                    </td>
                    <td class="small">₱<?php echo e(number_format($pay->basic_salary,2)); ?></td>
                    <td class="small">₱<?php echo e(number_format($pay->gross_salary,2)); ?></td>
                    <td class="small text-danger">-₱<?php echo e(number_format($pay->total_deductions,2)); ?></td>
                    <td class="small fw-700" style="color:#253D90;">₱<?php echo e(number_format($pay->net_salary,2)); ?></td>
                    <td><?php echo $pay->status_badge; ?></td>
                    <td class="text-end">
                        <div class="btn-group btn-group-sm">
                            <a href="<?php echo e(route('payroll.show',$pay)); ?>" class="btn btn-outline-secondary" title="View Payslip"><i class="bi bi-receipt"></i></a>
                            <?php if($pay->status !== 'paid'): ?>
                            <a href="<?php echo e(route('payroll.edit',$pay)); ?>" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delPay<?php echo e($pay->id); ?>" title="Delete"><i class="bi bi-trash"></i></button>
                            <?php endif; ?>
                        </div>
                        <!-- Delete Modal -->
                        <div class="modal fade" id="delPay<?php echo e($pay->id); ?>" tabindex="-1">
                            <div class="modal-dialog modal-sm"><div class="modal-content">
                                <div class="modal-header"><h6 class="modal-title">Delete Payroll</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
                                <div class="modal-body small">Delete payroll for <strong><?php echo e($pay->employee->full_name); ?></strong> (<?php echo e($pay->month_name); ?> <?php echo e($pay->year); ?>)?</div>
                                <div class="modal-footer">
                                    <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form method="POST" action="<?php echo e(route('payroll.destroy',$pay)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="btn btn-sm btn-danger">Delete</button></form>
                                </div>
                            </div></div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="9" class="text-center text-muted py-4">
                    <i class="bi bi-cash display-6 d-block mb-2"></i>No payroll records found.
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($payrolls->hasPages()): ?>
    <div class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <small class="text-muted">Showing <?php echo e($payrolls->firstItem()); ?>–<?php echo e($payrolls->lastItem()); ?> of <?php echo e($payrolls->total()); ?></small>
        <?php echo e($payrolls->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marco\Desktop\Laravel\hrms\resources\views/payroll/index.blade.php ENDPATH**/ ?>