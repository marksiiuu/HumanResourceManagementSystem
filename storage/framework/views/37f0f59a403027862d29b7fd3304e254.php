<?php $__env->startSection('title', $employee->full_name); ?>
<?php $__env->startSection('page-title','Employee Profile'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1>Employee Profile</h1>
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Home</a></li>
            <?php if(auth()->user()->hasHrAccess()): ?>
            <li class="breadcrumb-item"><a href="<?php echo e(route('employees.index')); ?>">Employees</a></li>
            <?php endif; ?>
            <li class="breadcrumb-item active"><?php echo e($employee->full_name); ?></li>
        </ol></nav>
    </div>
    <?php if(auth()->user()->hasHrAccess()): ?>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('employees.edit',$employee)); ?>" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
        <?php if(!$employee->isArchived()): ?>
        <form method="POST" action="<?php echo e(route('employees.archive',$employee)); ?>" onsubmit="return confirm('Archive <?php echo e(addslashes($employee->full_name)); ?>? Data is preserved.')">
            <?php echo csrf_field(); ?> <button class="btn btn-outline-warning"><i class="bi bi-archive me-1"></i>Archive</button>
        </form>
        <?php else: ?>
        <form method="POST" action="<?php echo e(route('employees.restore',$employee)); ?>">
            <?php echo csrf_field(); ?> <button class="btn btn-outline-success"><i class="bi bi-arrow-counterclockwise me-1"></i>Restore</button>
        </form>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<div class="row g-3">
    
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body text-center py-4">
                <img src="<?php echo e($employee->avatar_url); ?>" alt="<?php echo e($employee->full_name); ?>"
                     class="rounded-circle mb-3" style="width:90px;height:90px;object-fit:cover;border:3px solid #E3EDF9;"
                     onerror="this.src='https://ui-avatars.com/api/?name=<?php echo e(urlencode($employee->full_name)); ?>&background=253D90&color=fff&size=90&bold=true'">
                <h5 class="fw-700 mb-1"><?php echo e($employee->full_name); ?></h5>
                <div class="text-muted small mb-2"><?php echo e($employee->position); ?></div>
                <?php echo $employee->status_badge; ?>

                <?php if($employee->isArchived()): ?>
                <span class="badge bg-warning text-dark ms-1">Archived</span>
                <?php endif; ?>
                <hr>
                <div class="text-start">
                    <div class="d-flex justify-content-between mb-2 small"><span class="text-muted">Employee ID</span><code><?php echo e($employee->employee_id); ?></code></div>
                    <?php if($employee->biometric_id): ?>
                    <div class="d-flex justify-content-between mb-2 small"><span class="text-muted">Biometric ID</span><code><?php echo e($employee->biometric_id); ?></code></div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between mb-2 small"><span class="text-muted">Department</span><span class="fw-500"><?php echo e($employee->department?->name ?? '—'); ?></span></div>
                    <div class="d-flex justify-content-between mb-2 small"><span class="text-muted">Type</span><span><?php echo e(str_replace('_',' ',ucwords($employee->employment_type,'_'))); ?></span></div>
                    <div class="d-flex justify-content-between mb-2 small"><span class="text-muted">Hire Date</span><span><?php echo e($employee->hire_date->format('M d, Y')); ?></span></div>
                    <div class="d-flex justify-content-between mb-2 small"><span class="text-muted">Tenure</span><span><?php echo e($employee->hire_date->diffForHumans(null,true)); ?></span></div>
                    <?php if(auth()->user()->hasPayrollAccess()): ?>
                    <div class="d-flex justify-content-between small"><span class="text-muted">Salary</span><span class="fw-600" style="color:#253D90;">₱<?php echo e(number_format($employee->salary,2)); ?></span></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h6 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Contact</h6></div>
            <div class="card-body">
                <div class="mb-2 d-flex align-items-start gap-2"><i class="bi bi-envelope text-muted mt-1"></i><a href="mailto:<?php echo e($employee->email); ?>" class="small text-break"><?php echo e($employee->email); ?></a></div>
                <div class="mb-2 d-flex align-items-center gap-2"><i class="bi bi-telephone text-muted"></i><span class="small"><?php echo e($employee->phone ?? '—'); ?></span></div>
                <div class="d-flex align-items-start gap-2"><i class="bi bi-geo-alt text-muted mt-1"></i><span class="small"><?php echo e($employee->address ?? '—'); ?></span></div>
                <?php if($employee->emergency_contact_name): ?>
                <hr>
                <div class="small fw-600 mb-1 text-muted">Emergency Contact</div>
                <div class="small"><?php echo e($employee->emergency_contact_name); ?></div>
                <div class="small text-muted"><?php echo e($employee->emergency_contact_phone); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="profileTabs">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#attendance">Attendance</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#leaves">Leaves</a></li>
                    <?php if(auth()->user()->hasPayrollAccess()): ?>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#payroll">Payroll</a></li>
                    <?php endif; ?>
                    <?php if(auth()->user()->id === $employee->user_id || auth()->user()->hasHrAccess()): ?>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#security">Security</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="card-body tab-content p-0">
                <div class="tab-pane fade show active p-0" id="attendance">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead><tr><th>Date</th><th>Time In</th><th>Time Out</th><th>Hours</th><th>Status</th></tr></thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $employee->attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="small"><?php echo e($att->date->format('M d, Y')); ?></td>
                                    <td class="small"><?php echo e($att->time_in ? \Carbon\Carbon::parse($att->time_in)->format('h:i A') : '—'); ?></td>
                                    <td class="small"><?php echo e($att->time_out ? \Carbon\Carbon::parse($att->time_out)->format('h:i A') : '—'); ?></td>
                                    <td class="small"><?php echo e($att->hours_worked ? $att->hours_worked.'h' : '—'); ?></td>
                                    <td><span class="badge bg-<?php echo e(['present'=>'success','absent'=>'danger','late'=>'warning','half_day'=>'info','on_leave'=>'secondary'][$att->status]??'secondary'); ?>"><?php echo e(str_replace('_',' ',ucfirst($att->status))); ?></span></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="5" class="text-center text-muted py-3 small">No attendance records</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade p-0" id="leaves">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead><tr><th>Type</th><th>From</th><th>To</th><th>Days</th><th>Status</th></tr></thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $employee->leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="small"><?php echo e($leave->leaveType->name); ?></td>
                                    <td class="small"><?php echo e($leave->start_date->format('M d, Y')); ?></td>
                                    <td class="small"><?php echo e($leave->end_date->format('M d, Y')); ?></td>
                                    <td class="small"><?php echo e($leave->total_days); ?>d</td>
                                    <td><?php echo $leave->status_badge; ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="5" class="text-center text-muted py-3 small">No leave records</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if(auth()->user()->hasPayrollAccess()): ?>
                <div class="tab-pane fade p-0" id="payroll">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead><tr><th>Period</th><th>Schedule</th><th>Gross</th><th>Deductions</th><th>Net Pay</th><th>Status</th></tr></thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $employee->payrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="small"><?php echo e($pay->month_name); ?> <?php echo e($pay->year); ?>

                                        <?php if($pay->pay_period_type && $pay->pay_period_type !== 'full'): ?>
                                        <div class="text-muted" style="font-size:.68rem;"><?php echo e($pay->pay_period_type === 'first' ? '1st Half' : '2nd Half'); ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td><span class="badge bg-light text-dark border" style="font-size:.65rem;"><?php echo e($pay->pay_period === 'semi_monthly' ? 'Semi' : 'Monthly'); ?></span></td>
                                    <td class="small">₱<?php echo e(number_format($pay->gross_salary,2)); ?></td>
                                    <td class="small text-danger">-₱<?php echo e(number_format($pay->total_deductions,2)); ?></td>
                                    <td class="small fw-600" style="color:#253D90;">₱<?php echo e(number_format($pay->net_salary,2)); ?></td>
                                    <td><?php echo $pay->status_badge; ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="6" class="text-center text-muted py-3 small">No payroll records</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(auth()->user()->id === $employee->user_id || auth()->user()->hasHrAccess()): ?>
                <div class="tab-pane fade p-3" id="security">
                    <h6 class="mb-3">Change Password</h6>
                    <form method="POST" action="<?php echo e(route('employees.update-password', $employee)); ?>" class="col-md-6">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Update Password</button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marco\Desktop\Laravel\hrms\resources\views/employees/show.blade.php ENDPATH**/ ?>