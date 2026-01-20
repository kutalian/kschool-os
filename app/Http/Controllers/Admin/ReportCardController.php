<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\Student;
use App\Services\GradingService;
use Illuminate\Http\Request;

class ReportCardController extends Controller
{
    protected GradingService $gradingService;

    public function __construct(GradingService $gradingService)
    {
        $this->gradingService = $gradingService;
    }

    public function index(Request $request)
    {
        $classes = ClassRoom::where('is_active', true)->get();
        $exams = Exam::latest()->get();

        $students = [];
        $selectedClass = null;
        $selectedExam = null;
        $recentReports = collect();

        if ($request->has('class_id') && $request->has('exam_id')) {
            $selectedClass = ClassRoom::find($request->class_id);
            $selectedExam = Exam::find($request->exam_id);

            if ($selectedClass && $selectedExam) {
                $students = Student::where('class_id', $selectedClass->id)
                    ->orderBy('name')
                    ->get();
            }
        } else {
            // Fetch Recent Reports (Students with marks)
            // We get the latest marks, then group by student and exam to get unique reports
            $recentReports = Mark::with(['student.class_room', 'exam'])
                ->latest('updated_at')
                ->get()
                ->unique(function ($item) {
                    return $item->student_id . '-' . $item->exam_id;
                })
                ->take(10);
        }

        return view('admin.reports.index', compact('classes', 'exams', 'students', 'selectedClass', 'selectedExam', 'recentReports'));
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
        $aggregates = $this->gradingService->calculateAggregates($marks);
        $totalMarksObtained = $aggregates['total'];
        $totalMaxMarks = $marks->count() * 100; // Still assuming 100 per subject for now
        $percentage = $aggregates['average']; // Average approximates percentage if max marks are equal across subjects

        // Determine Overall Grade (Using Service)
        // Note: calculateGrade returns an array (grade, point, color, description) or null
        $gradeData = $this->gradingService->calculateGrade($percentage);
        $grade = $gradeData['grade'] ?? 'N/A';

        // Attendance stats
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
}
