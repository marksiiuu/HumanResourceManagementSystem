<?php $__env->startSection('title','Dashboard'); ?>
<?php $__env->startSection('page-title','Dashboard'); ?>
<?php $__env->startSection('content'); ?>

<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <div>
        <h1>Good <?php echo e(date('H') < 12 ? 'Morning' : (date('H') < 17 ? 'Afternoon' : 'Evening')); ?>,
        <?php echo e(Str::words(auth()->user()->name, 1, '')); ?>!</h1>
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item active">Dashboard — Home</li>
        </ol></nav>
    </div>
    <div class="text-muted small d-none d-md-block">
        <i class="bi bi-calendar3 me-1"></i>
        <span id="phDate"></span>
    </div>
</div>


<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#E3EDF9;color:#253D90;"><i class="bi bi-people-fill"></i></div>
            <div class="stat-value" style="color:#253D90;"><?php echo e(number_format($stats['total_employees'])); ?></div>
            <div class="stat-label">Active Employees</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f5e9;color:#2e7d32;"><i class="bi bi-diagram-3-fill"></i></div>
            <div class="stat-value" style="color:#2e7d32;"><?php echo e($stats['total_departments']); ?></div>
            <div class="stat-label">Departments</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff3e0;color:#e65100;"><i class="bi bi-hourglass-split"></i></div>
            <div class="stat-value" style="color:#e65100;"><?php echo e($stats['pending_leaves']); ?></div>
            <div class="stat-label">Pending Leaves</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e3f2fd;color:#1565c0;"><i class="bi bi-person-check-fill"></i></div>
            <div class="stat-value" style="color:#1565c0;"><?php echo e($stats['today_present']); ?></div>
            <div class="stat-label">Present Today (PHT)</div>
        </div>
    </div>
</div>

<?php if(auth()->user()->employee): ?>

<div class="card mb-4" style="background:linear-gradient(135deg,#253D90,#3a56b5);color:#fff;border:none;">
    <div class="card-body">
        <div class="row align-items-center g-3">
            <div class="col-md-4 d-flex align-items-center gap-3">
                <img src="<?php echo e(auth()->user()->employee->avatar_url); ?>" alt=""
                     class="rounded-circle flex-shrink-0"
                     style="width:56px;height:56px;object-fit:cover;border:2px solid rgba(255,255,255,.3);"
                     onerror="this.src='https://ui-avatars.com/api/?name=<?php echo e(urlencode(auth()->user()->name)); ?>&background=ffffff&color=253D90&size=56&bold=true'">
                <div>
                    <div style="font-size:1.05rem;font-weight:700;"><?php echo e(auth()->user()->name); ?></div>
                    <div style="font-size:.82rem;opacity:.8;"><?php echo e(auth()->user()->employee->position); ?></div>
                    <div style="font-size:.72rem;opacity:.6;"><?php echo e(auth()->user()->employee->department?->name); ?></div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row g-2">
                    <?php $leaveTypes = \App\Models\LeaveType::take(3)->get(); $empId = auth()->user()->employee->id; ?>
                    <?php $__currentLoopData = $leaveTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $used = \App\Models\Leave::where('employee_id',$empId)->where('leave_type_id',$lt->id)
                            ->whereYear('created_at',date('Y'))->where('status','approved')->sum('total_days');
                        $rem  = $lt->max_days_per_year - $used;
                        $pct  = $lt->max_days_per_year > 0 ? max(0,round(($rem/$lt->max_days_per_year)*100)) : 0;
                    ?>
                    <div class="col-4">
                        <div style="background:rgba(255,255,255,.15);border-radius:10px;padding:.7rem;text-align:center;">
                            <div style="font-size:1.5rem;font-weight:800;"><?php echo e(max(0,$rem)); ?></div>
                            <div style="font-size:.68rem;opacity:.8;margin-bottom:.35rem;"><?php echo e($lt->name); ?></div>
                            <div style="background:rgba(255,255,255,.2);border-radius:4px;height:4px;">
                                <div style="background:#fff;width:<?php echo e($pct); ?>%;height:4px;border-radius:4px;"></div>
                            </div>
                            <div style="font-size:.62rem;opacity:.6;margin-top:.25rem;"><?php echo e(max(0,$rem)); ?>/<?php echo e($lt->max_days_per_year); ?> days</div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0"><i class="bi bi-lightning-fill me-2" style="color:#253D90;"></i>Quick Access</h6></div>
    <div class="card-body py-2">
        <div class="d-flex flex-wrap gap-2">
            <a href="<?php echo e(route('leaves.create')); ?>" class="btn btn-primary btn-sm"><i class="bi bi-calendar-plus me-1"></i>Apply for Leave</a>
            <a href="<?php echo e(route('payroll.my')); ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-wallet2 me-1"></i>View Payslip</a>
            <a href="<?php echo e(route('attendance.my')); ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-person-check me-1"></i>My Attendance</a>
            <a href="<?php echo e(route('leaves.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-list-check me-1"></i>Leave History</a>
        </div>
    </div>
