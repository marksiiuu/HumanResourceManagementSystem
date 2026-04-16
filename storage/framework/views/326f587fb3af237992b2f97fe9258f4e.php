<?php $__env->startSection('title','User Management'); ?>
<?php $__env->startSection('page-title','User Management'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1><i class="bi bi-shield-person me-2"></i>User Management</h1>
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Home</a></li>
            <li class="breadcrumb-item active">Users</li>
        </ol></nav>
    </div>
    <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary"><i class="bi bi-person-plus me-2"></i>Add User</a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search name or email…" value="<?php echo e(request('search')); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select form-select-sm">
                    <option value="">All Roles</option>
                    <?php $__currentLoopData = \App\Models\User::ROLES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val=>$lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($val); ?>" <?php echo e(request('role')==$val?'selected':''); ?>><?php echo e($lbl); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                <a href="<?php echo e(route('users.index')); ?>" class="btn btn-outline-secondary btn-sm ms-1">Reset</a>
            </div>
            <div class="col-auto ms-auto">
                <?php if($showArchived): ?>
                    <a href="<?php echo e(route('users.index')); ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-people me-1"></i>Show Active
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('users.index')); ?>?archived=1" class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-archive me-1"></i>Archived (<?php echo e($archivedCount); ?>)
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<?php if($showArchived): ?>
<div class="alert alert-warning mb-3"><i class="bi bi-archive me-2"></i>Showing <strong>archived users</strong>. Data is preserved but accounts are deactivated.</div>
<?php endif; ?>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h6><i class="bi bi-shield-person me-2"></i><?php echo e($showArchived ? 'Archived' : 'Active'); ?> Users</h6>
        <span class="badge bg-secondary"><?php echo e($users->total()); ?> users</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>User</th><th>Role</th><th>Default Password</th><th>Status</th><th>Joined</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="emp-avatar" style="width:34px;height:34px;font-size:.78rem;background:#E3EDF9;color:#253D90;"><?php echo e(strtoupper(substr($user->name,0,2))); ?></div>
                            <div>
                                <div class="small fw-600"><?php echo e($user->name); ?></div>
                                <div class="text-muted" style="font-size:.72rem;"><?php echo e($user->email); ?></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php $rc=['admin'=>'danger','hr_manager'=>'primary','payroll_officer'=>'success','job_recruiter'=>'info','employee'=>'secondary'][$user->role]??'secondary'; ?>
                        <span class="badge bg-<?php echo e($rc); ?>"><?php echo e($user->getRoleLabel()); ?></span>
                    </td>
                    <td>
                        <?php if($user->default_password): ?>
                            <div class="d-flex align-items-center gap-1">
                                <code class="small pw-text" id="pw_<?php echo e($user->id); ?>" style="filter:blur(4px);"><?php echo e($user->default_password); ?></code>
                                <button type="button" class="btn btn-outline-secondary" style="font-size:.65rem;padding:.15rem .35rem;line-height:1;"
                                    onclick="const e=document.getElementById('pw_<?php echo e($user->id); ?>');e.style.filter=e.style.filter?'':'blur(4px)'">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                            <div style="font-size:.67rem;color:#f57c00;margin-top:.15rem;">Not yet changed</div>
                        <?php else: ?>
                            <span class="text-muted small">Password changed</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($user->isArchived()): ?><span class="badge bg-warning text-dark">Archived</span>
                        <?php elseif($user->is_active): ?><span class="badge bg-success">Active</span>
                        <?php else: ?><span class="badge bg-danger">Inactive</span><?php endif; ?>
                    </td>
                    <td class="small text-muted"><?php echo e($user->created_at->format('M d, Y')); ?></td>
                    <td class="text-end">
                        <div class="d-flex gap-1 justify-content-end flex-wrap">
                            <?php if(!$user->isArchived()): ?>
                                <a href="<?php echo e(route('users.edit',$user)); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="<?php echo e(route('users.reset-password',$user)); ?>" onsubmit="return confirm('Reset password for <?php echo e(addslashes($user->name)); ?>?')">
                                    <?php echo csrf_field(); ?> <button class="btn btn-sm btn-outline-secondary" title="Reset Password"><i class="bi bi-key"></i></button>
                                </form>
                                <?php if($user->id !== auth()->id()): ?>
                                <form method="POST" action="<?php echo e(route('users.archive',$user)); ?>" onsubmit="return confirm('Archive <?php echo e(addslashes($user->name)); ?>? Data will be preserved.')">
                                    <?php echo csrf_field(); ?> <button class="btn btn-sm btn-outline-warning" title="Archive"><i class="bi bi-archive"></i></button>
                                </form>
                                <?php endif; ?>
                            <?php else: ?>
                                <form method="POST" action="<?php echo e(route('users.restore',$user)); ?>">
                                    <?php echo csrf_field(); ?> <button class="btn btn-sm btn-outline-success"><i class="bi bi-arrow-counterclockwise me-1"></i>Restore</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">No users found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($users->hasPages()): ?>
    <div class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <small class="text-muted">Showing <?php echo e($users->firstItem()); ?>–<?php echo e($users->lastItem()); ?> of <?php echo e($users->total()); ?></small>
        <?php echo e($users->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marco\Desktop\Laravel\hrms\resources\views/users/index.blade.php ENDPATH**/ ?>