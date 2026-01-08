<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\Student;
use Illuminate\Http\Request;

class ReportCardController extends Controller
{
    public function index(Request $request)
    {
        $classes = ClassRoom::where('is_active', true)->get();
        $exams = Exam::latest()->get();

        $students = [];
        $selectedClass = null;
        $selectedExam = null;

        if ($request->has('class_id') && $request->has('exam_id')) {
            $selectedClass = ClassRoom::find($request->class_id);
            $selectedExam = Exam::find($request->exam_id);

            if ($selectedClass && $selectedExam) {
                $students = Student::where('class_id', $selectedClass->id)
                    ->orderBy('name')
                    ->get();
            }
        }

        return view('admin.reports.index', compact('classes', 'exams', 'students', 'selectedClass', 'selectedExam'));
    }

    public function print($studentId, $examId)
    {
        $student = Student::with(['class_room', 'user'])->findOrFail($studentId);
        $exam = Exam::findOrFail($examId);

        // Fetch Marks
        $marks = Mark::with('subject')
            ->where('student_id', $studentId)
            ->where('exam_id', $examId)
            ->get();

        // Calculate Totals and Percentage
        $totalMarksObtained = $marks->sum('marks_obtained');
        $totalMaxMarks = $marks->count() * 100; // Assuming 100 per subject
        $percentage = $totalMaxMarks > 0 ? ($totalMarksObtained / $totalMaxMarks) * 100 : 0;

        // Determine Overall Grade (Simple Logic for now)
        $grade = $this->calculateGrade($percentage);

        // Attendance stats (for the exam period or academic year - simplifying to "Total Present" count for now)
        $totalAttendance = Attendance::where('student_id', $studentId)->count();
        $presentDays = Attendance::where('student_id', $studentId)->where('status', 'Present')->count();
        $attendancePercentage = $totalAttendance > 0 ? ($presentDays / $totalAttendance) * 100 : 0;

        return view('admin.reports.print', compact(
            'student',
            'exam',
            'marks',
            'totalMarksObtained',
            'totalMaxMarks',
            'percentage',
            'grade',
            'attendancePercentage',
            'presentDays',
            'totalAttendance'
        ));
    }

    private function calculateGrade($percentage)
    {
        if ($percentage >= 75)
            return 'A';
        if ($percentage >= 60)
            return 'B';
        if ($percentage >= 50)
            return 'C';
        if ($percentage >= 40)
            return 'D';
        return 'F';
    }
}
