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
    Route::resource('classes', App\Http\Controllers\Admin\ClassRoomController::class)->parameters([
        'classes' => 'classRoom'
    ]);
    Route::get('classes/{classRoom}/delete', [App\Http\Controllers\Admin\ClassRoomController::class, 'confirmDelete'])->name('classes.delete');
    Route::post('classes/{classRoom}/assign-subjects', [App\Http\Controllers\Admin\ClassRoomController::class, 'assignSubjects'])->name('classes.assign-subjects');
    Route::resource('subjects', App\Http\Controllers\Admin\SubjectController::class);
    Route::get('subjects/{subject}/delete', [App\Http\Controllers\Admin\SubjectController::class, 'confirmDelete'])->name('subjects.delete');

    // Syllabus Routes
    Route::get('syllabus', [App\Http\Controllers\Admin\SyllabusController::class, 'index'])->name('syllabus.index');
    Route::post('syllabus', [App\Http\Controllers\Admin\SyllabusController::class, 'store'])->name('syllabus.store');
    Route::get('syllabus/{syllabus}/delete', [App\Http\Controllers\Admin\SyllabusController::class, 'confirm_delete'])->name('syllabus.delete_confirm');
    Route::delete('syllabus/{syllabus}', [App\Http\Controllers\Admin\SyllabusController::class, 'destroy'])->name('syllabus.destroy');
    Route::get('syllabus/{syllabus}/download', [App\Http\Controllers\Admin\SyllabusController::class, 'download'])->name('syllabus.download');

    // Assignment Routes
    Route::get('assignments', [App\Http\Controllers\Admin\AssignmentController::class, 'index'])->name('assignments.index');
    Route::post('assignments', [App\Http\Controllers\Admin\AssignmentController::class, 'store'])->name('assignments.store');
    Route::get('assignments/{assignment}', [App\Http\Controllers\Admin\AssignmentController::class, 'show'])->name('assignments.show'); // Show route
    Route::get('assignments/{assignment}/delete', [App\Http\Controllers\Admin\AssignmentController::class, 'confirmDelete'])->name('assignments.delete_confirm'); // Confirm delete route
    Route::delete('assignments/{assignment}', [App\Http\Controllers\Admin\AssignmentController::class, 'destroy'])->name('assignments.destroy');
    Route::get('assignments/{assignment}/download', [App\Http\Controllers\Admin\AssignmentController::class, 'download'])->name('assignments.download');
    Route::post('submissions', [App\Http\Controllers\Admin\SubmissionController::class, 'store'])->name('submissions.store'); // Submission route

    // Lesson Plan Routes
    Route::resource('lesson-plans', App\Http\Controllers\Admin\LessonPlanController::class);
    Route::patch('lesson-plans/{lessonPlan}/approve', [App\Http\Controllers\Admin\LessonPlanController::class, 'approve'])->name('lesson-plans.approve');
    Route::patch('lesson-plans/{lessonPlan}/reject', [App\Http\Controllers\Admin\LessonPlanController::class, 'reject'])->name('lesson-plans.reject');
    Route::post('lesson-plans/{id}/restore', [App\Http\Controllers\Admin\LessonPlanController::class, 'restore'])->name('lesson-plans.restore');
    Route::delete('lesson-plans/{id}/force-delete', [App\Http\Controllers\Admin\LessonPlanController::class, 'forceDelete'])->name('lesson-plans.force_delete');

    Route::get('students/{student}/delete', [App\Http\Controllers\Admin\StudentController::class, 'confirmDelete'])->name('students.delete');
    Route::get('students/promotion', [App\Http\Controllers\Admin\StudentPromotionController::class, 'index'])->name('students.promotion');
    Route::post('students/promote', [App\Http\Controllers\Admin\StudentPromotionController::class, 'promote'])->name('students.promote');
    Route::resource('students', App\Http\Controllers\Admin\StudentController::class);
    Route::get('staff/{staff}/delete', [App\Http\Controllers\Admin\StaffController::class, 'confirmDelete'])->name('staff.delete');
    Route::resource('staff', App\Http\Controllers\Admin\StaffController::class);
    Route::resource('staff-attendance', App\Http\Controllers\Admin\StaffAttendanceController::class);
    Route::get('payroll/{payroll}/print', [App\Http\Controllers\Admin\PayrollController::class, 'print'])->name('payroll.print');
    Route::resource('payroll', App\Http\Controllers\Admin\PayrollController::class);

    // Performance Reviews
    Route::get('performance-reviews/{performanceReview}/delete', [App\Http\Controllers\Admin\PerformanceReviewController::class, 'confirmDelete'])->name('performance-reviews.delete');
    Route::resource('performance-reviews', App\Http\Controllers\Admin\PerformanceReviewController::class);
    Route::get('parents/{parent}/delete', [App\Http\Controllers\Admin\ParentController::class, 'confirmDelete'])->name('parents.delete');
    Route::resource('parents', App\Http\Controllers\Admin\ParentController::class);
    Route::get('users/{user}/delete', [App\Http\Controllers\Admin\UserController::class, 'confirmDelete'])->name('users.delete');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    // Library Management Routes
    Route::get('library', [App\Http\Controllers\Admin\LibraryController::class, 'index'])->name('library.index');
    Route::post('library/book/store', [App\Http\Controllers\Admin\LibraryController::class, 'store_book'])->name('library.book.store');
    Route::post('library/category/store', [App\Http\Controllers\Admin\LibraryController::class, 'store_category'])->name('library.category.store');
    Route::post('library/issue', [App\Http\Controllers\Admin\LibraryController::class, 'issue_book'])->name('library.issue');
    Route::get('library/history/all', [App\Http\Controllers\Admin\LibraryController::class, 'all_history'])->name('library.history.all');
    Route::get('library/issue/{book}', [App\Http\Controllers\Admin\LibraryController::class, 'create_issue'])->name('library.issue.create');
    Route::get('library/book/{book}/history', [App\Http\Controllers\Admin\LibraryController::class, 'history'])->name('library.history');
    Route::get('library/book/{book}/edit', [App\Http\Controllers\Admin\LibraryController::class, 'edit'])->name('library.book.edit');
    Route::put('library/book/{book}', [App\Http\Controllers\Admin\LibraryController::class, 'update'])->name('library.book.update');
    Route::get('library/book/{book}/delete', [App\Http\Controllers\Admin\LibraryController::class, 'confirm_delete'])->name('library.book.delete_confirm');
    Route::delete('library/book/{book}', [App\Http\Controllers\Admin\LibraryController::class, 'destroy'])->name('library.book.destroy');
    Route::post('library/return', [App\Http\Controllers\Admin\LibraryController::class, 'return_book'])->name('library.return');
    Route::get('library/users/search', [App\Http\Controllers\Admin\LibraryController::class, 'search_users'])->name('library.users.search'); // For AJAX

    Route::resource('attendance', App\Http\Controllers\Admin\AttendanceController::class);
    Route::get('exams/{exam}/delete', [App\Http\Controllers\Admin\ExamController::class, 'confirmDelete'])->name('exams.delete');
    Route::resource('exams', App\Http\Controllers\Admin\ExamController::class);
    Route::get('exams/{exam}/publish', [App\Http\Controllers\Admin\ExamController::class, 'publish'])->name('exams.publish');
    Route::get('exams/{exam}/admit-cards', [App\Http\Controllers\Admin\ExamController::class, 'admitCards'])->name('exams.admit-cards');

    // Financial Routes
    Route::resource('expense-categories', App\Http\Controllers\Admin\ExpenseCategoryController::class);
    Route::get('expenses/{expense}/delete', [App\Http\Controllers\Admin\ExpenseController::class, 'confirmDelete'])->name('expenses.delete');
    Route::resource('expenses', App\Http\Controllers\Admin\ExpenseController::class);

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

    // Fee Management Routes
    Route::get('fees/assign', [App\Http\Controllers\Admin\FeeController::class, 'assign'])->name('fees.assign');
    Route::post('fees/assign', [App\Http\Controllers\Admin\FeeController::class, 'storeAssignment'])->name('fees.storeAssignment');
    Route::get('fees/collect', [App\Http\Controllers\Admin\FeeController::class, 'collect'])->name('fees.collect');
    Route::post('fees/pay', [App\Http\Controllers\Admin\FeeController::class, 'storePayment'])->name('fees.pay');
    Route::get('fees/receipt/{payment}', [App\Http\Controllers\Admin\FeeController::class, 'receipt'])->name('fees.receipt');
    Route::get('fees/report', [App\Http\Controllers\Admin\FeeController::class, 'report'])->name('fees.report');
    Route::get('fees/{fee}/delete', [App\Http\Controllers\Admin\FeeController::class, 'confirmDelete'])->name('fees.delete');
    Route::resource('fees', App\Http\Controllers\Admin\FeeController::class)->parameters([
        'fees' => 'fee'
    ]);

    // Timetable Routes
    Route::get('timetable/manage', [App\Http\Controllers\Admin\TimetableController::class, 'manage'])->name('timetable.manage');
    Route::post('timetable/store', [App\Http\Controllers\Admin\TimetableController::class, 'store'])->name('timetable.store');
    Route::post('timetable/destroy', [App\Http\Controllers\Admin\TimetableController::class, 'destroy'])->name('timetable.destroy');

    // Dynamic Class Timetable Structure
    Route::post('timetable/day/store', [App\Http\Controllers\Admin\TimetableController::class, 'storeDay'])->name('timetable.day.store');
    Route::post('timetable/day/destroy', [App\Http\Controllers\Admin\TimetableController::class, 'destroyDay'])->name('timetable.day.destroy');
    Route::post('timetable/period/store', [App\Http\Controllers\Admin\TimetableController::class, 'storePeriod'])->name('timetable.period.store');
    Route::post('timetable/period/destroy', [App\Http\Controllers\Admin\TimetableController::class, 'destroyPeriod'])->name('timetable.period.destroy');

    Route::resource('timetable', App\Http\Controllers\Admin\TimetableController::class)->only(['index']);

    // Exam Timetable Routes
    Route::get('exam-schedule/manage', [App\Http\Controllers\Admin\ExamScheduleController::class, 'manage'])->name('exam-schedule.manage');
    Route::post('exam-schedule/store', [App\Http\Controllers\Admin\ExamScheduleController::class, 'store'])->name('exam-schedule.store');
    Route::post('exam-schedule/destroy', [App\Http\Controllers\Admin\ExamScheduleController::class, 'destroy'])->name('exam-schedule.destroy');

    // Structure Routes
    Route::post('exam-schedule/date/store', [App\Http\Controllers\Admin\ExamScheduleController::class, 'storeDate'])->name('exam-schedule.date.store');
    Route::post('exam-schedule/date/destroy', [App\Http\Controllers\Admin\ExamScheduleController::class, 'destroyDate'])->name('exam-schedule.date.destroy');
    Route::post('exam-schedule/period/store', [App\Http\Controllers\Admin\ExamScheduleController::class, 'storePeriod'])->name('exam-schedule.period.store');
    Route::post('exam-schedule/period/destroy', [App\Http\Controllers\Admin\ExamScheduleController::class, 'destroyPeriod'])->name('exam-schedule.period.destroy');

    // Transport Routes
    Route::get('transport', [App\Http\Controllers\Admin\TransportController::class, 'index'])->name('transport.index');

    // Vehicles
    Route::post('transport/vehicles', [App\Http\Controllers\Admin\TransportController::class, 'storeVehicle'])->name('transport.vehicles.store');
    Route::get('transport/vehicles/{vehicle}/edit', [App\Http\Controllers\Admin\TransportController::class, 'editVehicle'])->name('transport.vehicles.edit');
    Route::put('transport/vehicles/{vehicle}', [App\Http\Controllers\Admin\TransportController::class, 'updateVehicle'])->name('transport.vehicles.update');
    Route::get('transport/vehicles/{vehicle}/delete', [App\Http\Controllers\Admin\TransportController::class, 'confirmDeleteVehicle'])->name('transport.vehicles.delete');
    Route::delete('transport/vehicles/{vehicle}', [App\Http\Controllers\Admin\TransportController::class, 'destroyVehicle'])->name('transport.vehicles.destroy');

    // Routes
    Route::post('transport/routes', [App\Http\Controllers\Admin\TransportController::class, 'storeRoute'])->name('transport.routes.store');
    Route::get('transport/routes/{transportRoute}/edit', [App\Http\Controllers\Admin\TransportController::class, 'editRoute'])->name('transport.routes.edit');
    Route::put('transport/routes/{transportRoute}', [App\Http\Controllers\Admin\TransportController::class, 'updateRoute'])->name('transport.routes.update');
    Route::get('transport/routes/{transportRoute}/delete', [App\Http\Controllers\Admin\TransportController::class, 'confirmDeleteRoute'])->name('transport.routes.delete');
    Route::delete('transport/routes/{transportRoute}', [App\Http\Controllers\Admin\TransportController::class, 'destroyRoute'])->name('transport.routes.destroy');

    Route::resource('exam-schedule', App\Http\Controllers\Admin\ExamScheduleController::class)->only(['index']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/staff/dashboard', [App\Http\Controllers\Staff\DashboardController::class, 'index'])->name('staff.dashboard');
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


