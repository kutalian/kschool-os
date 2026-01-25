<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\AlumniDonation;
use App\Models\Student;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumni::query();

        if ($request->has('graduation_year') && $request->graduation_year) {
            $query->where('graduation_year', $request->graduation_year);
        }

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $alumni = $query->latest()->paginate(10);
        $graduationYears = Alumni::select('graduation_year')->distinct()->orderBy('graduation_year', 'desc')->pluck('graduation_year');

        return view('admin.alumni.index', compact('alumni', 'graduationYears'));
    }

    public function create()
    {
        // Students who are not yet alumni and inactive (presumably graduated/left) can be listed here if needed
        return view('admin.alumni.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
            'graduation_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'graduation_class' => 'nullable|string|max:50',
            'current_occupation' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'willing_to_mentor' => 'boolean',
        ]);

        Alumni::create($validated);

        return redirect()->route('alumni.index')->with('success', 'Alumni record created successfully.');
    }

    public function show(Alumni $alumni)
    {
        $alumni->load('donations');
        return view('admin.alumni.show', compact('alumni'));
    }

    public function edit(Alumni $alumni)
    {
        return view('admin.alumni.edit', compact('alumni'));
    }

    public function update(Request $request, Alumni $alumni)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
            'graduation_year' => 'required|integer',
            'graduation_class' => 'nullable|string|max:50',
            'current_occupation' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'willing_to_mentor' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $alumni->update($validated);

        return redirect()->route('alumni.index')->with('success', 'Alumni updated successfully.');
    }

    public function destroy(Alumni $alumni)
    {
        $alumni->delete();
        return redirect()->route('alumni.index')->with('success', 'Alumni record deleted.');
    }

    // Donation Methods
    public function storeDonation(Request $request, Alumni $alumni)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'donation_date' => 'required|date',
            'purpose' => 'nullable|string|max:255',
            'payment_method' => 'required|in:Cash,Bank Transfer,Online,Cheque',
            'transaction_id' => 'nullable|string|max:100',
            'remarks' => 'nullable|string',
        ]);

        $alumni->donations()->create($validated);

        return back()->with('success', 'Donation recorded successfully.');
    }
}
