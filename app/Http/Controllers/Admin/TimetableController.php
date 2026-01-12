<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\Timetable;
use App\Models\User; // Assuming Teacher is User
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        $classRooms = ClassRoom::where('is_active', true)->get();
        // Fetch exams for the merged view
        $exams = \App\Models\Exam::orderBy('start_date', 'desc')->get();
        return view('admin.timetable.index', compact('classRooms', 'exams'));
    }

    public function manage(Request $request)
    {
        $classId = $request->query('class_id');
        if (!$classId) {
            return redirect()->route('timetable.index');
        }

        $classRoom = ClassRoom::findOrFail($classId);

        // Auto-seed Days if empty
        if (\App\Models\ClassTimetableDay::where('class_id', $classId)->count() == 0) {
            $defaultDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            foreach ($defaultDays as $day) {
                \App\Models\ClassTimetableDay::create(['class_id' => $classId, 'name' => $day]);
            }
        }

        // Auto-seed Periods if empty & migrate data
        if (\App\Models\ClassTimetablePeriod::where('class_id', $classId)->count() == 0) {
            $defaultPeriods = [
                1 => ['08:00', '08:40'],
                2 => ['08:40', '09:20'],
                3 => ['09:20', '10:00'],
                4 => ['10:15', '10:55'],
                5 => ['10:55', '11:30'],
                6 => ['12:00', '12:40'],
                7 => ['12:40', '13:20'],
                8 => ['13:20', '14:00'],
            ];
            foreach ($defaultPeriods as $oldId => $times) {
                $newPeriod = \App\Models\ClassTimetablePeriod::create([
                    'class_id' => $classId,
                    'name' => "Period $oldId",
                    'start_time' => $times[0],
                    'end_time' => $times[1]
                ]);
                // Migrate existing timetables for this class and old period ID
                Timetable::where('class_id', $classId)
                    ->where('period_id', $oldId) // Assuming old logic stored simple int
                    ->update(['period_id' => $newPeriod->id]);
            }
        }

        $days = \App\Models\ClassTimetableDay::where('class_id', $classId)->get();
        $periods = \App\Models\ClassTimetablePeriod::where('class_id', $classId)->orderBy('start_time')->get();
        $timetables = Timetable::where('class_id', $classId)->get();

        // Structure data: $schedule[DayName][PeriodID] = Entry
        $schedule = [];
        foreach ($timetables as $t) {
            $schedule[$t->day][$t->period_id] = $t;
        }

        // Fetch subjects for dropdowns
        $subjects = Subject::where('is_active', true)->get();
        // Fetch teachers
        $teachers = User::where('role', 'staff')->get();

        return view('admin.timetable.manage', compact('classRoom', 'schedule', 'days', 'periods', 'subjects', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'day' => 'required|string', // Still using day name from ClassTimetableDay->name
            'period_id' => 'required|exists:class_timetable_periods,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        Timetable::updateOrCreate(
            [
                'class_id' => $request->class_id,
                'day' => $request->day,
                'period_id' => $request->period_id,
            ],
            [
                'subject_id' => $request->subject_id,
                'teacher_id' => $request->teacher_id,
            ]
        );

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'day' => 'required|string',
            'period_id' => 'required|exists:class_timetable_periods,id',
        ]);

        Timetable::where('class_id', $request->class_id)
            ->where('day', $request->day)
            ->where('period_id', $request->period_id)
            ->delete();

        return response()->json(['success' => true]);
    }

    // Dynamic Structure Methods

    public function storeDay(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'name' => 'required|string|max:255',
        ]);

        \App\Models\ClassTimetableDay::create($request->all());
        return back()->with('success', 'Day added successfully');
    }

    public function destroyDay(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:class_timetable_days,id',
        ]);

        $day = \App\Models\ClassTimetableDay::findOrFail($request->id);
        // Also delete timetables for this day
        Timetable::where('class_id', $day->class_id)->where('day', $day->name)->delete();
        $day->delete();

        return back()->with('success', 'Day deleted successfully');
    }

    public function storePeriod(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'name' => 'nullable|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        \App\Models\ClassTimetablePeriod::create($request->all());
        return back()->with('success', 'Period added successfully');
    }

    public function destroyPeriod(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:class_timetable_periods,id',
        ]);

        $period = \App\Models\ClassTimetablePeriod::findOrFail($request->id);
        // Also delete timetables for this period
        Timetable::where('class_id', $period->class_id)->where('period_id', $period->id)->delete();
        $period->delete();

        return back()->with('success', 'Period deleted successfully');
    }
}
