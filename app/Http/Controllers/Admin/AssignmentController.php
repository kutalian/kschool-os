<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Assignment;
use App\Models\ClassRoom;
use App\Models\Subject;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Assignment::query()->with(['class_room', 'subject', 'creator']);

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        $assignments = $query->latest()->paginate(10);
        $classes = ClassRoom::all();
        $subjects = Subject::all();

        return view('admin.assignments.index', compact('assignments', 'classes', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip|max:10240', // 10MB
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('assignments', $filename, 'public');
        }

        Assignment::create([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'file_path' => $filePath,
            'created_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Assignment created successfully.');
    }

    public function show(Assignment $assignment)
    {
        $assignment->load(['submissions.student', 'class_room', 'subject']);
        return view('admin.assignments.show', compact('assignment'));
    }

    public function download(Assignment $assignment)
    {
        if (!$assignment->file_path || !Storage::exists('public/' . $assignment->file_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return Storage::download('public/' . $assignment->file_path, $assignment->title . '_' . basename($assignment->file_path));
    }

    public function confirmDelete(Assignment $assignment)
    {
        return view('admin.assignments.delete', compact('assignment'));
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->delete(); // Soft delete
        return redirect()->route('assignments.index')->with('success', 'Assignment deleted successfully.');
    }
}
