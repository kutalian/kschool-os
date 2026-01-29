<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\Notice;
use App\Models\Assignment;
use App\Models\LessonPlan;
use App\Models\LeaveApplication;
use App\Models\Message;
use App\Models\BookIssue;
use App\Models\Timetable;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $staff = $user->staff;

        if (!$staff) {
            return view('staff.dashboard', [
                'myClasses' => collect(),
                'totalStudents' => 0,
                'pendingTasks' => 0,
                'totalAssignments' => 0,
                'activeLeaveRequests' => 0,
                'totalLessonPlans' => 0,
                'notices' => collect(),
                'unreadMessages' => 0,
                'pendingLibraryRequests' => 0,
                'todaySchedule' => collect(),
                'greeting' => 'Welcome',
            ]);
        }

        // Fetch Homeroom Classes
        $myClasses = $staff->classes;

        // Count students and pending attendance
        $totalStudents = 0;
        $pendingTasks = 0;
        foreach ($myClasses as $class) {
            $totalStudents += Student::where('class_id', $class->id)->count();

            $attendanceTaken = \App\Models\Attendance::where('date', now()->format('Y-m-d'))
                ->whereHas('student', function ($query) use ($class) {
                    $query->where('class_id', $class->id);
                })
                ->exists();

            if (!$attendanceTaken) {
                $pendingTasks++;
            }
        }

        // Stats
        $totalAssignments = Assignment::where('created_by', $user->id)->count();
        $totalLessonPlans = LessonPlan::where('teacher_id', $user->id)->count();
        $activeLeaveRequests = LeaveApplication::where('user_id', $user->id)
            ->where('status', 'Pending')
            ->count();

        // New Data for Redesign
        $unreadMessages = Message::where('receiver_id', $user->id)->where('is_read', false)->count();
        $pendingLibraryRequests = BookIssue::where('user_id', $user->id)->where('status', 'requested')->count();

        $today = now()->format('l'); // e.g., 'Monday'
        $todaySchedule = Timetable::where('teacher_id', $user->id)
            ->where('day', $today)
            ->with(['classRoom', 'subject', 'period'])
            ->get()
            ->sortBy(function ($item) {
                return $item->period->start_time;
            });

        $notices = Notice::whereIn('audience', ['all', 'staff'])
            ->where('is_active', true)
            ->latest()
            ->take(5)
            ->get();

        // Personal Greeting
        $hour = now()->hour;
        if ($hour < 12) {
            $greeting = 'Good Morning';
        } elseif ($hour < 17) {
            $greeting = 'Good Afternoon';
        } else {
            $greeting = 'Good Evening';
        }

        return view('staff.dashboard', compact(
            'myClasses',
            'totalStudents',
            'notices',
            'pendingTasks',
            'totalAssignments',
            'totalLessonPlans',
            'activeLeaveRequests',
            'unreadMessages',
            'pendingLibraryRequests',
            'todaySchedule',
            'greeting'
        ));
    }
}
