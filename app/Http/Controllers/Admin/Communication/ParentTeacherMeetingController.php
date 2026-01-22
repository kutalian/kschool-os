<?php

namespace App\Http\Controllers\Admin\Communication;

use App\Http\Controllers\Controller;
use App\Models\ParentTeacherMeeting;
use Illuminate\Http\Request;

class ParentTeacherMeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meetings = ParentTeacherMeeting::latest()->paginate(10);
        return view('admin.communication.ptm.index', compact('meetings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = \App\Models\Student::with('parent')->get();
        $teachers = \App\Models\Staff::all();
        $parents = \App\Models\StudentParent::all();

        return view('admin.communication.ptm.create', compact('students', 'teachers', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'parent_id' => 'required|exists:parents,id',
            'teacher_id' => 'required|exists:staff,id',
            'meeting_date' => 'required|date|after:today',
            'duration_minutes' => 'required|integer|min:15',
            'purpose' => 'nullable|string',
            'location' => 'nullable|string',
        ]);

        $meeting = new ParentTeacherMeeting($validated);
        $meeting->created_by = auth()->id();
        $meeting->status = 'Scheduled';
        $meeting->save();

        // Notify Parent (assuming Parent model has a user relationship or is a user)
        // Adjust based on your actual User/Parent relationship structure
        if ($meeting->parent && $meeting->parent->user) {
            $meeting->parent->user->notify(new \App\Notifications\MeetingScheduled($meeting));
        }

        return redirect()->route('parent-teacher-meetings.index')->with('success', 'PTM scheduled successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParentTeacherMeeting $parentTeacherMeeting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParentTeacherMeeting $parentTeacherMeeting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ParentTeacherMeeting $parentTeacherMeeting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParentTeacherMeeting $parentTeacherMeeting)
    {
        //
    }
}
