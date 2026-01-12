<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\ExamSchedule;
use Illuminate\Http\Request;

class ExamScheduleController extends Controller
{
    public function index()
    {
        $exams = Exam::orderBy('start_date', 'desc')->get();
        $classRooms = ClassRoom::where('is_active', true)->get();
        return view('admin.exam_schedule.index', compact('exams', 'classRooms'));
    }

    public function manage(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'class_id' => 'required|exists:classes,id',
        ]);

        $exam = Exam::findOrFail($request->exam_id);
        $classRoom = ClassRoom::findOrFail($request->class_id);

        // Fetch Dynamic Configuration
        $dates = \App\Models\ExamDate::where('exam_id', $exam->id)->orderBy('date')->get();
        $periods = \App\Models\ExamPeriod::where('exam_id', $exam->id)->orderBy('start_time')->get();

        // Get subjects
        $subjects = Subject::where('is_active', true)->get();

        // Get existing schedule
        // We match by start_time for compatibility if periods change, but best to rely on start_time continuity.
        // Actually, let's just fetch all.
        $existingSchedules = ExamSchedule::where('exam_id', $exam->id)
            ->where('class_id', $classRoom->id)
            ->get();

        // Structure for Grid: $schedule[DateString][PeriodID] = Entry
        // We need to match existing schedules to the *current* periods by time.
        // If a schedule exists for 08:00 but no period 08:00 exists, it won't show (orphaned).
        // That's acceptable for now.
        $schedule = [];
        foreach ($existingSchedules as $Entry) {
            $schedule[$Entry->date][$Entry->start_time] = $Entry; // Index by time as a stable key
        }

        return view('admin.exam_schedule.manage', compact('exam', 'classRoom', 'subjects', 'schedule', 'periods', 'dates'));
    }

    public function storeDate(Request $request)
    {
        $request->validate(['exam_id' => 'required', 'date' => 'required|date']);
        \App\Models\ExamDate::firstOrCreate(
            ['exam_id' => $request->exam_id, 'date' => $request->date]
        );
        return back()->with('success', 'Date added successfully.');
    }

    public function destroyDate(Request $request)
    {
        \App\Models\ExamDate::where('id', $request->id)->delete();
        return back()->with('success', 'Date removed.');
    }

    public function storePeriod(Request $request)
    {
        $request->validate([
            'exam_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'name' => 'nullable|string'
        ]);
        \App\Models\ExamPeriod::create($request->all());
        return back()->with('success', 'Period added successfully.');
    }

    public function destroyPeriod(Request $request)
    {
        \App\Models\ExamPeriod::where('id', $request->id)->delete();
        return back()->with('success', 'Period removed.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'class_id' => 'required|exists:classes,id',
            'date' => 'required|date',
            'period_id' => 'required|exists:exam_periods,id', // This is now the DB ID
            'subject_id' => 'required|exists:subjects,id',
            'room_number' => 'nullable|string',
        ]);

        $period = \App\Models\ExamPeriod::findOrFail($request->period_id);

        ExamSchedule::updateOrCreate(
            [
                'exam_id' => $request->exam_id,
                'class_id' => $request->class_id,
                'date' => $request->date,
                'start_time' => $period->start_time,
            ],
            [
                'end_time' => $period->end_time,
                'subject_id' => $request->subject_id,
                'room_number' => $request->room_number,
            ]
        );

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'exam_id' => 'required',
            'class_id' => 'required',
            'date' => 'required',
            'period_id' => 'required', // This can be period ID or we pass start_time? View likely passes period ID.
        ]);

        $period = \App\Models\ExamPeriod::find($request->period_id);

        if ($period) {
            ExamSchedule::where('exam_id', $request->exam_id)
                ->where('class_id', $request->class_id)
                ->where('date', $request->date)
                ->where('start_time', $period->start_time)
                ->delete();
        }

        return response()->json(['success' => true]);
    }
}
