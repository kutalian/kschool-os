<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\Subject;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExamQuestionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $questions = ExamQuestion::where('teacher_id', $user->id)
            ->with(['class_room', 'subject', 'exam'])
            ->latest()
            ->paginate(10);

        return view('staff.exam-questions.index', compact('questions'));
    }

    public function create()
    {
        $user = Auth::user();
        $staff = $user->staff;

        if (!$staff) {
            return redirect()->route('dashboard');
        }

        // Fetch relevant classes and subjects (similar to AssignmentController)
        $homeroomClasses = ClassRoom::where('class_teacher_id', $staff->id)->get();
        $scheduledClasses = Timetable::where('teacher_id', $user->id)
            ->with('classRoom')
            ->get()
            ->pluck('classRoom')
            ->unique('id');

        $classes = $homeroomClasses->merge($scheduledClasses)->unique('id');
        $subjects = Subject::where('is_active', true)->get();
        $exams = Exam::orderBy('start_date', 'desc')->get();

        return view('staff.exam-questions.create', compact('classes', 'subjects', 'exams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_id' => 'nullable|exists:exams,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240',
        ]);

        $data = $request->only(['class_id', 'subject_id', 'exam_id', 'title', 'content']);
        $data['teacher_id'] = Auth::id();
        $data['status'] = 'pending';

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('exam-questions', 'public');
        }

        ExamQuestion::create($data);

        return redirect()->route('staff.exam-questions.index')->with('success', 'Exam questions submitted for review.');
    }

    public function show(ExamQuestion $examQuestion)
    {
        if ($examQuestion->teacher_id !== Auth::id()) {
            abort(403);
        }

        return view('staff.exam-questions.show', compact('examQuestion'));
    }

    public function edit(ExamQuestion $examQuestion)
    {
        if ($examQuestion->teacher_id !== Auth::id() || $examQuestion->status !== 'pending') {
            return redirect()->route('staff.exam-questions.index')->with('error', 'You cannot edit this submission.');
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
        $exams = Exam::orderBy('start_date', 'desc')->get();

        return view('staff.exam-questions.edit', compact('examQuestion', 'classes', 'subjects', 'exams'));
    }

    public function update(Request $request, ExamQuestion $examQuestion)
    {
        if ($examQuestion->teacher_id !== Auth::id() || $examQuestion->status !== 'pending') {
            abort(403);
        }

        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_id' => 'nullable|exists:exams,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240',
        ]);

        $data = $request->only(['class_id', 'subject_id', 'exam_id', 'title', 'content']);

        if ($request->hasFile('file')) {
            if ($examQuestion->file_path) {
                Storage::disk('public')->delete($examQuestion->file_path);
            }
            $data['file_path'] = $request->file('file')->store('exam-questions', 'public');
        }

        $examQuestion->update($data);

        return redirect()->route('staff.exam-questions.index')->with('success', 'Exam question submission updated.');
    }

    public function destroy(ExamQuestion $examQuestion)
    {
        if ($examQuestion->teacher_id !== Auth::id()) {
            abort(403);
        }

        if ($examQuestion->file_path) {
            Storage::disk('public')->delete($examQuestion->file_path);
        }

        $examQuestion->delete();

        return redirect()->route('staff.exam-questions.index')->with('success', 'Submission deleted.');
    }
}
