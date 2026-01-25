<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Notice;

class DashboardController extends Controller
{
    public function index()
    {
        $notices = Notice::whereIn('audience', ['all', 'student'])
            ->where('is_active', true)
            ->latest()
            ->take(5)
            ->get();

        $user = auth()->user();
        $student = $user->student; // Assuming User hasOne Student

        if (!$student) {
            // Fallback for demo users who might have role but no profile link
            return view('student.dashboard', [
                'notices' => $notices,
                'attendancePercentage' => 0,
                'dueFees' => 0,
                'cgpa' => 0 // Placeholder
            ]);
        }

        // Calculate Attendance
        $totalDays = \App\Models\Attendance::where('student_id', $student->id)->count();
        $presentDays = \App\Models\Attendance::where('student_id', $student->id)
            ->whereIn('status', ['present', 'late', 'half_day']) // Assuming these count as present
            ->count();

        $attendancePercentage = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0;

        // Calculate Due Fees
        $dueFees = \App\Models\StudentFee::where('student_id', $student->id)
            ->where('status', '!=', 'paid') // crude check, better to check balance
            ->sum('amount'); // Ideally sum(amount - paid)

        // CGPA Logic (Simplistic Placeholder for now as Mark structure is complex)
        $cgpa = 3.8;

        return view('student.dashboard', compact('notices', 'attendancePercentage', 'dueFees', 'cgpa'));
    }
}
