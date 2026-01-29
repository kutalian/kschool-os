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

    public function export($id)
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

        $fileName = 'students_' . str_replace(' ', '_', $classRoom->name) . '_' . date('Y-m-d') . '.csv';
        $students = $classRoom->students;

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('Admission No', 'First Name', 'Last Name', 'Roll Number', 'Email', 'Parent Name', 'Parent Phone');

        $callback = function () use ($students, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($students as $student) {
                $row['Admission No'] = $student->admission_no;
                $row['First Name'] = $student->first_name;
                $row['Last Name'] = $student->last_name;
                $row['Roll Number'] = $student->roll_number;
                $row['Email'] = $student->email;
                $row['Parent Name'] = $student->parent->name ?? 'N/A';
                $row['Parent Phone'] = $student->parent->phone ?? 'N/A';

                fputcsv($file, array($row['Admission No'], $row['First Name'], $row['Last Name'], $row['Roll Number'], $row['Email'], $row['Parent Name'], $row['Parent Phone']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
