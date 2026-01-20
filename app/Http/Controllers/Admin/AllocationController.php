<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HostelAllocation;
use App\Models\HostelRoom;
use Illuminate\Http\Request;

class AllocationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:hostel_rooms,id',
            'student_id' => 'required|exists:students,id',
            'check_in_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        $room = HostelRoom::findOrFail($request->room_id);

        // check capacity
        $activeAllocations = $room->allocations()->where('status', 'active')->count();
        if ($activeAllocations >= $room->capacity) {
            return back()->with('error', 'Room is full.');
        }

        // check if student already has a room
        $studentHasRoom = HostelAllocation::where('student_id', $request->student_id)
            ->where('status', 'active')
            ->exists();

        if ($studentHasRoom) {
            return back()->with('error', 'Student is already allocated a room.');
        }

        HostelAllocation::create([
            'room_id' => $request->room_id,
            'student_id' => $request->student_id,
            'check_in_date' => $request->check_in_date,
            'status' => 'active',
            'remarks' => $request->remarks,
        ]);

        return back()->with('success', 'Student allocated to room successfully.');
    }

    public function vacate(Request $request, HostelAllocation $allocation)
    {
        $allocation->update([
            'status' => 'vacated',
            'vacated_date' => now(),
        ]);

        return back()->with('success', 'Student vacated from room.');
    }
}
