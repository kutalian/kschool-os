<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Student;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with('student')->latest()->paginate(10);
        return view('admin.certificates.index', compact('certificates'));
    }

    public function create()
    {
        $students = Student::select('id', 'name')->get();
        return view('admin.certificates.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'certificate_type' => 'required|string',
            'unique_code' => 'required|string|unique:certificates,unique_code',
            'issue_date' => 'required|date',
            'content' => 'nullable|string',
        ]);

        $validated['issued_by'] = auth()->id();

        Certificate::create($validated);

        return redirect()->route('certificates.index')->with('success', 'Certificate issued successfully.');
    }

    public function show(Certificate $certificate)
    {
        return view('admin.certificates.show', compact('certificate'));
    }

    public function confirmDelete(Certificate $certificate)
    {
        return view('admin.certificates.delete', compact('certificate'));
    }

    public function destroy(Certificate $certificate)
    {
        try {
            $certificate->delete();
            return redirect()->route('certificates.index')->with('success', 'Certificate deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('certificates.index')->with('error', 'Failed to delete certificate: ' . $e->getMessage());
        }
    }
}
