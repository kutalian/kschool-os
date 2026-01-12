<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentPromotionController extends Controller
{
    public function index(Request $request)
    {
        $classRooms = ClassRoom::where('is_active', true)->get();
        $students = [];

        if ($request->has('source_class_id') && $request->source_class_id) {
            $students = Student::where('class_id', $request->source_class_id)
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
        }

        return view('admin.students.promotion.index', compact('classRooms', 'students'));
    }

    public function promote(Request $request)
    {
        $request->validate([
            'source_class_id' => 'required|exists:classes,id',
            'destination_class_id' => 'required|exists:classes,id|different:source_class_id',
            'students' => 'required|array',
            'students.*' => 'exists:students,id'
        ]);

        $count = Student::whereIn('id', $request->students)->update([
            'class_id' => $request->destination_class_id
        ]);

        return redirect()->route('students.promotion', ['source_class_id' => $request->source_class_id])
            ->with('success', "$count students promoted successfully.");
    }
}
