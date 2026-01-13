<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassRoom;
use App\Models\Student;

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
        foreach ($myClasses as $class) {
            $totalStudents += Student::where('class_id', $class->id)->count();
        }

        return view('staff.dashboard', compact('myClasses', 'totalStudents'));
    }
}
