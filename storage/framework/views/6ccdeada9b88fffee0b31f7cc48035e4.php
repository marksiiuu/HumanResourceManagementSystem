<?php $__env->startSection('title','Recruitment'); ?>
<?php $__env->startSection('page-title','Recruitment'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1>Job Postings</h1>
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Home</a></li>
            <li class="breadcrumb-item active">Recruitment</li>
        </ol></nav>
    </div>
    <a href="<?php echo e(route('recruitment.create')); ?>" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>New Job Posting</a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search job title…" value="<?php echo e(request('search')); ?>">
                </div>
            </div>
            <div class="col-md-2">
                <select name="department_id" class="form-select form-select-sm">
                    <option value="">All Departments</option>
                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($d->id); ?>" <?php echo e(request('department_id')==$d->id?'selected':''); ?>><?php echo e($d->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <?php $__currentLoopData = ['draft','open','closed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s); ?>" <?php echo e(request('status')==$s?'selected':''); ?>><?php echo e(ucfirst($s)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                <a href="<?php echo e(route('recruitment.index')); ?>" class="btn btn-outline-secondary btn-sm ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="row g-3">
    <?php $__empty_1 = true; $__currentLoopData = $postings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="col-md-6 col-xl-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div>
                        <h6 class="fw-700 mb-1"><?php echo e($post->title); ?></h6>
                        <div class="text-muted small"><?php echo e($post->department?->name ?? 'No Department'); ?></div>
                    </div>
                    <?php echo $post->status_badge; ?>

                </div>
                <p class="text-muted small mb-3"><?php echo e(Str::limit(strip_tags($post->description), 100)); ?></p>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge bg-light text-dark border"><?php echo e(str_replace('_',' ',ucfirst($post->employment_type))); ?></span>
                    <span class="badge bg-light text-dark border"><?php echo e($post->slots); ?> slot(s)</span>
                    <?php if($post->salary_min): ?>
                    <span class="badge bg-light text-dark border">₱<?php echo e(number_format($post->salary_min)); ?>–<?php echo e(number_format($post->salary_max)); ?></span>
                    <?php endif; ?>
                </div>
                <div class="d-flex justify-content-between align-items-center border-top pt-3">
                    <div>
                        <span class="badge bg-primary"><?php echo e($post->applications->count()); ?> applicant(s)</span>
                        <?php if($post->deadline): ?>
                        <div class="text-muted" style="font-size:.72rem;margin-top:.2rem;">Deadline: <?php echo e($post->deadline->format('M d, Y')); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex gap-1">
                        <a href="<?php echo e(route('recruitment.applications',$post)); ?>" class="btn btn-sm btn-outline-primary" title="Applications">
                            <i class="bi bi-people"></i>
                        </a>
                        <a href="<?php echo e(route('recruitment.edit',$post)); ?>" class="btn btn-sm btn-outline-secondary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="<?php echo e(route('recruitment.archive',$post)); ?>" onsubmit="return confirm('Archive this job posting?')">
                            <?php echo csrf_field(); ?>
                            <button class="btn btn-sm btn-outline-warning" title="Archive"><i class="bi bi-archive"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-12">
        <div class="card"><div class="card-body text-center text-muted py-5">
            <i class="bi bi-briefcase display-4 d-block mb-3"></i>No job postings yet.
            <a href="<?php echo e(route('recruitment.create')); ?>" class="btn btn-primary mt-2">Create First Posting</a>
        </div></div>
    </div>
    <?php endif; ?>
</div>
<?php if($postings->hasPages()): ?>
<div class="mt-3 d-flex justify-content-center"><?php echo e($postings->links()); ?></div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marco\Desktop\Laravel\hrms\resources\views/recruitment/index.blade.php ENDPATH**/ ?>