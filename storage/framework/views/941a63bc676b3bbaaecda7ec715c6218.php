<?php $__env->startSection('title','Employees'); ?>
<?php $__env->startSection('page-title','Employee Management'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1>Employees</h1>
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Home</a></li>
            <li class="breadcrumb-item active">Employees</li>
        </ol></nav>
    </div>
    <a href="<?php echo e(route('employees.create')); ?>" class="btn btn-primary"><i class="bi bi-person-plus me-2"></i>Add Employee</a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search name, email, ID…" value="<?php echo e(request('search')); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <select name="department_id" class="form-select form-select-sm">
                    <option value="">All Departments</option>
                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($dept->id); ?>" <?php echo e(request('department_id')==$dept->id?'selected':''); ?>><?php echo e($dept->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <?php $__currentLoopData = ['active','inactive','terminated','on_leave']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s); ?>" <?php echo e(request('status')==$s?'selected':''); ?>><?php echo e(str_replace('_',' ',ucfirst($s))); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                <a href="<?php echo e(route('employees.index')); ?>" class="btn btn-outline-secondary btn-sm ms-1">Reset</a>
            </div>
            <div class="col-auto ms-auto">
                <?php if($showArchived): ?>
                    <a href="<?php echo e(route('employees.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-people me-1"></i>Show Active</a>
                <?php else: ?>
                    <a href="<?php echo e(route('employees.index')); ?>?archived=1" class="btn btn-outline-warning btn-sm"><i class="bi bi-archive me-1"></i>Archived (<?php echo e($archivedCount); ?>)</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<?php if($showArchived): ?>
<div class="alert alert-warning mb-3"><i class="bi bi-archive me-2"></i>Showing <strong>archived employees</strong>. Records are preserved and can be restored.</div>
<?php endif; ?>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h6><i class="bi bi-people me-2"></i><?php echo e($showArchived?'Archived':'Active'); ?> Employees</h6>
        <span class="badge bg-secondary"><?php echo e($employees->total()); ?> total</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>ID</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Type</th>
                    <th>Hire Date</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="<?php echo e($emp->avatar_url); ?>" alt="<?php echo e($emp->full_name); ?>"
                                 class="rounded-circle" style="width:34px;height:34px;object-fit:cover;"
                                 onerror="this.src='https://ui-avatars.com/api/?name=<?php echo e(urlencode($emp->full_name)); ?>&background=253D90&color=fff&size=34&bold=true'">
                            <div>
                                <div class="fw-600 small"><?php echo e($emp->full_name); ?></div>
                                <div class="text-muted" style="font-size:.72rem;"><?php echo e($emp->email); ?></div>
                            </div>
                        </div>
                    </td>
                    <td><code class="small"><?php echo e($emp->employee_id); ?></code></td>
                    <td class="small"><?php echo e($emp->department?->name ?? '—'); ?></td>
                    <td class="small"><?php echo e($emp->position); ?></td>
                    <td><span class="badge bg-light text-dark border"><?php echo e(str_replace('_',' ',ucwords($emp->employment_type,'_'))); ?></span></td>
                    <td class="small text-muted"><?php echo e($emp->hire_date->format('M d, Y')); ?></td>
                    <td><?php echo $emp->status_badge; ?></td>
                    <td class="text-end">
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="<?php echo e(route('employees.show',$emp)); ?>" class="btn btn-sm btn-outline-secondary" title="View Profile"><i class="bi bi-person-lines-fill"></i></a>
                            <?php if(!$emp->isArchived()): ?>
                                <a href="<?php echo e(route('employees.edit',$emp)); ?>" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="<?php echo e(route('employees.archive',$emp)); ?>" onsubmit="return confirm('Archive <?php echo e(addslashes($emp->full_name)); ?>? Data will be preserved.')">
                                    <?php echo csrf_field(); ?> <button class="btn btn-sm btn-outline-warning" title="Archive"><i class="bi bi-archive"></i></button>
                                </form>
                            <?php else: ?>
                                <form method="POST" action="<?php echo e(route('employees.restore',$emp)); ?>">
                                    <?php echo csrf_field(); ?> <button class="btn btn-sm btn-outline-success"><i class="bi bi-arrow-counterclockwise me-1"></i>Restore</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="8" class="text-center text-muted py-4">
                    <i class="bi bi-people display-6 d-block mb-2"></i>No employees found.
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($employees->hasPages()): ?>
    <div class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <small class="text-muted">Showing <?php echo e($employees->firstItem()); ?>–<?php echo e($employees->lastItem()); ?> of <?php echo e($employees->total()); ?></small>
        <?php echo e($employees->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marco\Desktop\Laravel\hrms\resources\views/employees/index.blade.php ENDPATH**/ ?>