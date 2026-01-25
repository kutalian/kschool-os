<?php

namespace App\Http\Controllers\Principal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Staff;
use App\Models\StudentFee;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalStaff = Staff::count();
        $totalFeesCollected = StudentFee::where('status', 'paid')->sum('amount');

        // Attendance Summary for Today
        $today = now()->format('Y-m-d');

        $studentAttendance = [
            'present' => \App\Models\Attendance::where('date', $today)->where('status', 'present')->count(),
            'absent' => \App\Models\Attendance::where('date', $today)->where('status', 'absent')->count(),
            'late' => \App\Models\Attendance::where('date', $today)->where('status', 'late')->count(),
            'half_day' => \App\Models\Attendance::where('date', $today)->where('status', 'half_day')->count(),
        ];

        $staffAttendance = [
            'present' => \App\Models\StaffAttendance::where('date', $today)->where('status', 'present')->count(),
            'absent' => \App\Models\StaffAttendance::where('date', $today)->where('status', 'absent')->count(),
            'late' => \App\Models\StaffAttendance::where('date', $today)->where('status', 'late')->count(),
        ];

        return view('principal.dashboard', compact('totalStudents', 'totalStaff', 'totalFeesCollected', 'studentAttendance', 'staffAttendance'));
    }
}
