<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'staff' => redirect()->route('staff.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        'parent' => redirect()->route('parent.dashboard'),
        default => view('dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// Role-based Dashboards
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // Academic Routes
    Route::resource('classes', App\Http\Controllers\Admin\ClassRoomController::class);
    Route::get('classes/{classRoom}/delete', [App\Http\Controllers\Admin\ClassRoomController::class, 'confirmDelete'])->name('classes.delete');
    Route::post('classes/{classRoom}/assign-subjects', [App\Http\Controllers\Admin\ClassRoomController::class, 'assignSubjects'])->name('classes.assign-subjects');
    Route::resource('subjects', App\Http\Controllers\Admin\SubjectController::class);
    Route::get('subjects/{subject}/delete', [App\Http\Controllers\Admin\SubjectController::class, 'confirmDelete'])->name('subjects.delete');
    Route::get('students/{student}/delete', [App\Http\Controllers\Admin\StudentController::class, 'confirmDelete'])->name('students.delete');
    Route::resource('students', App\Http\Controllers\Admin\StudentController::class);
    Route::get('staff/{staff}/delete', [App\Http\Controllers\Admin\StaffController::class, 'confirmDelete'])->name('staff.delete');
    Route::resource('staff', App\Http\Controllers\Admin\StaffController::class);
    Route::get('parents/{parent}/delete', [App\Http\Controllers\Admin\ParentController::class, 'confirmDelete'])->name('parents.delete');
    Route::resource('parents', App\Http\Controllers\Admin\ParentController::class);
    Route::get('users/{user}/delete', [App\Http\Controllers\Admin\UserController::class, 'confirmDelete'])->name('users.delete');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('attendance', App\Http\Controllers\Admin\AttendanceController::class);
    Route::resource('exams', App\Http\Controllers\Admin\ExamController::class);
    Route::get('exams/{exam}/publish', [App\Http\Controllers\Admin\ExamController::class, 'publish'])->name('exams.publish');
    Route::get('exams/{exam}/admit-cards', [App\Http\Controllers\Admin\ExamController::class, 'admitCards'])->name('exams.admit-cards');

    // Marks Routes
    Route::get('marks/entry', [App\Http\Controllers\Admin\MarkController::class, 'create'])->name('marks.create');
    Route::get('marks/manage', [App\Http\Controllers\Admin\MarkController::class, 'manage'])->name('marks.manage');
    Route::post('marks/store', [App\Http\Controllers\Admin\MarkController::class, 'store'])->name('marks.store');

    // Report Card Routes
    Route::get('reports', [App\Http\Controllers\Admin\ReportCardController::class, 'index'])->name('reports.index');
    Route::get('reports/print/{studentId}/{examId}', [App\Http\Controllers\Admin\ReportCardController::class, 'print'])->name('reports.print');

    // Grade Management Routes
    Route::get('grades/{grade}/delete', [App\Http\Controllers\Admin\GradeController::class, 'confirmDelete'])->name('grades.delete');
    Route::resource('grades', App\Http\Controllers\Admin\GradeController::class);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/staff/dashboard', function () {
        return view('staff.dashboard');
    })->name('staff.dashboard');
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');
    Route::get('/parent/dashboard', function () {
        return view('parent.dashboard');
    })->name('parent.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
