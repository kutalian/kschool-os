<?php

namespace App\Http\Controllers\Admin\StudentServices;

use App\Http\Controllers\Controller;
use App\Models\HealthRecord;
use App\Models\Student;
use Illuminate\Http\Request;

class HealthRecordController extends Controller
{
    public function index()
    {
        $records = HealthRecord::with('student', 'creator')->latest()->paginate(10);
        return view('admin.student-services.health.index', compact('records'));
    }

    public function create()
    {
        $students = Student::select('id', 'name', 'admission_no')->get();
        return view('admin.student-services.health.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'record_date' => 'required|date',
            'record_type' => 'required|in:Checkup,Illness,Injury,Vaccination,Allergy,Other',
            'symptoms' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'medication_prescribed' => 'nullable|string',
            'doctor_name' => 'nullable|string',
            'hospital_name' => 'nullable|string',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'blood_pressure' => 'nullable|string',
            'temperature' => 'nullable|numeric',
            'next_checkup' => 'nullable|date',
        ]);

        $validated['created_by'] = auth()->id();

        HealthRecord::create($validated);

        return redirect()->route('health-records.index')->with('success', 'Health record added successfully.');
    }

    public function show(HealthRecord $healthRecord)
    {
        return view('admin.student-services.health.show', compact('healthRecord'));
    }

    public function edit(HealthRecord $healthRecord)
    {
        $students = Student::select('id', 'name', 'admission_no')->get();
        return view('admin.student-services.health.edit', compact('healthRecord', 'students'));
    }

    public function confirmDelete(HealthRecord $healthRecord)
    {
        return view('admin.student-services.health.delete', compact('healthRecord'));
    }

    public function update(Request $request, HealthRecord $healthRecord)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'record_date' => 'required|date',
            'record_type' => 'required|in:Checkup,Illness,Injury,Vaccination,Allergy,Other',
            'symptoms' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'medication_prescribed' => 'nullable|string',
            'doctor_name' => 'nullable|string',
            'hospital_name' => 'nullable|string',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'blood_pressure' => 'nullable|string',
            'temperature' => 'nullable|numeric',
            'next_checkup' => 'nullable|date',
        ]);

        $healthRecord->update($validated);

        return redirect()->route('health-records.index')->with('success', 'Health record updated successfully.');
    }

    public function destroy(HealthRecord $healthRecord)
    {
        $healthRecord->delete();
        return redirect()->route('health-records.index')->with('success', 'Health record deleted successfully.');
    }
}
