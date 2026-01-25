<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransportAllocation;
use App\Models\TransportRoute;
use App\Models\Student;
use Illuminate\Http\Request;

class TransportAllocationController extends Controller
{
    public function index(Request $request)
    {
        $query = TransportAllocation::with(['student', 'route']);

        if ($request->has('route_id') && $request->route_id) {
            $query->where('route_id', $request->route_id);
        }

        $allocations = $query->orderBy('allocated_at', 'desc')->paginate(15);
        $routes = TransportRoute::all();

        return view('admin.transport.allocations.index', compact('allocations', 'routes'));
    }

    public function create()
    {
        $routes = TransportRoute::where('is_active', true)->get();
        return view('admin.transport.allocations.create', compact('routes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id|unique:transport_allocations,student_id',
            'route_id' => 'required|exists:transport_routes,id',
            'pickup_point' => 'nullable|string|max:255',
        ]);

        $validated['allocated_at'] = now();

        TransportAllocation::create($validated);

        return redirect()->route('transport.allocations.index')->with('success', 'Student allocated to route successfully.');
    }

    public function destroy(TransportAllocation $allocation)
    {
        $allocation->delete();
        return redirect()->route('transport.allocations.index')->with('success', 'Allocation removed successfully.');
    }

    // API/AJAX for searching students
    public function searchStudents(Request $request)
    {
        $search = $request->get('q');
        $students = Student::where('name', 'like', "%{$search}%")
            ->orWhere('admission_no', 'like', "%{$search}%")
            ->limit(20)
            ->get(['id', 'name', 'admission_no']);

        return response()->json($students);
    }
}
