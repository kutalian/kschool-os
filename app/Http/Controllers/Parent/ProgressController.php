<?php

namespace App\Http\Controllers\Parent;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Exam;
use App\Models\Mark;

class ProgressController extends Controller
{
    public function show($studentId)
    {
        $user = Auth::user();
        $parent = $user->parent;

        if (!$parent) {
            abort(403, 'Parent profile not found.');
        }

        $student = Student::where('id', $studentId)->where('parent_id', $parent->id)->firstOrFail();

        $exams = Exam::where('class_id', $student->class_id)
            ->orderBy('start_date', 'desc')
            ->get();

        $marks = Mark::where('student_id', $student->id)
            ->with(['subject', 'exam'])
            ->get()
            ->groupBy('exam_id');

        return view('parent.progress.show', compact('student', 'exams', 'marks'));
    }
}
