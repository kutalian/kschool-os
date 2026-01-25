<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\Notice;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user->staff) {
            return view('staff.dashboard', [
                'myClasses' => collect(),
                'totalStudents' => 0,
                'pendingTasks' => 0, // Placeholder
            ]);
        }

        // Fetch Homeroom Classes
        $myClasses = $user->staff->classes;

        // Count students in these classes
        $totalStudents = 0;
        $pendingTasks = 0;
        foreach ($myClasses as $class) {
            $totalStudents += Student::where('class_id', $class->id)->count();

            // Check if attendance is taken for today
            $attendanceTaken = \App\Models\Attendance::where('date', now()->format('Y-m-d'))
                ->whereHas('student', function ($query) use ($class) {
                    $query->where('class_id', $class->id);
                })
                ->exists();

            if (!$attendanceTaken) {
                $pendingTasks++;
            }
        }

        $notices = Notice::whereIn('audience', ['all', 'staff'])
            ->where('is_active', true)
            ->latest()
            ->take(5)
            ->get();

        return view('staff.dashboard', compact('myClasses', 'totalStudents', 'notices', 'pendingTasks'));
    }
}
