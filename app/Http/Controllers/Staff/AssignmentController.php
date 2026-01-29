<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\Submission;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $assignments = Assignment::where('created_by', $user->id)
            ->with(['class_room', 'subject'])
            ->latest()
            ->paginate(10);

        return view('staff.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $user = Auth::user();
        $staff = $user->staff;

        if (!$staff) {
            return redirect()->route('dashboard')->with('error', 'Staff profile not found.');
        }

        // Fetch relevant classes
        $homeroomClasses = ClassRoom::where('class_teacher_id', $staff->id)->get();
        $scheduledClasses = Timetable::where('teacher_id', $user->id)
            ->with('classRoom')
            ->get()
            ->pluck('classRoom')
            ->unique('id');

        $classes = $homeroomClasses->merge($scheduledClasses)->unique('id');
        $subjects = Subject::where('is_active', true)->get();

        return view('staff.assignments.create', compact('classes', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after:today',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip|max:5120',
        ]);

        $data = $request->only(['class_id', 'subject_id', 'title', 'description', 'due_date']);
        $data['created_by'] = Auth::id();

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('assignments', 'public');
        }

        Assignment::create($data);

        return redirect()->route('staff.assignments.index')->with('success', 'Assignment created successfully.');
    }

    public function show(Assignment $assignment)
    {
        return $this->submissions($assignment);
    }

    public function edit(Assignment $assignment)
    {
        if ($assignment->created_by !== Auth::id()) {
            abort(403);
        }

        $user = Auth::user();
        $staff = $user->staff;

        $homeroomClasses = ClassRoom::where('class_teacher_id', $staff->id)->get();
        $scheduledClasses = Timetable::where('teacher_id', $user->id)
            ->with('classRoom')
            ->get()
            ->pluck('classRoom')
            ->unique('id');

        $classes = $homeroomClasses->merge($scheduledClasses)->unique('id');
        $subjects = Subject::where('is_active', true)->get();

        return view('staff.assignments.edit', compact('assignment', 'classes', 'subjects'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        if ($assignment->created_by !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip|max:5120',
        ]);

        $data = $request->only(['class_id', 'subject_id', 'title', 'description', 'due_date']);

        if ($request->hasFile('file')) {
            if ($assignment->file_path) {
                Storage::disk('public')->delete($assignment->file_path);
            }
            $data['file_path'] = $request->file('file')->store('assignments', 'public');
        }

        $assignment->update($data);

        return redirect()->route('staff.assignments.index')->with('success', 'Assignment updated successfully.');
    }

    public function destroy(Assignment $assignment)
    {
        if ($assignment->created_by !== Auth::id()) {
            abort(403);
        }

        if ($assignment->file_path) {
            Storage::disk('public')->delete($assignment->file_path);
        }

        $assignment->delete();

        return redirect()->route('staff.assignments.index')->with('success', 'Assignment deleted successfully.');
    }

    public function submissions(Assignment $assignment)
    {
        if ($assignment->created_by !== Auth::id()) {
            abort(403);
        }

        $submissions = $assignment->submissions()->with('student.user')->get();

        return view('staff.assignments.submissions', compact('assignment', 'submissions'));
    }

    public function grade(Request $request, Submission $submission)
    {
        if ($submission->assignment->created_by !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'marks_obtained' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
        ]);

        $submission->update([
            'marks_obtained' => $request->marks_obtained,
            'remarks' => $request->remarks,
        ]);

        return back()->with('success', 'Grade updated successfully.');
    }
}
