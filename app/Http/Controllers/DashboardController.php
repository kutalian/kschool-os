<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Staff;
use App\Models\ClassRoom;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic stats for the dashboard
        $stats = [
            'students' => Student::count(),
            'teachers' => Staff::where('role_type', 'Teacher')->count(),
            'staff' => Staff::count(),
            'classes' => ClassRoom::count(),
            'users' => User::count(),
        ];

        return view('dashboard', compact('stats'));
    }
}
