<?php $__env->startSection('title','My Attendance'); ?>
<?php $__env->startSection('page-title','My Attendance'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1>My Attendance</h1>
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">My Attendance</li>
        </ol></nav>
    </div>
    <form method="POST" action="<?php echo e(route('attendance.clock')); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn btn-primary"><i class="bi bi-clock me-2"></i>Clock In / Clock Out</button>
    </form>
</div>

<!-- Summary Cards -->
<?php
    $thisMonth = $attendances->where('date', '>=', now()->startOfMonth());
    $presentCount = $attendances->where('status','present')->count();
    $lateCount = $attendances->where('status','late')->count();
    $absentCount = $attendances->where('status','absent')->count();
?>
<div class="row g-3 mb-3">
    <div class="col-sm-4">
        <div class="stat-card text-center"><div class="stat-value" style="color:#2e7d32;"><?php echo e($presentCount); ?></div><div class="stat-label">Present</div></div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card text-center"><div class="stat-value" style="color:#f57c00;"><?php echo e($lateCount); ?></div><div class="stat-label">Late</div></div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card text-center"><div class="stat-value" style="color:#c62828;"><?php echo e($absentCount); ?></div><div class="stat-label">Absent</div></div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-auto">
                <input type="month" name="month" class="form-control form-control-sm" value="<?php echo e(request('month', now()->format('Y-m'))); ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                <a href="<?php echo e(route('attendance.my')); ?>" class="btn btn-outline-secondary btn-sm ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header"><h6><i class="bi bi-person-check me-2"></i>Attendance History</h6></div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Date</th><th>Day</th><th>Time In</th><th>Time Out</th><th>Hours Worked</th><th>Status</th><th>Notes</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="small fw-500"><?php echo e($att->date->format('M d, Y')); ?></td>
                    <td class="small text-muted"><?php echo e($att->date->format('l')); ?></td>
                    <td class="small"><?php echo e($att->time_in ? \Carbon\Carbon::parse($att->time_in)->format('h:i A') : '—'); ?></td>
                    <td class="small"><?php echo e($att->time_out ? \Carbon\Carbon::parse($att->time_out)->format('h:i A') : '—'); ?></td>
                    <td class="small"><?php echo e($att->hours_worked ? $att->hours_worked.'h' : '—'); ?></td>
                    <td>
                        <?php $cls=['present'=>'success','absent'=>'danger','late'=>'warning','half_day'=>'info','on_leave'=>'secondary'][$att->status]??'secondary'; ?>
                        <span class="badge bg-<?php echo e($cls); ?>"><?php echo e(str_replace('_',' ',ucfirst($att->status))); ?></span>
                    </td>
                    <td class="small text-muted"><?php echo e($att->notes ?? '—'); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="text-center text-muted py-4">No attendance records for this period.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($attendances->hasPages()): ?>
    <div class="card-footer bg-white"><?php echo e($attendances->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marco\Desktop\Laravel\hrms\resources\views/attendance/my.blade.php ENDPATH**/ ?>