</div>


<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0"><i class="bi bi-clock me-2" style="color:#253D90;"></i>Time Tracking</h6>
                <span class="text-muted small" id="liveClockCard"></span>
            </div>
            <div class="card-body">
                <?php $todayAtt = \App\Models\Attendance::where('employee_id',auth()->user()->employee->id)->where('date',\Carbon\Carbon::today('Asia/Manila')->format('Y-m-d'))->first(); ?>
                <?php if($todayAtt): ?>
                <div class="mb-3 p-3 rounded" style="background:#E3EDF9;">
                    <div class="small text-muted mb-1 fw-600">Today's Record</div>
                    <div class="d-flex justify-content-around">
                        <div class="text-center">
                            <div class="small text-muted">Time In</div>
                            <div class="fw-700 small"><?php echo e($todayAtt->time_in ? \Carbon\Carbon::parse($todayAtt->time_in)->format('h:i A') : '—'); ?></div>
                        </div>
                        <div class="text-center">
                            <div class="small text-muted">Time Out</div>
                            <div class="fw-700 small"><?php echo e($todayAtt->time_out ? \Carbon\Carbon::parse($todayAtt->time_out)->format('h:i A') : 'Not yet'); ?></div>
                        </div>
                        <div class="text-center">
                            <div class="small text-muted">Hours</div>
                            <div class="fw-700 small"><?php echo e($todayAtt->hours_worked ? $todayAtt->hours_worked.'h' : '—'); ?></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <form method="POST" action="<?php echo e(route('attendance.clock')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-fingerprint me-2"></i>
                        <?php if(!$todayAtt): ?> Clock In
                        <?php elseif(!$todayAtt->time_out): ?> Clock Out
                        <?php else: ?> Already Clocked Out Today <?php endif; ?>
                    </button>
                </form>
                <small class="text-muted d-block mt-2 text-center">All times in Philippine Standard Time (PHT)</small>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><h6 class="mb-0"><i class="bi bi-megaphone me-2" style="color:#253D90;"></i>Announcements</h6></div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0 py-2 border-0">
                        <div class="small fw-600">Welcome to Nexus HR</div>
                        <div class="text-muted" style="font-size:.75rem;">Use Quick Access above to navigate frequently used features.</div>
                    </div>
                    <div class="list-group-item px-0 py-2 border-0">
                        <div class="small fw-600">Leave Policy Reminder</div>
                        <div class="text-muted" style="font-size:.75rem;">Submit leave requests at least 3 working days in advance.</div>
                    </div>
                    <div class="list-group-item px-0 py-2 border-0">
                        <div class="small fw-600">Payroll Schedule</div>
                        <div class="text-muted" style="font-size:.75rem;">Payslips released every 15th and last working day of the month.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h6><i class="bi bi-bar-chart-fill me-2" style="color:#253D90;"></i>7-Day Attendance (PHT)</h6></div>
            <div class="card-body"><canvas id="attendanceChart" height="120"></canvas></div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><h6><i class="bi bi-diagram-3 me-2" style="color:#253D90;"></i>Department Headcount</h6></div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <?php $__currentLoopData = $departmentStats->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="list-group-item d-flex align-items-center justify-content-between px-3 py-2">
                        <div>
                            <div class="small fw-600"><?php echo e($dept->name); ?></div>
                            <div class="text-muted" style="font-size:.72rem;"><?php echo e($dept->code); ?></div>
                        </div>
                        <span class="badge rounded-pill" style="background:#253D90;"><?php echo e($dept->employees_count); ?></span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(auth()->user()->hasHrAccess()): ?>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0"><i class="bi bi-calendar-x me-2" style="color:#253D90;"></i>Pending Leave Requests</h6>
                <a href="<?php echo e(route('leaves.index')); ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Employee</th><th>Type</th><th>Days</th><th>Actions</th></tr></thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentLeaves->where('status','pending'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($leave->employee->full_name)); ?>&background=253D90&color=fff&size=30&bold=true"
                                         class="rounded-circle" style="width:30px;height:30px;">
                                    <span class="small fw-500"><?php echo e($leave->employee->full_name); ?></span>
                                </div>
                            </td>
                            <td class="small text-muted"><?php echo e($leave->leaveType->name); ?></td>
                            <td class="small"><?php echo e($leave->total_days); ?>d</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <form method="POST" action="<?php echo e(route('leaves.approve',$leave)); ?>">
                                        <?php echo csrf_field(); ?> <button class="btn btn-success btn-sm" title="Approve"><i class="bi bi-check2"></i></button>
                                    </form>
                                    <a href="<?php echo e(route('leaves.show',$leave)); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-right"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="4" class="text-center text-muted py-3 small">No pending requests</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0"><i class="bi bi-person-plus me-2" style="color:#253D90;"></i>Recent Employees</h6>
                <a href="<?php echo e(route('employees.create')); ?>" class="btn btn-sm btn-primary"><i class="bi bi-plus me-1"></i>Add</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Name</th><th>Position</th><th>Status</th></tr></thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentEmployees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="<?php echo e($emp->avatar_url); ?>" class="rounded-circle" style="width:30px;height:30px;object-fit:cover;"
                                         onerror="this.src='https://ui-avatars.com/api/?name=<?php echo e(urlencode($emp->full_name)); ?>&background=253D90&color=fff&size=30&bold=true'">
                                    <div>
                                        <div class="small fw-500"><?php echo e($emp->full_name); ?></div>
                                        <div class="text-muted" style="font-size:.7rem;"><?php echo e($emp->employee_id); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="small"><?php echo e(Str::limit($emp->position,20)); ?></td>
                            <td><?php echo $emp->status_badge; ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="3" class="text-center text-muted py-3 small">No employees</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
