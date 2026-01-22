<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\TransportRoute;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Services\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index()
    {
        // Eager load transportRoute
        $students = Student::with(['class_room', 'parent', 'user', 'transportRoute'])->latest()->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $classes = ClassRoom::where('is_active', true)->get();
        $parents = StudentParent::select('id', 'name', 'phone', 'email')->get();
        $transportRoutes = TransportRoute::all();
        return view('admin.students.create', compact('classes', 'parents', 'transportRoutes'));
    }

    public function store(StoreStudentRequest $request)
    {
        try {
            $username = $this->studentService->createStudent($request->validated());
            return redirect()->route('students.index')->with('success', "Student admitted successfully. Login ID: $username");
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Admission failed: ' . $e->getMessage());
        }
    }

    public function edit(Student $student)
    {
        $classes = ClassRoom::all();
        $parents = StudentParent::select('id', 'name', 'phone', 'email')->get();
        $transportRoutes = TransportRoute::all();
        return view('admin.students.edit', compact('student', 'classes', 'parents', 'transportRoutes'));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        try {
            $this->studentService->updateStudent($student, $request->validated());
            return redirect()->route('students.index')->with('success', 'Student updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    public function show(Student $student)
    {
        $student->load(['class_room', 'parent', 'user', 'attendance', 'marks.exam', 'marks.subject', 'fees.payments', 'fees.feeType']);

        $totalDays = $student->attendance->count();
        $presentDays = $student->attendance->where('status', 'Present')->count();
        $attendancePercentage = $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 1) : 0;

        $examResults = $student->marks->groupBy(function ($mark) {
            return $mark->exam->name;
        });

        return view('admin.students.show', compact('student', 'totalDays', 'presentDays', 'attendancePercentage', 'examResults'));
    }

    public function confirmDelete(Student $student)
    {
        $attendanceCount = \App\Models\Attendance::where('student_id', $student->id)->count();
        return view('admin.students.delete', compact('student', 'attendanceCount'));
    }

    public function destroy(Student $student)
    {
        try {
            $this->studentService->deleteStudent($student);
            return redirect()->route('students.index')->with('success', 'Student and all related records deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('students.index')->with('error', 'Failed to delete student: ' . $e->getMessage());
        }
    }
}
