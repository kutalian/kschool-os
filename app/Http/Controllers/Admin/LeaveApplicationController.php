<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LeaveApplicationController extends Controller
{
    public function index()
    {
        $applications = \App\Models\LeaveApplication::with('user')->latest()->paginate(10);
        return view('admin.leaves.index', compact('applications'));
    }

    public function create()
    {
        return view('admin.leaves.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'leave_type' => 'required|in:Sick,Casual,Medical,Emergency,Other',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'reason' => 'required|string',
        ]);

        $days = \Carbon\Carbon::parse($validated['from_date'])->diffInDays(\Carbon\Carbon::parse($validated['to_date'])) + 1;

        \App\Models\LeaveApplication::create([
            'user_id' => auth()->id(),
            'leave_type' => $validated['leave_type'],
            'from_date' => $validated['from_date'],
            'to_date' => $validated['to_date'],
            'days' => $days,
            'reason' => $validated['reason'],
            'status' => 'Pending',
        ]);

        return redirect()->route('admin.leaves.index')->with('success', 'Leave application submitted.');
    }

    public function updateStatus(\Illuminate\Http\Request $request, \App\Models\LeaveApplication $leaf)
    {
        $validated = $request->validate([
            'status' => 'required|in:Approved,Rejected',
            'approval_remarks' => 'nullable|string',
        ]);

        $leaf->update([
            'status' => $validated['status'],
            'approval_remarks' => $validated['approval_remarks'] ?? null,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.leaves.index')->with('success', 'Leave status updated.');
    }
}
