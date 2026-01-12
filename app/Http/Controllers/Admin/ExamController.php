<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with('class_room')->latest()->paginate(10);
        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        $classes = ClassRoom::where('is_active', true)->get();
        return view('admin.exams.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'exam_type' => 'required|in:Mid-Term,Final,Quiz,Test,Assignment',
            'class_id' => 'required|exists:classes,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'academic_year' => 'nullable|string|max:20',
            'term' => 'nullable|string|max:20',
        ]);

        Exam::create($validated);

        return redirect()->route('exams.index')->with('success', 'Exam created successfully.');
    }

    public function publish(Exam $exam)
    {
        $exam->is_published = !$exam->is_published;
        $exam->save();
        $status = $exam->is_published ? 'published' : 'unpublished';
        return redirect()->back()->with('success', "Exam {$status} successfully.");
    }

    public function admitCards(Exam $exam)
    {
        $exam->load('class_room');
        $students = \App\Models\Student::where('class_id', $exam->class_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.exams.admit-cards', compact('exam', 'students'));
    }

    public function confirmDelete(Exam $exam)
    {
        $marksCount = \App\Models\Mark::where('exam_id', $exam->id)->count();
        return view('admin.exams.delete', compact('exam', 'marksCount'));
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('exams.index')->with('success', 'Exam deleted successfully.');
    }
}
