<?php

namespace App\Http\Controllers\Admin\StudentServices;

use App\Http\Controllers\Controller;
use App\Models\DisciplinaryRecord;
use App\Models\Student;
use Illuminate\Http\Request;

class DisciplinaryController extends Controller
{
    public function index()
    {
        $records = DisciplinaryRecord::with('student', 'reporter', 'handler')->latest()->paginate(10);
        return view('admin.student-services.discipline.index', compact('records'));
    }

    public function create()
    {
        $students = Student::select('id', 'name', 'admission_no')->get();
        return view('admin.student-services.discipline.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'incident_date' => 'required|date',
            'incident_type' => 'required|in:Misconduct,Fighting,Bullying,Absence,Late,Uniform,Other',
            'description' => 'required|string',
            'action_taken' => 'required|in:Warning,Detention,Suspension,Expulsion,Counseling,Parent Meeting',
            'duration_days' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'parent_notified' => 'boolean',
            'remarks' => 'nullable|string',
        ]);

        $validated['reported_by'] = auth()->id();

        DisciplinaryRecord::create($validated);

        return redirect()->route('disciplinary-records.index')->with('success', 'Disciplinary record recorded successfully.');
    }

    public function show(DisciplinaryRecord $disciplinaryRecord)
    {
        return view('admin.student-services.discipline.show', compact('disciplinaryRecord'));
    }

    public function edit(DisciplinaryRecord $disciplinaryRecord)
    {
        $students = Student::select('id', 'name', 'admission_no')->get();
        return view('admin.student-services.discipline.edit', compact('disciplinaryRecord', 'students'));
    }

    public function confirmDelete(DisciplinaryRecord $disciplinaryRecord)
    {
        return view('admin.student-services.discipline.delete', compact('disciplinaryRecord'));
    }

    public function update(Request $request, DisciplinaryRecord $disciplinaryRecord)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'incident_date' => 'required|date',
            'incident_type' => 'required|in:Misconduct,Fighting,Bullying,Absence,Late,Uniform,Other',
            'description' => 'required|string',
            'action_taken' => 'required|in:Warning,Detention,Suspension,Expulsion,Counseling,Parent Meeting',
            'duration_days' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'parent_notified' => 'boolean',
            'remarks' => 'nullable|string',
        ]);

        $disciplinaryRecord->update($validated);

        return redirect()->route('disciplinary-records.index')->with('success', 'Disciplinary record updated successfully.');
    }

    public function destroy(DisciplinaryRecord $disciplinaryRecord)
    {
        $disciplinaryRecord->delete();
        return redirect()->route('disciplinary-records.index')->with('success', 'Disciplinary record deleted successfully.');
    }
}
