<?php

namespace App\Http\Controllers\Staff;



use App\Http\Controllers\Controller;
use App\Models\Timetable;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassTimetablePeriod;

class TimetableController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch all timetable entries for this teacher
        $timetableEntries = Timetable::where('teacher_id', $user->id)
            ->with(['classRoom', 'subject', 'period'])
            ->get();

        // Organize by Day -> Period ID
        $timetable = [];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        // Fetch periods to structure the grid (assuming common periods for simplicity, 
        // or we just show what's assigned)
        $periods = ClassTimetablePeriod::orderBy('start_time')->get();

        foreach ($days as $day) {
            foreach ($periods as $period) {
                // Find entry for this day and period
                $entry = $timetableEntries->where('day', $day)
                    ->where('period_id', $period->id)
                    ->first();

                $timetable[$day][$period->id] = $entry;
            }
        }

        return view('staff.timetable.index', compact('timetable', 'days', 'periods'));
    }
}
