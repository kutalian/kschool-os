<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hostel;
use Illuminate\Http\Request;

class HostelController extends Controller
{
    public function index()
    {
        $hostels = Hostel::withCount('rooms')->latest()->paginate(10);
        return view('admin.hostel.index', compact('hostels'));
    }

    public function create()
    {
        return view('admin.hostel.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:Boys,Girls,Mixed',
            'address' => 'nullable|string|max:255',
            'warden_name' => 'nullable|string|max:100',
            'warden_contact' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        Hostel::create($validated);

        return redirect()->route('hostel.index')->with('success', 'Hostel created successfully.');
    }

    public function show(Hostel $hostel)
    {
        $hostel->load([
            'rooms' => function ($query) {
                $query->withCount([
                    'allocations' => function ($q) {
                        $q->where('status', 'active');
                    }
                ]);
            }
        ]);
        return view('admin.hostel.show', compact('hostel'));
    }

    public function edit(Hostel $hostel)
    {
        return view('admin.hostel.edit', compact('hostel'));
    }

    public function update(Request $request, Hostel $hostel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:Boys,Girls,Mixed',
            'address' => 'nullable|string|max:255',
            'warden_name' => 'nullable|string|max:100',
            'warden_contact' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        $hostel->update($validated);

        return redirect()->route('hostel.index')->with('success', 'Hostel updated successfully.');
    }

    public function destroy(Hostel $hostel)
    {
        if ($hostel->rooms()->count() > 0) {
            return back()->with('error', 'Cannot delete hostel with rooms. Delete rooms first.');
        }
        $hostel->delete();
        return redirect()->route('hostel.index')->with('success', 'Hostel deleted.');
    }
}