// PH Date display
function updatePHDate(){
    const ph = new Date(new Date().toLocaleString('en-US',{timeZone:'Asia/Manila'}));
    const opts = {weekday:'long',year:'numeric',month:'long',day:'numeric'};
    const el = document.getElementById('phDate');
    if(el) el.textContent = ph.toLocaleDateString('en-PH',opts);
    // Also update clock card
    const cc = document.getElementById('liveClockCard');
    if(cc){
        const h=ph.getHours(),m=ph.getMinutes(),s=ph.getSeconds();
        const ampm=h>=12?'PM':'AM',hr=h%12||12;
        cc.textContent=`${String(hr).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')} ${ampm} PHT`;
    }
}
setInterval(updatePHDate,1000); updatePHDate();

// Attendance chart
const ctx = document.getElementById('attendanceChart').getContext('2d');
new Chart(ctx,{
    type:'bar',
    data:{
        labels:<?php echo json_encode(array_column($monthlyAttendance, 'date'), 512) ?>,
        datasets:[
            {label:'Present',data:<?php echo json_encode(array_column($monthlyAttendance, 'present'), 512) ?>,backgroundColor:'#253D90',borderRadius:5},
            {label:'Absent', data:<?php echo json_encode(array_column($monthlyAttendance, 'absent'), 512) ?>, backgroundColor:'#E3EDF9',borderRadius:5},
        ]
    },
    options:{responsive:true,plugins:{legend:{position:'top'}},scales:{y:{beginAtZero:true,ticks:{stepSize:1}}}}
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marco\Desktop\Laravel\hrms\resources\views/dashboard/index.blade.php ENDPATH**/ ?>