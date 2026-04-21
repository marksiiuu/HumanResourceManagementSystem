<?php $__env->startSection('title','Edit Job Posting'); ?>
<?php $__env->startSection('page-title','Edit Job Posting'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1>Edit Job Posting</h1>
    <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('recruitment.index')); ?>">Recruitment</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol></nav>
</div>
<div class="row justify-content-center">
<div class="col-lg-8">
<form method="POST" action="<?php echo e(route('recruitment.update',$jobPosting)); ?>">
<?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
<div class="card mb-3">
    <div class="card-header"><h6><i class="bi bi-briefcase me-2"></i>Job Details</h6></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Job Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" value="<?php echo e(old('title',$jobPosting->title)); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Department</label>
                <select name="department_id" class="form-select">
                    <option value="">Select Department</option>
                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($d->id); ?>" <?php echo e(old('department_id',$jobPosting->department_id)==$d->id?'selected':''); ?>><?php echo e($d->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Employment Type <span class="text-danger">*</span></label>
                <select name="employment_type" class="form-select" required>
                    <?php $__currentLoopData = ['full_time'=>'Full Time','part_time'=>'Part Time','contract'=>'Contract','intern'=>'Intern']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v=>$l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($v); ?>" <?php echo e(old('employment_type',$jobPosting->employment_type)==$v?'selected':''); ?>><?php echo e($l); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Slots</label>
                <input type="number" name="slots" class="form-control" value="<?php echo e(old('slots',$jobPosting->slots)); ?>" min="1" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Min Salary (₱)</label>
                <input type="number" name="salary_min" class="form-control" value="<?php echo e(old('salary_min',$jobPosting->salary_min)); ?>" min="0" step="0.01">
            </div>
            <div class="col-md-3">
                <label class="form-label">Max Salary (₱)</label>
                <input type="number" name="salary_max" class="form-control" value="<?php echo e(old('salary_max',$jobPosting->salary_max)); ?>" min="0" step="0.01">
            </div>
            <div class="col-md-3">
                <label class="form-label">Deadline</label>
                <input type="date" name="deadline" class="form-control" value="<?php echo e(old('deadline',$jobPosting->deadline?->format('Y-m-d'))); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <?php $__currentLoopData = ['draft'=>'Draft','open'=>'Open','closed'=>'Closed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v=>$l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($v); ?>" <?php echo e(old('status',$jobPosting->status)==$v?'selected':''); ?>><?php echo e($l); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Job Description <span class="text-danger">*</span></label>
                <textarea name="description" class="form-control" rows="5" required><?php echo e(old('description',$jobPosting->description)); ?></textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Requirements</label>
                <textarea name="requirements" class="form-control" rows="4"><?php echo e(old('requirements',$jobPosting->requirements)); ?></textarea>
            </div>
        </div>
    </div>
</div>
<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-1"></i>Save Changes</button>
    <a href="<?php echo e(route('recruitment.index')); ?>" class="btn btn-outline-secondary">Cancel</a>
</div>
</form>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marco\Desktop\Laravel\hrms\resources\views/recruitment/edit.blade.php ENDPATH**/ ?>