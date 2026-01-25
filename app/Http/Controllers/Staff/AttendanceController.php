<?php

namespace App\Http\Controllers\Staff;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassRoom;
use App\Models\Timetable;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $staff = $user->staff;

        if (!$staff)
            return redirect()->route('dashboard');

        // Reuse class fetching logic from MyClassController
        $homeroomClasses = ClassRoom::where('class_teacher_id', $staff->id)->get();
        $scheduledClasses = Timetable::where('teacher_id', $user->id)
            ->with('classRoom')
            ->get()
            ->pluck('classRoom')
            ->unique('id');

        $classes = $homeroomClasses->merge($scheduledClasses)->unique('id');

        return view('staff.attendance.index', compact('classes'));
    }

    public function create(Request $request)
    {
        $classId = $request->get('class_id');
        $date = $request->get('date', now()->format('Y-m-d'));

        $classRoom = ClassRoom::with('students')->findOrFail($classId);

        // Check if attendance already taken
        $existingAttendance = Attendance::where('class_id', $classId)
            ->where('date', $date)
            ->get()
            ->keyBy('student_id');

        return view('staff.attendance.create', compact('classRoom', 'date', 'existingAttendance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,late,excused'
        ]);

        $classId = $request->class_id;
        $date = $request->date;

        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'class_id' => $classId,
                    'date' => $date
                ],
                [
                    'status' => $status,
                    'recorded_by' => Auth::id()
                ]
            );
        }

        return redirect()->route('staff.attendance.index')->with('success', 'Attendance updated successfully.');
    }

    public function report(Request $request)
    {
        $classId = $request->get('class_id');
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $classRoom = ClassRoom::findOrFail($classId);

        $attendances = Attendance::where('class_id', $classId)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get()
            ->groupBy('student_id');

        $students = Student::where('class_id', $classId)->get();

        return view('staff.attendance.report', compact('classRoom', 'students', 'attendances', 'month', 'year'));
    }
}
