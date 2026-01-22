<?php

namespace App\Http\Controllers\Admin\FrontOffice;

use App\Http\Controllers\Controller;
use App\Models\PostalRecord;
use Illuminate\Http\Request;

class PostalRecordController extends Controller
{
    public function index()
    {
        $records = PostalRecord::latest()->paginate(10);
        return view('admin.front-office.postal-records.index', compact('records'));
    }

    public function create()
    {
        return view('admin.front-office.postal-records.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender_name' => 'required|string|max:100',
            'type' => 'required|in:Dispatch,Receive',
            'reference_no' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $validated['created_by'] = auth()->id();
        PostalRecord::create($validated);

        return redirect()->route('postal-records.index')->with('success', 'Postal record added successfully.');
    }

    public function edit(PostalRecord $postalRecord)
    {
        return view('admin.front-office.postal-records.edit', compact('postalRecord'));
    }

    public function update(Request $request, PostalRecord $postalRecord)
    {
        $validated = $request->validate([
            'sender_name' => 'required|string|max:100',
            'type' => 'required|in:Dispatch,Receive',
            'reference_no' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $postalRecord->update($validated);

        return redirect()->route('postal-records.index')->with('success', 'Postal record updated successfully.');
    }

    public function destroy(PostalRecord $postalRecord)
    {
        $postalRecord->delete();
        return redirect()->route('postal-records.index')->with('success', 'Postal record deleted successfully.');
    }
}
