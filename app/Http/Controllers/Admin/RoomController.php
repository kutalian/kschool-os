<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HostelRoom;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hostel_id' => 'required|exists:hostels,id',
            'room_number' => 'required|string|max:20',
            'room_type' => 'required|in:Single,Double,Triple,Dormitory',
            'capacity' => 'required|integer|min:1',
            'cost_per_term' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        // Check uniqueness within hostel
        $exists = HostelRoom::where('hostel_id', $request->hostel_id)
            ->where('room_number', $request->room_number)
            ->exists();

        if ($exists) {
            return back()->withErrors(['room_number' => 'Room number already exists in this hostel.']);
        }

        HostelRoom::create($validated);

        return back()->with('success', 'Room added successfully.');
    }

    public function update(Request $request, HostelRoom $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:20',
            'room_type' => 'required|in:Single,Double,Triple,Dormitory',
            'capacity' => 'required|integer|min:1',
            'cost_per_term' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        // Check uniqueness within hostel (excluding self)
        $exists = HostelRoom::where('hostel_id', $room->hostel_id)
            ->where('room_number', $request->room_number)
            ->where('id', '!=', $room->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['room_number' => 'Room number already exists in this hostel.']);
        }

        $room->update($validated);

        return back()->with('success', 'Room updated successfully.');
    }

    public function destroy(HostelRoom $room)
    {
        if ($room->allocations()->where('status', 'active')->exists()) {
            return back()->with('error', 'Cannot delete room with active allocations.');
        }
        $room->delete();
        return back()->with('success', 'Room deleted.');
    }
}
