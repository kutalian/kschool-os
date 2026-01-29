<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\LeaveApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaveController extends Controller
{
    public function index()
    {
        $applications = LeaveApplication::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('staff.leave.index', compact('applications'));
    }

    public function create()
    {
        return view('staff.leave.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_type' => 'required|string',
            'from_date' => 'required|date|after_or_equal:today',
            'to_date' => 'required|date|after_or_equal:from_date',
            'reason' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $from = Carbon::parse($request->from_date);
        $to = Carbon::parse($request->to_date);
        $days = $from->diffInDays($to) + 1;

        $data = $request->only(['leave_type', 'from_date', 'to_date', 'reason']);
        $data['user_id'] = Auth::id();
        $data['days'] = $days;
        $data['status'] = 'Pending';

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('leave_attachments', 'public');
        }

        LeaveApplication::create($data);

        return redirect()->route('staff.leave.index')->with('success', 'Leave application submitted successfully.');
    }

    public function show(LeaveApplication $leave)
    {
        if ($leave->user_id !== Auth::id()) {
            abort(403);
        }

        return view('staff.leave.show', compact('leave'));
    }
}
