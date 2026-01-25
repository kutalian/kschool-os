<?php

namespace App\Http\Controllers\Student;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Timetable;
use App\Models\ClassTimetablePeriod;

class TimetableController extends Controller
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
            return view('student.timetable.index', ['timetable' => [], 'days' => [], 'periods' => []]);
        }

        // Fetch timetable for student's class
        $timetableEntries = Timetable::where('class_id', $classRoom->id)
            ->with(['subject', 'teacher', 'period'])
            ->get();

        // Organize by Day -> Period ID
        $timetable = [];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $periods = ClassTimetablePeriod::orderBy('start_time')->get();

        foreach ($days as $day) {
            foreach ($periods as $period) {
                $entry = $timetableEntries->where('day', $day)
                    ->where('period_id', $period->id)
                    ->first();

                $timetable[$day][$period->id] = $entry;
            }
        }

        return view('student.timetable.index', compact('timetable', 'days', 'periods', 'classRoom'));
    }
}
