<?php

namespace App\Http\Controllers\Staff;



use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Timetable;
use Illuminate\Support\Facades\Auth;

class MyClassController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $staff = $user->staff;

        if (!$staff) {
            abort(403, 'Unauthorized access');
        }

        // 1. Homeroom Classes
        $homeroomClasses = ClassRoom::where('class_teacher_id', $staff->id)->get();

        // 2. Scheduled Classes (via Timetable)
        $scheduledClasses = Timetable::where('teacher_id', $user->id)
            ->with('classRoom')
            ->get()
            ->pluck('classRoom')
            ->unique('id'); // Ensure uniqueness

        // Merge and unique by ID
        $classes = $homeroomClasses->merge($scheduledClasses)->unique('id');

        return view('staff.classes.index', compact('classes', 'homeroomClasses'));
    }

    public function show($id)
    {
        $classRoom = ClassRoom::with('students')->findOrFail($id);

        // Security Check: Ensure staff has access to this class
        $user = Auth::user();
        $staff = $user->staff;

        $isHomeroom = $classRoom->class_teacher_id === $staff->id;
        $isTeaching = Timetable::where('teacher_id', $user->id)
            ->where('class_id', $id)
            ->exists();

        if (!$isHomeroom && !$isTeaching) {
            abort(403, 'You do not have access to this class.');
        }

        return view('staff.classes.show', compact('classRoom'));
    }
}
