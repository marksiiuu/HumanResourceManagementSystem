<?php $__env->startSection('title','New Job Posting'); ?>
<?php $__env->startSection('page-title','New Job Posting'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1>Create Job Posting</h1>
    <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('recruitment.index')); ?>">Recruitment</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol></nav>
</div>

<div class="row justify-content-center">
<div class="col-lg-8">
<form method="POST" action="<?php echo e(route('recruitment.store')); ?>">
<?php echo csrf_field(); ?>
<div class="card mb-3">
    <div class="card-header"><h6><i class="bi bi-briefcase me-2"></i>Job Details</h6></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Job Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('title')); ?>" required>
                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label class="form-label">Department</label>
                <select name="department_id" class="form-select">
                    <option value="">Select Department</option>
                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($d->id); ?>" <?php echo e(old('department_id')==$d->id?'selected':''); ?>><?php echo e($d->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Employment Type <span class="text-danger">*</span></label>
                <select name="employment_type" class="form-select" required>
                    <?php $__currentLoopData = ['full_time'=>'Full Time','part_time'=>'Part Time','contract'=>'Contract','intern'=>'Intern']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v=>$l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($v); ?>" <?php echo e(old('employment_type','full_time')==$v?'selected':''); ?>><?php echo e($l); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">No. of Slots <span class="text-danger">*</span></label>
                <input type="number" name="slots" class="form-control" value="<?php echo e(old('slots',1)); ?>" min="1" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Min Salary (₱)</label>
                <input type="number" name="salary_min" class="form-control" value="<?php echo e(old('salary_min')); ?>" min="0" step="0.01">
            </div>
            <div class="col-md-3">
                <label class="form-label">Max Salary (₱)</label>
                <input type="number" name="salary_max" class="form-control" value="<?php echo e(old('salary_max')); ?>" min="0" step="0.01">
            </div>
            <div class="col-md-3">
                <label class="form-label">Application Deadline</label>
                <input type="date" name="deadline" class="form-control" value="<?php echo e(old('deadline')); ?>" min="<?php echo e(today()->format('Y-m-d')); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="draft" <?php echo e(old('status','draft')=='draft'?'selected':''); ?>>Draft</option>
                    <option value="open" <?php echo e(old('status')=='open'?'selected':''); ?>>Open</option>
                    <option value="closed" <?php echo e(old('status')=='closed'?'selected':''); ?>>Closed</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Job Description <span class="text-danger">*</span></label>
                <textarea name="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="5" required><?php echo e(old('description')); ?></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-12">
                <label class="form-label">Requirements</label>
                <textarea name="requirements" class="form-control" rows="4" placeholder="Qualifications, skills, experience…"><?php echo e(old('requirements')); ?></textarea>
            </div>
        </div>
    </div>
</div>
<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-1"></i>Create Posting</button>
    <a href="<?php echo e(route('recruitment.index')); ?>" class="btn btn-outline-secondary">Cancel</a>
</div>
</form>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marco\Desktop\Laravel\hrms\resources\views/recruitment/create.blade.php ENDPATH**/ ?>