<?php

namespace App\Http\Controllers\Admin\FrontOffice;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visitors = Visitor::latest()->paginate(10);
        return view('admin.front-office.visitors.index', compact('visitors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.front-office.visitors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'purpose' => 'required|string|max:255',
            'check_in' => 'required|date',
            'person_to_meet' => 'nullable|string|max:100',
            'id_proof' => 'nullable|string|max:100',
            'no_of_persons' => 'nullable|integer',
            'note' => 'nullable|string'
        ]);

        $validated['created_by'] = auth()->id();

        Visitor::create($validated);

        return redirect()->route('visitors.index')->with('success', 'Visitor record created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visitor $visitor)
    {
        return view('admin.front-office.visitors.edit', compact('visitor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visitor $visitor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'purpose' => 'required|string|max:255',
            'check_in' => 'required|date',
            'check_out' => 'nullable|date|after_or_equal:check_in',
            'person_to_meet' => 'nullable|string|max:100',
            'note' => 'nullable|string'
        ]);

        $visitor->update($validated);

        return redirect()->route('visitors.index')->with('success', 'Visitor record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visitor $visitor)
    {
        $visitor->delete();
        return redirect()->route('visitors.index')->with('success', 'Visitor record deleted successfully.');
    }
}
