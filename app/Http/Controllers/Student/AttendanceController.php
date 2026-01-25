<?php

namespace App\Http\Controllers\Student;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            abort(403, 'Student profile not found.');
        }

        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $attendances = Attendance::where('student_id', $student->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        return view('student.attendance.index', compact('student', 'attendances', 'month', 'year'));
    }
}
