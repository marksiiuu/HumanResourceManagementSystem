<?php $__env->startSection('title','Edit Employee'); ?>
<?php $__env->startSection('page-title','Edit Employee'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1>Edit Employee</h1>
    <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('employees.index')); ?>">Employees</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('employees.show',$employee)); ?>"><?php echo e($employee->full_name); ?></a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol></nav>
</div>

<form method="POST" action="<?php echo e(route('employees.update',$employee)); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header"><h6><i class="bi bi-person me-2"></i>Personal Information</h6></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('first_name',$employee->first_name)); ?>" required>
                        <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('last_name',$employee->last_name)); ?>" required>
                        <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email',$employee->email)); ?>" required>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone',$employee->phone)); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Select</option>
                            <?php $__currentLoopData = ['male','female','other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($g); ?>" <?php echo e(old('gender',$employee->gender)==$g?'selected':''); ?>><?php echo e(ucfirst($g)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Birth Date</label>
                        <input type="date" name="birth_date" class="form-control" value="<?php echo e(old('birth_date',$employee->birth_date?->format('Y-m-d'))); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <?php $__currentLoopData = ['active','inactive','terminated','on_leave']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s); ?>" <?php echo e(old('status',$employee->status)==$s?'selected':''); ?>><?php echo e(str_replace('_',' ',ucfirst($s))); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2"><?php echo e(old('address',$employee->address)); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><h6><i class="bi bi-briefcase me-2"></i>Employment Information</h6></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-select">
                            <option value="">Select Department</option>
                            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($dept->id); ?>" <?php echo e(old('department_id',$employee->department_id)==$dept->id?'selected':''); ?>><?php echo e($dept->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Biometric ID</label>
                        <input type="text" name="biometric_id" class="form-control" value="<?php echo e(old('biometric_id',$employee->biometric_id)); ?>" placeholder="e.g. BIO-001">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Position <span class="text-danger">*</span></label>
                        <div class="position-relative" id="positionWrapper">
                            <input type="text" name="position" id="positionInput"
                                class="form-control <?php $__errorArgs = ['position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('position',$employee->position)); ?>" placeholder="Select or type a position…"
                                autocomplete="off" required>
                            <div id="positionDropdown" style="display:none;position:absolute;z-index:9999;width:100%;background:#fff;border:1px solid #d1d5db;border-radius:8px;box-shadow:0 6px 20px rgba(0,0,0,.1);max-height:200px;overflow-y:auto;top:calc(100% + 4px);"></div>
                        </div>
                        <?php $__errorArgs = ['position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Employment Type <span class="text-danger">*</span></label>
                        <select name="employment_type" class="form-select" required>
                            <?php $__currentLoopData = ['full_time'=>'Full Time','part_time'=>'Part Time','contract'=>'Contract','intern'=>'Intern']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($val); ?>" <?php echo e(old('employment_type',$employee->employment_type)==$val?'selected':''); ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Hire Date <span class="text-danger">*</span></label>
                        <input type="date" name="hire_date" class="form-control" value="<?php echo e(old('hire_date',$employee->hire_date->format('Y-m-d'))); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Monthly Salary (₱) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">₱</span>
                            <input type="number" name="salary" class="form-control" value="<?php echo e(old('salary',$employee->salary)); ?>" min="0" step="0.01" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h6><i class="bi bi-telephone-forward me-2"></i>Emergency Contact</h6></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Contact Name</label>
                        <input type="text" name="emergency_contact_name" class="form-control" value="<?php echo e(old('emergency_contact_name',$employee->emergency_contact_name)); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Contact Phone</label>
                        <input type="text" name="emergency_contact_phone" class="form-control" value="<?php echo e(old('emergency_contact_phone',$employee->emergency_contact_phone)); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header"><h6><i class="bi bi-image me-2"></i>Profile Photo</h6></div>
            <div class="card-body text-center">
                <?php if($employee->avatar): ?>
                    <img src="<?php echo e(asset('storage/avatars/'.$employee->avatar)); ?>" class="rounded-circle mb-3" id="avatarPreview" style="width:80px;height:80px;object-fit:cover;">
                <?php else: ?>
                    <div class="emp-avatar mx-auto mb-3" id="avatarPreview" style="width:80px;height:80px;font-size:1.8rem;">
                        <?php echo e(strtoupper(substr($employee->first_name,0,1).substr($employee->last_name,0,1))); ?>

                    </div>
                <?php endif; ?>
                <input type="file" name="avatar" class="form-control form-control-sm" accept="image/*" id="avatarInput">
                <small class="text-muted d-block mt-1">Leave blank to keep current photo</small>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary w-100 mb-2"><i class="bi bi-check2 me-2"></i>Save Changes</button>
                <a href="<?php echo e(route('employees.show',$employee)); ?>" class="btn btn-outline-secondary w-100">Cancel</a>
            </div>
        </div>
    </div>
</div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('avatarInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = ev => {
            document.getElementById('avatarPreview').outerHTML = `<img src="${ev.target.result}" id="avatarPreview" class="rounded-circle mb-3" style="width:80px;height:80px;object-fit:cover;">`;
        };
        reader.readAsDataURL(file);
    }
});

// ── Custom Position Autocomplete ──────────────────────────────
const depts       = <?php echo json_encode($departments, 15, 512) ?>;
const deptSelect  = document.querySelector('select[name="department_id"]');
const posInput    = document.getElementById('positionInput');
const posDropdown = document.getElementById('positionDropdown');

