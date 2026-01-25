<?php

namespace App\Http\Controllers\Parent;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $parent = $user->parent;

        if (!$parent) {
            abort(403, 'Parent profile not found.');
        }

        $children = $parent->students;

        return view('parent.attendance.index', compact('children'));
    }

    public function show(Request $request, $studentId)
    {
        $user = Auth::user();
        $parent = $user->parent;

        if (!$parent) {
            abort(403, 'Parent profile not found.');
        }

        $student = Student::where('id', $studentId)->where('parent_id', $parent->id)->firstOrFail();

        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $attendances = Attendance::where('student_id', $student->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        return view('parent.attendance.show', compact('student', 'attendances', 'month', 'year'));
    }
}
