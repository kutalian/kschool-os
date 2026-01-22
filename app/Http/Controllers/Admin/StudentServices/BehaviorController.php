<?php

namespace App\Http\Controllers\Admin\StudentServices;

use App\Http\Controllers\Controller;
use App\Models\BehaviorPoint;
use App\Models\Student;
use Illuminate\Http\Request;

class BehaviorController extends Controller
{
    public function index()
    {
        $points = BehaviorPoint::with('student', 'awarder')->latest()->paginate(10);
        return view('admin.student-services.behavior.index', compact('points'));
    }

    public function create()
    {
        $students = Student::select('id', 'name', 'admission_no')->get();
        return view('admin.student-services.behavior.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'points' => 'required|integer',
            'reason' => 'required|string',
            'type' => 'required|in:Positive,Negative',
            'category' => 'required|in:Academic,Behavior,Attendance,Participation,Other',
            'awarded_date' => 'required|date',
        ]);

        $validated['awarded_by'] = auth()->id();

        BehaviorPoint::create($validated);

        return redirect()->route('behavior-points.index')->with('success', 'Behavior points recorded successfully.');
    }

    public function edit(BehaviorPoint $behaviorPoint)
    {
        $students = Student::select('id', 'name', 'admission_no')->get();
        return view('admin.student-services.behavior.edit', compact('behaviorPoint', 'students'));
    }

    public function confirmDelete(BehaviorPoint $behaviorPoint)
    {
        return view('admin.student-services.behavior.delete', compact('behaviorPoint'));
    }

    public function update(Request $request, BehaviorPoint $behaviorPoint)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'points' => 'required|integer',
            'reason' => 'required|string',
            'type' => 'required|in:Positive,Negative',
            'category' => 'required|in:Academic,Behavior,Attendance,Participation,Other',
            'awarded_date' => 'required|date',
        ]);

        $behaviorPoint->update($validated);

        return redirect()->route('behavior-points.index')->with('success', 'Behavior points updated successfully.');
    }

    public function destroy(BehaviorPoint $behaviorPoint)
    {
        $behaviorPoint->delete();
        return redirect()->route('behavior-points.index')->with('success', 'Behavior points deleted successfully.');
    }
}
