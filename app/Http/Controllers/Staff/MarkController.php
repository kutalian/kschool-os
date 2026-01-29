<?php

namespace App\Http\Controllers\Staff;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassRoom;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\Subject;
use App\Models\ClassTimetablePeriod;
use App\Models\Timetable;
use Illuminate\Support\Facades\Auth;

class MarkController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $staff = $user->staff;

        if (!$staff)
            return redirect()->route('dashboard');

        // Reuse class fetching logic... ideally this should be a service but for now copy-paste
        $homeroomClasses = ClassRoom::where('class_teacher_id', $staff->id)->get();
        $scheduledClasses = Timetable::where('teacher_id', $user->id)
            ->with('classRoom')
            ->get()
            ->pluck('classRoom')
            ->unique('id');

        $classes = $homeroomClasses->merge($scheduledClasses)->unique('id');

        return view('staff.marks.index', compact('classes'));
    }

    public function create(Request $request)
    {
        $classId = $request->get('class_id');
        $examId = $request->get('exam_id');
        $subjectId = $request->get('subject_id');

        $classRoom = ClassRoom::findOrFail($classId);

        // Fetch exams for this class
        $exams = Exam::where('class_id', $classId)->orderBy('start_date', 'desc')->get();

        // Fetch subjects for this class
        // This is a bit tricky as subjects are many-to-many. 
        // We should ideally only show subjects this teacher teaches if they are not the class teacher.
        // But for simplicity let's show all class subjects.
        $subjects = $classRoom->subjects;

        if ($examId && $subjectId) {
            $students = $classRoom->students;

            $existingMarks = Mark::where('exam_id', $examId)
                ->where('subject_id', $subjectId)
                ->get()
                ->keyBy('student_id');

            $selectedExam = $exams->find($examId);
            $selectedSubject = $subjects->find($subjectId);

            return view('staff.marks.create', compact(
                'classRoom',
                'exams',
                'subjects',
                'students',
                'existingMarks',
                'examId',
                'subjectId',
                'selectedExam',
                'selectedSubject'
            ));
        }

        return view('staff.marks.create', compact('classRoom', 'exams', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'exam_id' => 'required|exists:exams,id',
            'subject_id' => 'required|exists:subjects,id',
            'marks' => 'required|array',
            'marks.*' => 'nullable|numeric|min:0|max:100',
            'remarks' => 'nullable|array',
        ]);

        foreach ($request->marks as $studentId => $score) {
            if ($score !== null || isset($request->remarks[$studentId])) {
                Mark::updateOrCreate(
                    [
                        'exam_id' => $request->exam_id,
                        'subject_id' => $request->subject_id,
                        'student_id' => $studentId,
                    ],
                    [
                        'marks_obtained' => $score,
                        'total_marks' => 100, // Default for now
                        'remarks' => $request->remarks[$studentId] ?? null,
                    ]
                );
            }
        }

        return redirect()->route('staff.marks.create', [
            'class_id' => $request->class_id,
            'exam_id' => $request->exam_id,
            'subject_id' => $request->subject_id
        ])->with('success', 'Marks updated successfully.');
    }
}
