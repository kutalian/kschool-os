<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\Syllabus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SyllabusController extends Controller
{
    public function index(Request $request)
    {
        $classes = ClassRoom::all();
        $subjects = Subject::all();

        $query = Syllabus::with(['class_room', 'subject', 'uploader']);

        if ($request->class_id) {
            $query->where('class_id', $request->class_id);
        }
        if ($request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }

        $syllabi = $query->latest()->paginate(10);

        return view('admin.syllabus.index', compact('syllabi', 'classes', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:5120', // 5MB
        ]);

        $path = $request->file('file')->store('syllabus', 'public');

        Syllabus::create([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
            'created_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Syllabus uploaded successfully.');
    }

    public function download(Syllabus $syllabus)
    {
        return Storage::download('public/' . $syllabus->file_path, $syllabus->title . '.' . pathinfo($syllabus->file_path, PATHINFO_EXTENSION));
    }

    public function confirm_delete(Syllabus $syllabus)
    {
        return view('admin.syllabus.delete', compact('syllabus'));
    }

    public function destroy(Syllabus $syllabus)
    {
        // For soft deletes, we don't delete the file yet.
        // If hard delete is needed later, we check trashed().

        $syllabus->delete();

        return redirect()->route('syllabus.index')->with('success', 'Syllabus moved to trash.');
    }
}
