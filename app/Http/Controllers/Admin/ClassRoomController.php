<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Staff;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    public function index()
    {
        $classes = ClassRoom::with(['teacher', 'subjects'])->latest()->paginate(10);
        $teachers = Staff::all();
        $subjects = \App\Models\Subject::all();
        return view('admin.classes.index', compact('classes', 'teachers', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'section' => 'nullable|string|max:10',
            'capacity' => 'required|integer|min:1',
            'class_teacher_id' => 'nullable|exists:staff,id',
        ]);

        ClassRoom::create($validated);

        return redirect()->back()->with('success', 'Class created successfully.');
    }

    public function update(Request $request, ClassRoom $classRoom)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'section' => 'nullable|string|max:10',
            'capacity' => 'required|integer|min:1',
            'class_teacher_id' => 'nullable|exists:staff,id',
        ]);

        $classRoom->update($validated);

        return redirect()->back()->with('success', 'Class updated successfully.');
    }

    public function confirmDelete(ClassRoom $classRoom)
    {
        // Check enrolled students and assigned subjects
        $studentsCount = \App\Models\Student::where('class_id', $classRoom->id)->count();
        $subjectsCount = $classRoom->subjects()->count();

        return view('admin.classes.delete', compact('classRoom', 'studentsCount', 'subjectsCount'));
    }

    public function destroy(ClassRoom $classRoom)
    {
        $classRoom->delete();
        return redirect()->route('classes.index')->with('success', 'Class deleted.');
    }

    public function assignSubjects(Request $request, ClassRoom $classRoom)
    {
        $validated = $request->validate([
            'subjects' => 'array',
            'subjects.*' => 'exists:subjects,id',
        ]);

        $classRoom->subjects()->sync($validated['subjects'] ?? []);

        return redirect()->back()->with('success', 'Subjects assigned successfully.');
    }
}
