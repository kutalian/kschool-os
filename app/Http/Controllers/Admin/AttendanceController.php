<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        // For now, list recent attendance records
        $attendance = Attendance::with('student.class_room')->latest()->paginate(20);
        return view('admin.attendance.index', compact('attendance'));
    }

    public function create(Request $request)
    {
        $classes = ClassRoom::where('is_active', true)->get();
        $students = [];
        $selectedClass = null;
        $date = $request->input('date', date('Y-m-d'));

        if ($request->has('class_id')) {
            $selectedClass = ClassRoom::find($request->class_id);
            if ($selectedClass) {
                $students = Student::where('class_id', $selectedClass->id)
                    ->orderBy('name')
                    ->get();
            }
        }

        return view('admin.attendance.create', compact('classes', 'students', 'selectedClass', 'date'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'in:Present,Absent,Late,Excused',
            'remarks' => 'nullable|array',
            'remarks.*' => 'nullable|string|max:255',
        ]);

        $date = $request->date;
        $attendanceData = $request->attendance;
        $remarksData = $request->input('remarks', []);

        foreach ($attendanceData as $studentId => $status) {
            $remark = $remarksData[$studentId] ?? null;
            Attendance::updateOrCreate(
                ['student_id' => $studentId, 'date' => $date],
                ['status' => $status, 'remarks' => $remark]
            );
        }

        return redirect()->route('attendance.index')->with('success', 'Attendance recorded successfully.');
    }
}
