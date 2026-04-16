# 🏢 HRMS — Human Resource Management System

A complete, production-ready Human Resource Management System built with **Laravel 11**, **Bootstrap 5**, and **MySQL**.

---

## ✨ Features

| Module | Features |
|---|---|
| **Authentication** | Login, Register, Password Reset (Laravel Breeze-style) |
| **Role-Based Access** | Admin, HR Manager, Payroll Officer, Job Recruiter, Employee |
| **Dashboard** | Live stats, 7-day attendance chart, department headcount, recent activity |
| **Employee Management** | Full CRUD, profile photo upload, department assignment |
| **Department Management** | Full CRUD, manager assignment, headcount display |
| **Attendance** | Clock In/Out, daily records, filtering by date/employee/status |
| **Leave Management** | Apply, Approve, Reject, Cancel; leave type config; overlap detection |
| **Payroll** | Generate payslips, live salary calculator, SSS/PhilHealth/Pag-IBIG deductions, print-ready payslip |
| **User Management** | Admin-only user CRUD, role assignment, account activation |

---

## 🚀 Quick Setup

### 1. Prerequisites

- PHP >= 8.2
- Composer
- MySQL 8.0+
- Node.js (optional, for assets)

### 2. Install Dependencies

```bash
cd hrms
composer install
```

### 3. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hrms_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Create the Database

```sql
CREATE DATABASE hrms_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Run Migrations & Seed

```bash
php artisan migrate --seed
```

### 6. Storage Link (for avatar uploads)

```bash
php artisan storage:link
```

### 7. Serve

```bash
php artisan serve
```

Visit: **http://localhost:8000**

---

## 🔑 Demo Credentials

| Role | Email | Password |
|---|---|---|
| Administrator | admin@hrms.local | password |
| HR Manager | hr@hrms.local | password |
| Payroll Officer | payroll@hrms.local | password |
| Employee | ana.cruz@company.com | password |
| Employee | carlo.lim@company.com | password |

---

## 🏗️ Project Structure

```
hrms/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                    # Auth controllers
│   │   │   ├── DashboardController.php
│   │   │   ├── EmployeeController.php
│   │   │   ├── DepartmentController.php
│   │   │   ├── AttendanceController.php
│   │   │   ├── LeaveController.php
│   │   │   ├── PayrollController.php
│   │   │   └── UserController.php
│   │   ├── Middleware/
│   │   │   └── CheckRole.php            # RBAC middleware
│   │   └── Requests/
│   │       └── Auth/LoginRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Employee.php
│   │   ├── Department.php
│   │   ├── Attendance.php
│   │   ├── LeaveType.php
│   │   ├── Leave.php
│   │   └── Payroll.php
│   └── Providers/
│       └── AppServiceProvider.php
├── bootstrap/
│   └── app.php                          # Middleware registration
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── database.php
│   └── filesystems.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000001_create_users_table.php
│   │   ├── 2024_01_01_000002_create_departments_table.php
│   │   ├── 2024_01_01_000003_create_employees_table.php
│   │   ├── 2024_01_01_000004_create_attendances_table.php
│   │   ├── 2024_01_01_000005_create_leaves_table.php
│   │   └── 2024_01_01_000006_create_payrolls_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php            # Main layout with sidebar
│       │   └── auth.blade.php           # Auth pages layout
│       ├── auth/
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   └── forgot-password.blade.php
│       ├── dashboard/
│       │   └── index.blade.php
│       ├── employees/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── show.blade.php
│       │   └── edit.blade.php
│       ├── departments/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── show.blade.php
│       │   └── edit.blade.php
│       ├── attendance/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── my.blade.php
│       ├── leaves/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── show.blade.php
│       │   └── edit.blade.php
│       ├── payroll/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── show.blade.php
│       │   ├── edit.blade.php
│       │   └── my.blade.php
│       └── users/
│           ├── index.blade.php
│           ├── create.blade.php
│           └── edit.blade.php
└── routes/
    └── web.php
```

---

## 👥 Role Permissions

| Feature | Admin | HR Manager | Payroll Officer | Job Recruiter | Employee |
|---|:---:|:---:|:---:|:---:|:---:|
| Dashboard | ✅ | ✅ | ✅ | ✅ | ✅ |
| Employee CRUD | ✅ | ✅ | ❌ | ❌ | ❌ |
| Department CRUD | ✅ | ✅ | ❌ | ❌ | ❌ |
| Attendance (all) | ✅ | ✅ | ❌ | ❌ | ❌ |
| My Attendance | ✅ | ✅ | ✅ | ✅ | ✅ |
| Approve Leaves | ✅ | ✅ | ❌ | ❌ | ❌ |
| Apply Leave | ✅ | ✅ | ✅ | ✅ | ✅ |
| Payroll CRUD | ✅ | ✅ | ✅ | ❌ | ❌ |
| My Payslips | ✅ | ✅ | ✅ | ✅ | ✅ |
| User Management | ✅ | ❌ | ❌ | ❌ | ❌ |

---

## 🗄️ Database Schema

```
users              employees           departments
──────────────     ──────────────     ──────────────
id                 id                 id
name               user_id (FK)       name
email              department_id (FK) code
password           employee_id        description
role               first_name         manager_id (FK)
is_active          last_name          is_active
                   email
                   phone
                   position
                   employment_type
                   status
                   hire_date
                   salary
                   avatar

attendances        leaves             payrolls
──────────────     ──────────────     ──────────────
id                 id                 id
employee_id (FK)   employee_id (FK)   employee_id (FK)
date               leave_type_id (FK) year / month
time_in            start_date         basic_salary
time_out           end_date           gross_salary
hours_worked       total_days         deductions (x5)
status             reason             net_salary
                   status             days_worked
                   approved_by (FK)   status
```

---

## 🎨 Tech Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **Frontend**: Bootstrap 5.3, Bootstrap Icons
- **Charts**: Chart.js
- **Database**: MySQL 8.0
- **Auth**: Custom session auth (Breeze pattern)
- **Storage**: Laravel filesystem (local disk for avatars)
- **Colors**: `#253D90` (primary blue), `#E3EDF9` (accent light blue)

---

## 🔧 Optional Enhancements (Ready to Add)

- **PDF Export** — Add `barryvdh/laravel-dompdf` and a PDF route for payslips
- **CSV Export** — Add `maatwebsite/excel` for employee/attendance reports
- **Email Notifications** — Laravel Mail for leave approval emails
- **Search** — Already implemented on all index pages
- **Pagination** — Active on all listing pages (15 items default)

---

## 📜 License

MIT — Free to use and modify.
