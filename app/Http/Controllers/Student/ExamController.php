<?php

namespace App\Http\Controllers\Student;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Exam;
use App\Models\Mark;

class ExamController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            abort(403, 'Student profile not found.');
        }

        $classId = $student->class_id;

        // Fetch exams for the student's class
        $exams = Exam::where('class_id', $classId)
            ->orderBy('start_date', 'desc')
            ->get();

        // Fetch marks for the student
        $marks = Mark::where('student_id', $student->id)
            ->with(['subject', 'exam'])
            ->get()
            ->groupBy('exam_id');

        return view('student.exams.index', compact('exams', 'marks'));
    }
}
