<?php $__env->startSection('title','Biometrics'); ?>
<?php $__env->startSection('page-title','Biometric Management'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1>Biometric Logs</h1>
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Home</a></li>
            <li class="breadcrumb-item active">Biometrics</li>
        </ol></nav>
    </div>
    <?php if($unprocessed > 0): ?>
    <form method="POST" action="<?php echo e(route('biometric.process')); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn btn-warning">
            <i class="bi bi-arrow-repeat me-1"></i>Process <?php echo e($unprocessed); ?> Pending Logs
        </button>
    </form>
    <?php endif; ?>
</div>

<?php if($unprocessed > 0): ?>
<div class="alert alert-warning d-flex align-items-center gap-2 mb-3">
    <i class="bi bi-fingerprint fs-5"></i>
    <div><strong><?php echo e($unprocessed); ?> unprocessed biometric log(s)</strong> — Click "Process" to automatically convert them into attendance records.</div>
</div>
<?php endif; ?>

<div class="card mb-3">
    <div class="card-header"><h6><i class="bi bi-fingerprint me-2"></i>Simulate Biometric Tap (Demo)</h6></div>
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('biometric.tap')); ?>" class="row g-2 align-items-end">
            <?php echo csrf_field(); ?>
            <div class="col-md-4">
                <label class="form-label">Employee</label>
                <select name="employee_id" class="form-select" required>
                    <option value="">Select Employee</option>
                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($emp->id); ?>"><?php echo e($emp->full_name); ?> (<?php echo e($emp->employee_id); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Log Type</label>
                <select name="log_type" class="form-select">
                    <option value="time_in">Time In</option>
                    <option value="time_out">Time Out</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-fingerprint me-1"></i>Record Tap (PH Time)
                </button>
            </div>
        </form>
        <small class="text-muted d-block mt-2">
            <i class="bi bi-info-circle me-1"></i>Times are recorded in Philippine Standard Time (UTC+8). After tapping, click "Process Pending Logs" to convert to attendance records automatically.
        </small>
    </div>
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
                <input type="date" name="date" class="form-control form-control-sm" value="<?php echo e(request('date')); ?>">
            </div>
            <div class="col-md-2">
                <select name="processed" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="0" <?php echo e(request('processed')==='0'?'selected':''); ?>>Unprocessed</option>
                    <option value="1" <?php echo e(request('processed')==='1'?'selected':''); ?>>Processed</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                <a href="<?php echo e(route('biometric.index')); ?>" class="btn btn-outline-secondary btn-sm ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h6><i class="bi bi-list-ul me-2"></i>Biometric Records</h6>
        <span class="badge bg-secondary"><?php echo e($logs->total()); ?> records</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Employee</th><th>Log Time (PHT)</th><th>Type</th><th>Device</th><th>Status</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="small fw-600"><?php echo e($log->employee->full_name); ?></div>
                        <div class="text-muted" style="font-size:.72rem;"><?php echo e($log->employee->employee_id); ?></div>
                    </td>
                    <td class="small"><?php echo e(\Carbon\Carbon::parse($log->log_time)->timezone('Asia/Manila')->format('M d, Y h:i:s A')); ?></td>
                    <td><span class="badge <?php echo e($log->log_type=='time_in' ? 'bg-success' : 'bg-danger'); ?>"><?php echo e($log->log_type=='time_in' ? 'Time In' : 'Time Out'); ?></span></td>
                    <td class="small text-muted"><?php echo e($log->device_id ?? 'DEVICE-01'); ?></td>
                    <td><span class="badge <?php echo e($log->processed ? 'bg-success' : 'bg-warning text-dark'); ?>"><?php echo e($log->processed ? 'Processed' : 'Pending'); ?></span></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center text-muted py-4">
                    <i class="bi bi-fingerprint display-6 d-block mb-2"></i>No biometric logs found.
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($logs->hasPages()): ?>
    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
        <small class="text-muted">Showing <?php echo e($logs->firstItem()); ?>–<?php echo e($logs->lastItem()); ?> of <?php echo e($logs->total()); ?></small>
        <?php echo e($logs->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marco\Desktop\Laravel\hrms\resources\views/biometric/index.blade.php ENDPATH**/ ?>