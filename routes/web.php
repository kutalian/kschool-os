<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/p/{slug}', [App\Http\Controllers\HomeController::class, 'page'])->name('theme.page');

Route::get('/dashboard', function () {
    $user = auth()->user();
    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'staff' => redirect()->route('staff.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        'parent' => redirect()->route('parent.dashboard'),
        'receptionist' => redirect()->route('receptionist.dashboard'),
        'driver' => redirect()->route('driver.dashboard'),
        'principal' => redirect()->route('principal.dashboard'),
        default => view('dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// Role-based Dashboards
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // Academic Routes
    Route::resource('academic-sessions', App\Http\Controllers\Admin\AcademicSessionController::class);
    Route::resource('terms', App\Http\Controllers\Admin\TermController::class);
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

    // Transport Allocations
    Route::get('transport/allocations', [App\Http\Controllers\Admin\TransportAllocationController::class, 'index'])->name('transport.allocations.index');
    Route::get('transport/allocations/create', [App\Http\Controllers\Admin\TransportAllocationController::class, 'create'])->name('transport.allocations.create');
    Route::post('transport/allocations', [App\Http\Controllers\Admin\TransportAllocationController::class, 'store'])->name('transport.allocations.store');
    Route::delete('transport/allocations/{allocation}', [App\Http\Controllers\Admin\TransportAllocationController::class, 'destroy'])->name('transport.allocations.destroy');
    Route::get('transport/allocations/search-students', [App\Http\Controllers\Admin\TransportAllocationController::class, 'searchStudents'])->name('transport.allocations.search');

    // Hostel Management Routes
    Route::resource('hostel', App\Http\Controllers\Admin\HostelController::class);

    // Rooms
    Route::post('hostel/rooms', [App\Http\Controllers\Admin\RoomController::class, 'store'])->name('hostel.rooms.store');
    Route::get('hostel/rooms/{room}/edit', [App\Http\Controllers\Admin\RoomController::class, 'edit'])->name('hostel.rooms.edit'); // For modal or separate page
    Route::put('hostel/rooms/{room}', [App\Http\Controllers\Admin\RoomController::class, 'update'])->name('hostel.rooms.update');
    Route::delete('hostel/rooms/{room}', [App\Http\Controllers\Admin\RoomController::class, 'destroy'])->name('hostel.rooms.destroy');

    // Allocations
    Route::post('hostel/allocate', [App\Http\Controllers\Admin\AllocationController::class, 'store'])->name('hostel.allocate.store');
    Route::post('hostel/vacate/{allocation}', [App\Http\Controllers\Admin\AllocationController::class, 'vacate'])->name('hostel.allocate.vacate');

    // Front Office Routes
    Route::resource('visitors', App\Http\Controllers\Admin\FrontOffice\VisitorController::class);
    Route::resource('admission-enquiries', App\Http\Controllers\Admin\FrontOffice\AdmissionEnquiryController::class);
    Route::resource('phone-call-logs', App\Http\Controllers\Admin\FrontOffice\PhoneCallLogController::class);
    Route::resource('postal-records', App\Http\Controllers\Admin\FrontOffice\PostalRecordController::class);

    Route::resource('exam-schedule', App\Http\Controllers\Admin\ExamScheduleController::class)->only(['index']);

    // Inventory Routes
    Route::get('inventory/movement/{item}', [App\Http\Controllers\Admin\InventoryController::class, 'addMovement'])->name('inventory.movement');
    Route::post('inventory/movement/{item}', [App\Http\Controllers\Admin\InventoryController::class, 'storeMovement'])->name('inventory.movement.store');
    Route::resource('inventory', App\Http\Controllers\Admin\InventoryController::class)->parameters([
        'inventory' => 'item'
    ]);

    // Student Services Routes
    Route::group(['prefix' => 'student-services', 'as' => 'student-services.'], function () {
        // This group prefix is optional but creating a namespace/folder structure helps
    });

    Route::get('health-records/{health_record}/delete', [App\Http\Controllers\Admin\StudentServices\HealthRecordController::class, 'confirmDelete'])->name('health-records.delete');
    Route::resource('health-records', App\Http\Controllers\Admin\StudentServices\HealthRecordController::class);

    Route::get('vaccinations/{vaccination}/delete', [App\Http\Controllers\Admin\StudentServices\VaccinationController::class, 'confirmDelete'])->name('vaccinations.delete');
    Route::resource('vaccinations', App\Http\Controllers\Admin\StudentServices\VaccinationController::class);

    Route::get('disciplinary-records/{disciplinary_record}/delete', [App\Http\Controllers\Admin\StudentServices\DisciplinaryController::class, 'confirmDelete'])->name('disciplinary-records.delete');
    Route::resource('disciplinary-records', App\Http\Controllers\Admin\StudentServices\DisciplinaryController::class);

    Route::get('behavior-points/{behavior_point}/delete', [App\Http\Controllers\Admin\StudentServices\BehaviorController::class, 'confirmDelete'])->name('behavior-points.delete');
    Route::resource('behavior-points', App\Http\Controllers\Admin\StudentServices\BehaviorController::class);

    // Communication Routes
    Route::get('communication/notification-manager', [App\Http\Controllers\Admin\Communication\NotificationManagerController::class, 'index'])->name('notifications.manager.index');
    Route::get('communication/notification-manager/create', [App\Http\Controllers\Admin\Communication\NotificationManagerController::class, 'create'])->name('notifications.manager.create');
    Route::post('communication/notification-manager/send', [App\Http\Controllers\Admin\Communication\NotificationManagerController::class, 'store'])->name('notifications.manager.store');
    Route::post('communication/notification-manager/process', [App\Http\Controllers\Admin\Communication\NotificationManagerController::class, 'processQueue'])->name('notifications.manager.process');

    Route::resource('messages', App\Http\Controllers\Admin\Communication\MessageController::class);
    Route::resource('events', App\Http\Controllers\Admin\Communication\EventController::class);
    Route::resource('notices', App\Http\Controllers\Admin\Communication\NoticeController::class);
    Route::resource('announcements', App\Http\Controllers\Admin\Communication\AnnouncementController::class);
    Route::resource('complaints', App\Http\Controllers\Admin\Communication\ComplaintController::class);
    Route::resource('parent-teacher-meetings', App\Http\Controllers\Admin\Communication\ParentTeacherMeetingController::class);

    // Certificate Routes
    Route::get('certificates/{certificate}/delete', [App\Http\Controllers\Admin\CertificateController::class, 'confirmDelete'])->name('certificates.delete');
    Route::resource('certificates', App\Http\Controllers\Admin\CertificateController::class)->parameters([
        'certificates' => 'certificate'
    ]);

    // Documents & Media Routes
    Route::resource('documents', App\Http\Controllers\Admin\DocumentController::class);
    Route::resource('gallery', App\Http\Controllers\Admin\GalleryController::class);
    // System & Security Routes
    Route::get('system/activity', [App\Http\Controllers\Admin\SystemLogController::class, 'activity'])->name('system.activity');
    Route::get('system/login-history', [App\Http\Controllers\Admin\SystemLogController::class, 'loginHistory'])->name('system.login-history');
    Route::get('system/backups', [App\Http\Controllers\Admin\SystemLogController::class, 'backups'])->name('system.backups');

    // Unified Website Manager
    Route::prefix('website')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\WebsiteController::class, 'index'])->name('admin.website.index');

        // Site Identity (Settings)
        Route::get('settings', [App\Http\Controllers\Admin\SettingController::class, 'edit'])->name('settings.edit');
        Route::post('settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

        // User Deletion Requests
        Route::get('users/deletions', [App\Http\Controllers\Admin\UserDeletionController::class, 'index'])->name('admin.users.deletions');
        Route::post('users/{user}/deletions/approve', [App\Http\Controllers\Admin\UserDeletionController::class, 'approve'])->name('admin.users.deletions.approve');
        Route::post('users/{user}/deletions/reject', [App\Http\Controllers\Admin\UserDeletionController::class, 'reject'])->name('admin.users.deletions.reject');

        // Themes & Customization
        Route::get('themes', [App\Http\Controllers\Admin\CmsController::class, 'themes'])->name('cms.themes');
        Route::post('themes/upload', [App\Http\Controllers\Admin\CmsController::class, 'uploadTheme'])->name('cms.themes.upload');
        Route::post('themes/{theme}/activate', [App\Http\Controllers\Admin\CmsController::class, 'activateTheme'])->name('cms.themes.activate');
        Route::delete('themes/{theme}', [App\Http\Controllers\Admin\CmsController::class, 'destroy'])->name('cms.themes.destroy');
        Route::get('customize', [App\Http\Controllers\Admin\CmsController::class, 'customize'])->name('cms.customize');
        Route::post('customize/save', [App\Http\Controllers\Admin\CmsController::class, 'updateCustomizer'])->name('cms.customize.save');

        // Content
        Route::get('content', [App\Http\Controllers\Admin\CmsController::class, 'content'])->name('cms.content');
        Route::put('content/{content}', [App\Http\Controllers\Admin\CmsController::class, 'updateContent'])->name('cms.content.update');

        // Pages
        Route::resource('pages', App\Http\Controllers\Admin\CmsPageController::class)->names([
            'index' => 'admin.cms.pages.index',
            'create' => 'admin.cms.pages.create',
            'store' => 'admin.cms.pages.store',
            'edit' => 'admin.cms.pages.edit',
            'update' => 'admin.cms.pages.update',
            'destroy' => 'admin.cms.pages.destroy',
        ]);
    });

    Route::post('gallery/{gallery}/upload', [App\Http\Controllers\Admin\GalleryController::class, 'uploadPhoto'])->name('gallery.upload');
    Route::delete('gallery/photo/{photo}', [App\Http\Controllers\Admin\GalleryController::class, 'destroyPhoto'])->name('gallery.photo.destroy');

    // Budget Routes
    Route::resource('budgets', App\Http\Controllers\Admin\BudgetController::class);

    // Alumni Routes
    Route::resource('alumni', App\Http\Controllers\Admin\AlumniController::class);
    Route::post('alumni/{alumni}/donations', [App\Http\Controllers\Admin\AlumniController::class, 'storeDonation'])->name('alumni.donations.store');

});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/staff/dashboard', [App\Http\Controllers\Staff\DashboardController::class, 'index'])->name('staff.dashboard');

    // Notification Routes
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
    Route::get('/notifications/{notification}/mark-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markRead');

    // Student Routes
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/subjects', [App\Http\Controllers\Student\SubjectController::class, 'index'])->name('subjects.index');
        Route::get('/timetable', [App\Http\Controllers\Student\TimetableController::class, 'index'])->name('timetable.index');
        Route::get('/exams', [App\Http\Controllers\Student\ExamController::class, 'index'])->name('exams.index');
        Route::get('/attendance', [App\Http\Controllers\Student\AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/fees', [App\Http\Controllers\Student\FeeController::class, 'index'])->name('fees.index');
    });

    Route::middleware('role:librarian')->prefix('librarian')->name('librarian.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Librarian\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('books', App\Http\Controllers\Librarian\BookController::class);
        Route::get('/issue', [App\Http\Controllers\Librarian\IssueController::class, 'create'])->name('issue.create');
        Route::post('/issue', [App\Http\Controllers\Librarian\IssueController::class, 'store'])->name('issue.store');
        Route::post('/return/{id}', [App\Http\Controllers\Librarian\IssueController::class, 'returnBook'])->name('issue.return');

        // Request Management
        Route::get('/requests', [App\Http\Controllers\Librarian\IssueController::class, 'index'])->name('requests.index');
        Route::post('/requests/{id}/approve', [App\Http\Controllers\Librarian\IssueController::class, 'approve'])->name('requests.approve');
        Route::delete('/requests/{id}/cancel', [App\Http\Controllers\Librarian\IssueController::class, 'cancel'])->name('requests.cancel');
    });

    Route::middleware('role:accountant')->prefix('accountant')->name('accountant.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Accountant\DashboardController::class, 'index'])->name('dashboard');

        // Fee Management
        Route::get('/fees/assign', [App\Http\Controllers\Accountant\FeeController::class, 'assign'])->name('fees.assign');
        Route::post('/fees/assign', [App\Http\Controllers\Accountant\FeeController::class, 'storeAssign'])->name('fees.store_assign');
        Route::resource('fees', App\Http\Controllers\Accountant\FeeController::class);

        Route::resource('payments', App\Http\Controllers\Accountant\PaymentController::class);
    });

    Route::middleware('role:parent')->prefix('parent')->name('parent.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Parent\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/my-children', [App\Http\Controllers\Parent\ChildController::class, 'index'])->name('children.index');
        Route::get('/attendance', [App\Http\Controllers\Parent\AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/{student}', [App\Http\Controllers\Parent\AttendanceController::class, 'show'])->name('attendance.show');
        Route::get('/progress/{student}', [App\Http\Controllers\Parent\ProgressController::class, 'show'])->name('progress.show');
        Route::get('/fees', [App\Http\Controllers\Parent\FeeController::class, 'index'])->name('fees.index');
        Route::get('/fees/{student}', [App\Http\Controllers\Parent\FeeController::class, 'show'])->name('fees.show');
    });

    // Staff Routes
    Route::middleware('role:staff')->prefix('staff')->name('staff.')->group(function () {
        Route::get('/classes', [App\Http\Controllers\Staff\MyClassController::class, 'index'])->name('classes.index');
        Route::get('/classes/{class}', [App\Http\Controllers\Staff\MyClassController::class, 'show'])->name('classes.show');
        Route::get('/classes/{class}/export', [App\Http\Controllers\Staff\MyClassController::class, 'export'])->name('classes.export');
        Route::get('/timetable', [App\Http\Controllers\Staff\TimetableController::class, 'index'])->name('timetable.index');

        // Attendance Routes
        Route::get('/attendance', [App\Http\Controllers\Staff\AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/create', [App\Http\Controllers\Staff\AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('/attendance', [App\Http\Controllers\Staff\AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('/attendance/report', [App\Http\Controllers\Staff\AttendanceController::class, 'report'])->name('attendance.report');

        // Mark Routes
        Route::get('/marks', [App\Http\Controllers\Staff\MarkController::class, 'index'])->name('marks.index');
        Route::get('/marks/entry', [App\Http\Controllers\Staff\MarkController::class, 'create'])->name('marks.create');
        Route::post('/marks', [App\Http\Controllers\Staff\MarkController::class, 'store'])->name('marks.store');

        // Assignment Routes
        Route::resource('assignments', App\Http\Controllers\Staff\AssignmentController::class);
        Route::get('assignments/{assignment}/submissions', [App\Http\Controllers\Staff\AssignmentController::class, 'submissions'])->name('assignments.submissions');
        Route::post('submissions/{submission}/grade', [App\Http\Controllers\Staff\AssignmentController::class, 'grade'])->name('submissions.grade');

        // Lesson Plan Routes
        Route::resource('lesson-plans', App\Http\Controllers\Staff\LessonPlanController::class);

        // Disciplinary Routes
        Route::resource('disciplinary', App\Http\Controllers\Staff\DisciplinaryController::class)->only(['index', 'create', 'store', 'show']);

        // Exam Question Routes
        Route::resource('exam-questions', App\Http\Controllers\Staff\ExamQuestionController::class);

        // Message Routes
        Route::get('messages/sent', [App\Http\Controllers\Staff\MessageController::class, 'sent'])->name('messages.sent');
        Route::get('messages/{message}/delete', [App\Http\Controllers\Staff\MessageController::class, 'confirmDelete'])->name('messages.delete');
        Route::resource('messages', App\Http\Controllers\Staff\MessageController::class);

        // Notice Routes
        Route::get('notices', [App\Http\Controllers\Admin\Communication\NoticeController::class, 'index'])->name('notices.index');

        // Leave Routes
        Route::resource('leave', App\Http\Controllers\Staff\LeaveController::class)->only(['index', 'create', 'store', 'show']);

        // Payroll Routes
        Route::get('/payroll', [App\Http\Controllers\Staff\PayrollController::class, 'index'])->name('payroll.index');
        Route::get('/payroll/{payroll}', [App\Http\Controllers\Staff\PayrollController::class, 'show'])->name('payroll.show');

        // Library Routes
        Route::get('/library', [App\Http\Controllers\Staff\LibraryController::class, 'index'])->name('library.index');
        Route::get('/library/available', [App\Http\Controllers\Staff\LibraryController::class, 'available'])->name('library.available');
        Route::post('/library/request/{book}', [App\Http\Controllers\Staff\LibraryController::class, 'requestBook'])->name('library.request');
    });

    // Receptionist Routes
    Route::middleware('role:receptionist')->prefix('receptionist')->name('receptionist.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Receptionist\DashboardController::class, 'index'])->name('dashboard');
        // Add other Receptionist routes here (e.g., Visitors, Enquiries)
    });

    // Driver Routes
    Route::middleware('role:driver')->prefix('driver')->name('driver.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Driver\DashboardController::class, 'index'])->name('dashboard');
        // Add other Driver routes here (e.g., Routes view)
    });

    // Principal Routes
    Route::middleware('role:principal')->prefix('principal')->name('principal.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Principal\DashboardController::class, 'index'])->name('dashboard');
        // Principal usually has access to everything, often shares Admin routes or has read-only views
    });

    // Shared Communication Routes (Forum)
    Route::middleware('role:admin,staff')->group(function () {
        Route::get('forum/{forum}/delete', [App\Http\Controllers\Admin\Communication\ForumController::class, 'confirmDelete'])->name('forum.delete');
        Route::resource('forum', App\Http\Controllers\Admin\Communication\ForumController::class);
        Route::get('forum/comment/{comment}/delete', [App\Http\Controllers\Admin\Communication\ForumController::class, 'confirmDeleteComment'])->name('forum.comments.delete');
        Route::post('forum/{post}/comment', [App\Http\Controllers\Admin\Communication\ForumController::class, 'storeComment'])->name('forum.comments.store');
        Route::delete('forum/comment/{comment}', [App\Http\Controllers\Admin\Communication\ForumController::class, 'destroyComment'])->name('forum.comments.destroy');
        Route::post('forum/{post}/like', [App\Http\Controllers\Admin\Communication\ForumController::class, 'toggleLike'])->name('forum.like');
        Route::post('forum/poll/{poll}/vote', [App\Http\Controllers\Admin\Communication\ForumController::class, 'vote'])->name('forum.poll.vote');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


