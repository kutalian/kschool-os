<?php

namespace App\Http\Controllers\Admin\FrontOffice;

use App\Http\Controllers\Controller;
use App\Models\AdmissionEnquiry;
use Illuminate\Http\Request;

class AdmissionEnquiryController extends Controller
{
    public function index()
    {
        $enquiries = AdmissionEnquiry::latest()->paginate(10);
        return view('admin.front-office.enquiries.index', compact('enquiries'));
    }

    public function create()
    {
        return view('admin.front-office.enquiries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'date' => 'required|date',
            'next_follow_up' => 'nullable|date',
            'status' => 'required|in:Pending,Contacted,Visited,Admitted,Rejected'
        ]);

        AdmissionEnquiry::create($validated);

        return redirect()->route('admission-enquiries.index')->with('success', 'Enquiry created successfully.');
    }

    public function edit(AdmissionEnquiry $admissionEnquiry)
    {
        return view('admin.front-office.enquiries.edit', compact('admissionEnquiry'));
    }

    public function update(Request $request, AdmissionEnquiry $admissionEnquiry)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'date' => 'required|date',
            'next_follow_up' => 'nullable|date',
            'status' => 'required|in:Pending,Contacted,Visited,Admitted,Rejected'
        ]);

        $admissionEnquiry->update($validated);

        return redirect()->route('admission-enquiries.index')->with('success', 'Enquiry updated successfully.');
    }

    public function destroy(AdmissionEnquiry $admissionEnquiry)
    {
        $admissionEnquiry->delete();
        return redirect()->route('admission-enquiries.index')->with('success', 'Enquiry deleted successfully.');
    }
}
