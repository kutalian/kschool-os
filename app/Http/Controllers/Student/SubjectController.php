<?php

namespace App\Http\Controllers\Student;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Syllabus;

class SubjectController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            abort(403, 'Student profile not found.');
        }

        $classRoom = $student->class_room;

        if (!$classRoom) {
            return view('student.subjects.index', ['subjects' => collect(), 'syllabi' => collect()]);
        }

        // Fetch subjects assigned to this class
        $subjects = $classRoom->subjects;

        // Fetch syllabus for this class
        $syllabi = Syllabus::where('class_id', $classRoom->id)
            ->get()
            ->groupBy('subject_id');

        return view('student.subjects.index', compact('classRoom', 'subjects', 'syllabi'));
    }
}
