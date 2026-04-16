<?php $__env->startSection('title','Attendance'); ?>
<?php $__env->startSection('page-title','Attendance Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1>Attendance Records</h1>
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Attendance</li>
        </ol></nav>
    </div>
    <?php if(auth()->user()->hasHrAccess()): ?>
    <a href="<?php echo e(route('attendance.create')); ?>" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Record Attendance</a>
    <?php endif; ?>
</div>

<!-- Filters -->
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
                <input type="date" name="date" class="form-control form-control-sm" value="<?php echo e(request('date')); ?>" placeholder="Date">
            </div>
            <div class="col-md-2">
                <input type="month" name="month" class="form-control form-control-sm" value="<?php echo e(request('month')); ?>" placeholder="Month">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <?php $__currentLoopData = ['present','absent','late','half_day','on_leave']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s); ?>" <?php echo e(request('status')==$s?'selected':''); ?>><?php echo e(str_replace('_',' ',ucfirst($s))); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                <a href="<?php echo e(route('attendance.index')); ?>" class="btn btn-outline-secondary btn-sm ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h6><i class="bi bi-clock-history me-2"></i>Attendance Log</h6>
        <span class="badge bg-secondary"><?php echo e($attendances->total()); ?> records</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Hours</th>
                    <th>Status</th>
                    <th>Notes</th>
                    <?php if(auth()->user()->hasHrAccess()): ?><th class="text-end">Actions</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="emp-avatar" style="width:30px;height:30px;font-size:.7rem;"><?php echo e(strtoupper(substr($att->employee->first_name,0,1).substr($att->employee->last_name,0,1))); ?></div>
                            <div>
                                <div class="small fw-500"><?php echo e($att->employee->full_name); ?></div>
                                <div class="text-muted" style="font-size:.72rem;"><?php echo e($att->employee->department?->name); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="small"><?php echo e($att->date->format('M d, Y')); ?><br><span class="text-muted" style="font-size:.7rem;"><?php echo e($att->date->format('l')); ?></span></td>
                    <td class="small"><?php echo e($att->time_in ? \Carbon\Carbon::parse($att->time_in)->format('h:i A') : '—'); ?></td>
                    <td class="small"><?php echo e($att->time_out ? \Carbon\Carbon::parse($att->time_out)->format('h:i A') : '—'); ?></td>
                    <td class="small"><?php echo e($att->hours_worked ? $att->hours_worked.'h' : '—'); ?></td>
                    <td>
                        <?php $cls=['present'=>'success','absent'=>'danger','late'=>'warning','half_day'=>'info','on_leave'=>'secondary'][$att->status]??'secondary'; ?>
                        <span class="badge bg-<?php echo e($cls); ?>"><?php echo e(str_replace('_',' ',ucfirst($att->status))); ?></span>
                    </td>
                    <td class="small text-muted"><?php echo e(Str::limit($att->notes,30)); ?></td>
                    <?php if(auth()->user()->hasHrAccess()): ?>
                    <td class="text-end">
                        <div class="btn-group btn-group-sm">
                            <a href="<?php echo e(route('attendance.edit',$att)); ?>" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delAtt<?php echo e($att->id); ?>"><i class="bi bi-trash"></i></button>
                        </div>
                        <div class="modal fade" id="delAtt<?php echo e($att->id); ?>" tabindex="-1">
                            <div class="modal-dialog modal-sm"><div class="modal-content">
                                <div class="modal-header"><h6 class="modal-title">Delete Record</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
                                <div class="modal-body small">Delete attendance for <strong><?php echo e($att->employee->full_name); ?></strong> on <?php echo e($att->date->format('M d, Y')); ?>?</div>
                                <div class="modal-footer">
                                    <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form method="POST" action="<?php echo e(route('attendance.destroy',$att)); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div></div>
                        </div>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="8" class="text-center text-muted py-4">
                    <i class="bi bi-clock display-6 d-block mb-2"></i>No attendance records found.
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($attendances->hasPages()): ?>
    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
        <small class="text-muted">Showing <?php echo e($attendances->firstItem()); ?>–<?php echo e($attendances->lastItem()); ?> of <?php echo e($attendances->total()); ?></small>
        <?php echo e($attendances->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marco\Desktop\Laravel\hrms\resources\views/attendance/index.blade.php ENDPATH**/ ?>