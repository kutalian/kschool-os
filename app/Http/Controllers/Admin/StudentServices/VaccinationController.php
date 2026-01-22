<?php

namespace App\Http\Controllers\Admin\StudentServices;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Vaccination;
use Illuminate\Http\Request;

class VaccinationController extends Controller
{
    public function index()
    {
        $vaccinations = Vaccination::with('student')->latest()->paginate(10);
        return view('admin.student-services.vaccinations.index', compact('vaccinations'));
    }

    public function create()
    {
        $students = Student::select('id', 'name', 'admission_no')->get();
        return view('admin.student-services.vaccinations.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'vaccine_name' => 'required|string|max:100',
            'dose_number' => 'required|integer|min:1',
            'vaccination_date' => 'required|date',
            'next_dose_date' => 'nullable|date|after:vaccination_date',
            'administered_by' => 'nullable|string',
            'hospital_name' => 'nullable|string',
            'batch_number' => 'nullable|string',
        ]);

        Vaccination::create($validated);

        return redirect()->route('vaccinations.index')->with('success', 'Vaccination record added successfully.');
    }

    public function show(Vaccination $vaccination)
    {
        return view('admin.student-services.vaccinations.show', compact('vaccination'));
    }

    public function edit(Vaccination $vaccination)
    {
        $students = Student::select('id', 'name', 'admission_no')->get();
        return view('admin.student-services.vaccinations.edit', compact('vaccination', 'students'));
    }

    public function confirmDelete(Vaccination $vaccination)
    {
        return view('admin.student-services.vaccinations.delete', compact('vaccination'));
    }

    public function update(Request $request, Vaccination $vaccination)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'vaccine_name' => 'required|string|max:100',
            'dose_number' => 'required|integer|min:1',
            'vaccination_date' => 'required|date',
            'next_dose_date' => 'nullable|date|after:vaccination_date',
            'administered_by' => 'nullable|string',
            'hospital_name' => 'nullable|string',
            'batch_number' => 'nullable|string',
        ]);

        $vaccination->update($validated);

        return redirect()->route('vaccinations.index')->with('success', 'Vaccination record updated successfully.');
    }

    public function destroy(Vaccination $vaccination)
    {
        $vaccination->delete();
        return redirect()->route('vaccinations.index')->with('success', 'Vaccination record deleted successfully.');
    }
}
