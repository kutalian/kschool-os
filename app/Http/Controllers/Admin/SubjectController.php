<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::latest()->paginate(10);
        return view('admin.subjects.index', compact('subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:subjects,code',
            'type' => 'required|in:Theory,Practical,Both',
            'credit_hours' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        Subject::create($validated);

        return redirect()->back()->with('success', 'Subject created successfully.');
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:subjects,code,' . $subject->id,
            'type' => 'required|in:Theory,Practical,Both',
            'credit_hours' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $subject->update($validated);

        return redirect()->back()->with('success', 'Subject updated successfully.');
    }

    public function confirmDelete(Subject $subject)
    {
        // Count classes using this subject
        $classesCount = $subject->classes()->count();

        return view('admin.subjects.delete', compact('subject', 'classesCount'));
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->back()->with('success', 'Subject deleted.');
    }
}
