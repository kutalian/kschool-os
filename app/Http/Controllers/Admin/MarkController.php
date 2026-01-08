<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    public function create()
    {
        $exams = Exam::with('class_room')->latest()->get();
        // Since exams are linked to classes, we can filter subjects based on the selected exam's class in the frontend or via AJAX if we had it, 
        // but for now, we'll load all subjects or handle it in the next step.
        // Actually, a better flow is: Select Exam -> Select Subject -> Enter Marks.
        // Let's pass all active subjects.
        $subjects = Subject::all();

        return view('admin.marks.create', compact('exams', 'subjects'));
    }

    public function manage(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $exam = Exam::with('class_room')->findOrFail($request->exam_id);
        $subject = Subject::findOrFail($request->subject_id);

        // Fetch students in the exam's class
        $students = Student::where('class_id', $exam->class_id)
            ->orderBy('name')
            ->get();

        // Fetch existing marks
        $existingMarks = Mark::where('exam_id', $exam->id)
            ->where('subject_id', $subject->id)
            ->get()
            ->keyBy('student_id');

        return view('admin.marks.entry', compact('exam', 'subject', 'students', 'existingMarks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'subject_id' => 'required|exists:subjects,id',
            'marks' => 'array',
            'marks.*' => 'nullable|numeric|min:0|max:100',
        ]);

        $examId = $request->exam_id;
        $subjectId = $request->subject_id;

        foreach ($request->marks as $studentId => $score) {
            if ($score !== null) {
                Mark::updateOrCreate(
                    [
                        'exam_id' => $examId,
                        'student_id' => $studentId,
                        'subject_id' => $subjectId,
                    ],
                    [
                        'marks_obtained' => $score,
                        'total_marks' => 100, // Defaulting to 100 for now
                    ]
                );
            }
        }

        return redirect()->route('marks.create')->with('success', 'Marks saved successfully.');
    }
}