const defaultPositions = [
    'Manager', 'Assistant Manager', 'Supervisor', 'Team Lead',
    'Senior Developer', 'Junior Developer', 'Full Stack Developer', 'Frontend Developer', 'Backend Developer',
    'Software Engineer', 'QA Engineer', 'DevOps Engineer', 'System Administrator',
    'UI/UX Designer', 'Graphic Designer', 'Web Designer',
    'Project Manager', 'Product Manager', 'Scrum Master',
    'HR Manager', 'HR Officer', 'HR Assistant', 'Recruiter',
    'Accountant', 'Finance Officer', 'Payroll Officer', 'Bookkeeper',
    'Marketing Manager', 'Marketing Officer', 'Content Writer', 'SEO Specialist', 'Social Media Manager',
    'Sales Manager', 'Sales Representative', 'Account Executive', 'Business Development Officer',
    'Administrative Assistant', 'Office Administrator', 'Secretary', 'Receptionist', 'Clerk',
    'Customer Service Representative', 'Support Specialist', 'Technical Support',
    'IT Manager', 'IT Support', 'Network Engineer', 'Database Administrator',
    'Operations Manager', 'Logistics Coordinator', 'Warehouse Supervisor',
    'Legal Officer', 'Compliance Officer', 'Auditor',
    'Intern', 'Trainee', 'Consultant', 'Contractor',
    'Director', 'Vice President', 'Chief Executive Officer', 'Chief Technology Officer', 'Chief Financial Officer',
];
let currentDeptPositions = [];

function getSuggestions() {
    const combined = [...currentDeptPositions];
    defaultPositions.forEach(p => {
        if (!combined.some(c => c.toLowerCase() === p.toLowerCase())) combined.push(p);
    });
    return combined;
}

function buildDropdown(query) {
    posDropdown.innerHTML = '';
    const all = getSuggestions();
    const filtered = query
        ? all.filter(s => s.toLowerCase().includes(query.toLowerCase()))
        : all;

    if (!filtered.length) { posDropdown.style.display = 'none'; return; }

    const deptCount = currentDeptPositions.filter(p => !query || p.toLowerCase().includes(query.toLowerCase())).length;

    filtered.forEach((pos, i) => {
        if (deptCount > 0 && i === deptCount) {
            const divider = document.createElement('div');
            divider.style.cssText = 'padding:.3rem .85rem;font-size:.65rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;background:#f8fafc;border-bottom:1px solid #e2e8f0;';
            divider.textContent = 'Common Positions';
            posDropdown.appendChild(divider);
        }

        const item = document.createElement('div');
        const isDept = i < deptCount;
        item.style.cssText = 'padding:.5rem .85rem;cursor:pointer;font-size:.85rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:.5rem;transition:background .12s;';
        item.innerHTML = `<i class="bi ${isDept ? 'bi-building' : 'bi-briefcase'}" style="color:${isDept ? '#16a34a' : '#253D90'};font-size:.75rem;"></i><span>${pos}</span>${isDept ? '<span class="badge bg-success bg-opacity-10 text-success ms-auto" style="font-size:.6rem;">Dept</span>' : ''}`;
        item.addEventListener('mouseenter', () => item.style.background = '#E3EDF9');
        item.addEventListener('mouseleave', () => item.style.background = '');
        item.addEventListener('mousedown', e => {
            e.preventDefault();
            posInput.value = pos;
            posDropdown.style.display = 'none';
        });
        posDropdown.appendChild(item);
    });
    posDropdown.style.display = 'block';
}

deptSelect.addEventListener('change', function() {
    const dept = depts.find(d => d.id == this.value);
    currentDeptPositions = (dept && Array.isArray(dept.positions)) ? dept.positions : [];
    if (document.activeElement === posInput) buildDropdown(posInput.value);
});

posInput.addEventListener('focus', () => buildDropdown(posInput.value));
posInput.addEventListener('input', () => buildDropdown(posInput.value));
posInput.addEventListener('blur',  () => setTimeout(() => { posDropdown.style.display = 'none'; }, 150));

// Keyboard navigation
posInput.addEventListener('keydown', e => {
    const items = posDropdown.querySelectorAll('div');
    let active = posDropdown.querySelector('.pos-active');
    if (e.key === 'ArrowDown') {
        e.preventDefault();
        if (!active) { items[0]?.classList.add('pos-active'); items[0] && (items[0].style.background='#E3EDF9'); }
        else { const next = active.nextElementSibling; if(next){active.classList.remove('pos-active');active.style.background='';next.classList.add('pos-active');next.style.background='#E3EDF9';} }
    } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        if (active) { const prev = active.previousElementSibling; active.classList.remove('pos-active');active.style.background=''; if(prev){prev.classList.add('pos-active');prev.style.background='#E3EDF9';} }
    } else if (e.key === 'Enter' && active) {
        e.preventDefault();
        posInput.value = active.querySelector('span').textContent;
        posDropdown.style.display = 'none';
    } else if (e.key === 'Escape') {
        posDropdown.style.display = 'none';
    }
});

if (deptSelect.value) deptSelect.dispatchEvent(new Event('change'));
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marco\Desktop\Laravel\hrms\resources\views/employees/edit.blade.php ENDPATH**/ ?>