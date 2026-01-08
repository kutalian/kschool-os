<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\Staff;
use App\Models\StudentParent;
use App\Models\ClassRoom;
use App\Models\Attendance;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'students' => Student::count(),
            'staff' => Staff::count(),
            'parents' => StudentParent::count(),
            'classes' => ClassRoom::count(),
        ];

        // Fetch today's attendance summary
        $today = now()->format('Y-m-d');
        $attendance = Attendance::where('date', $today)->get();
        $totalPresent = $attendance->where('status', 'Present')->count();
        $totalAbsent = $attendance->where('status', 'Absent')->count();
        $attendanceStats = [
            'total' => $attendance->count(),
            'present' => $totalPresent,
            'absent' => $totalAbsent,
            'percentage' => $attendance->count() > 0 ? round(($totalPresent / $attendance->count()) * 100, 1) : 0,
        ];

        // Fetch recent students (as activity)
        $recentStudents = Student::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'attendanceStats', 'recentStudents'));
    }
}
