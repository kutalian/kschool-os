<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffAttendance;
use Illuminate\Http\Request;

class StaffAttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(\App\Services\AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function index(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));

        $attendance = StaffAttendance::where('date', $date)
            ->with('staff')
            ->get();

        return view('admin.staff.attendance.index', compact('attendance', 'date'));
    }

    public function create(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));

        // Fetch all active staff
        $staff = Staff::where('is_active', true)
            ->orderBy('role_type')
            ->orderBy('name')
            ->get();

        // Check for existing attendance for this date
        $existingAttendance = StaffAttendance::where('date', $date)
            ->get()
            ->keyBy('staff_id');

        return view('admin.staff.attendance.create', compact('staff', 'date', 'existingAttendance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'in:Present,Absent,Late,Half Day,Leave',
        ]);

        $this->attendanceService->recordStaffAttendance(
            $request->date,
            $request->attendance,
            $request->input('remarks', [])
        );

        return redirect()->route('staff-attendance.index', ['date' => $request->date])
            ->with('success', 'Staff attendance updated successfully.');
    }
}
