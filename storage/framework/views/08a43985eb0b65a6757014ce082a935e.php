<?php $__env->startSection('title','Leave Requests'); ?>
<?php $__env->startSection('page-title','Leave Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1>Leave Requests</h1>
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Leaves</li>
        </ol></nav>
    </div>
    <a href="<?php echo e(route('leaves.create')); ?>" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Apply for Leave</a>
</div>

<!-- Filters -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-center">
            <?php if(auth()->user()->hasHrAccess()): ?>
            <div class="col-md-3">
                <select name="employee_id" class="form-select form-select-sm">
                    <option value="">All Employees</option>
                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($emp->id); ?>" <?php echo e(request('employee_id')==$emp->id?'selected':''); ?>><?php echo e($emp->full_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <?php endif; ?>
            <div class="col-md-2">
                <select name="leave_type_id" class="form-select form-select-sm">
                    <option value="">All Types</option>
                    <?php $__currentLoopData = $leaveTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($lt->id); ?>" <?php echo e(request('leave_type_id')==$lt->id?'selected':''); ?>><?php echo e($lt->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <?php $__currentLoopData = ['pending','approved','rejected','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s); ?>" <?php echo e(request('status')==$s?'selected':''); ?>><?php echo e(ucfirst($s)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                <a href="<?php echo e(route('leaves.index')); ?>" class="btn btn-outline-secondary btn-sm ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h6><i class="bi bi-calendar-x me-2"></i>Leave Requests</h6>
        <span class="badge bg-secondary"><?php echo e($leaves->total()); ?> total</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Leave Type</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Days</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="emp-avatar" style="width:30px;height:30px;font-size:.7rem;"><?php echo e(strtoupper(substr($leave->employee->first_name,0,1).substr($leave->employee->last_name,0,1))); ?></div>
                            <div>
                                <div class="small fw-500"><?php echo e($leave->employee->full_name); ?></div>
                                <div class="text-muted" style="font-size:.7rem;"><?php echo e($leave->employee->department?->name); ?></div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-light text-dark border"><?php echo e($leave->leaveType->name); ?></span></td>
                    <td class="small"><?php echo e($leave->start_date->format('M d, Y')); ?></td>
                    <td class="small"><?php echo e($leave->end_date->format('M d, Y')); ?></td>
                    <td class="small fw-500"><?php echo e($leave->total_days); ?>d</td>
                    <td class="small text-muted"><?php echo e(Str::limit($leave->reason,40)); ?></td>
                    <td><?php echo $leave->status_badge; ?></td>
                    <td class="text-end">
                        <div class="d-flex gap-1 justify-content-end flex-wrap align-items-center">
                            <a href="<?php echo e(route('employees.show',$leave->employee)); ?>" class="btn btn-sm btn-outline-primary" title="View Profile"><i class="bi bi-person"></i></a>
                            <a href="<?php echo e(route('leaves.show',$leave)); ?>" class="btn btn-sm btn-outline-secondary" title="View Leave Details"><i class="bi bi-info-circle me-1"></i>Details</a>
                            <?php if($leave->status === 'pending'): ?>
                                <?php if(auth()->user()->hasHrAccess()): ?>
                                <form method="POST" action="<?php echo e(route('leaves.approve',$leave)); ?>" class="m-0">
                                    <?php echo csrf_field(); ?> <button type="submit" class="btn btn-sm btn-success" title="Approve"><i class="bi bi-check2"></i></button>
                                </form>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal<?php echo e($leave->id); ?>" title="Reject"><i class="bi bi-x"></i></button>
                                <?php endif; ?>
                                <?php if(auth()->user()->id === $leave->employee->user_id): ?>
                                <form method="POST" action="<?php echo e(route('leaves.cancel',$leave)); ?>" class="m-0">
                                    <?php echo csrf_field(); ?> <button type="submit" class="btn btn-sm btn-warning" title="Cancel" onclick="return confirm('Cancel this leave request?')"><i class="bi bi-x-circle"></i></button>
                                </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Reject Modal -->
                        <?php if($leave->status === 'pending' && auth()->user()->hasHrAccess()): ?>
                        <div class="modal fade" id="rejectModal<?php echo e($leave->id); ?>" tabindex="-1">
                            <div class="modal-dialog"><div class="modal-content">
                                <div class="modal-header"><h6 class="modal-title">Reject Leave Request</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
                                <form method="POST" action="<?php echo e(route('leaves.reject',$leave)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="modal-body">
                                        <p class="small text-muted">Provide a reason for rejecting <strong><?php echo e($leave->employee->full_name); ?>'s</strong> leave request.</p>
                                        <textarea name="rejection_reason" class="form-control" rows="3" required placeholder="Reason for rejection…"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger btn-sm">Reject Leave</button>
                                    </div>
                                </form>
                            </div></div>
                        </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="8" class="text-center text-muted py-4">
                    <i class="bi bi-calendar-x display-6 d-block mb-2"></i>No leave requests found.
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($leaves->hasPages()): ?>
    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
        <small class="text-muted">Showing <?php echo e($leaves->firstItem()); ?>–<?php echo e($leaves->lastItem()); ?> of <?php echo e($leaves->total()); ?></small>
        <?php echo e($leaves->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marco\Desktop\Laravel\hrms\resources\views/leaves/index.blade.php ENDPATH**/ ?>