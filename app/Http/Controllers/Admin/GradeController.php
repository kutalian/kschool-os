<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::orderBy('max_marks', 'desc')->get();
        return view('admin.grades.index', compact('grades'));
    }

    public function create()
    {
        return view('admin.grades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'grade' => 'required|string|max:5|unique:grading_system,grade',
            'min_marks' => 'required|numeric|min:0|max:100',
            'max_marks' => 'required|numeric|min:0|max:100|gt:min_marks',
            'grade_point' => 'nullable|numeric|min:0|max:10',
            'description' => 'nullable|string|max:100',
            'color_code' => 'nullable|string|max:20',
        ]);

        Grade::create($request->all());

        return redirect()->route('grades.index')->with('success', 'Grade created successfully.');
    }

    public function edit(Grade $grade)
    {
        return view('admin.grades.edit', compact('grade'));
    }

    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'grade' => 'required|string|max:5|unique:grading_system,grade,' . $grade->id,
            'min_marks' => 'required|numeric|min:0|max:100',
            'max_marks' => 'required|numeric|min:0|max:100|gt:min_marks',
            'grade_point' => 'nullable|numeric|min:0|max:10',
            'description' => 'nullable|string|max:100',
            'color_code' => 'nullable|string|max:20',
        ]);

        $grade->update($request->all());

        return redirect()->route('grades.index')->with('success', 'Grade updated successfully.');
    }

    public function confirmDelete(Grade $grade)
    {
        return view('admin.grades.delete', compact('grade'));
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('grades.index')->with('success', 'Grade deleted successfully.');
    }
}
