<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\TransportRoute;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    // --- Dashboard ---
    public function index()
    {
        // Counts for tabs
        $vehicles = Vehicle::withCount('routes')->latest()->paginate(10);
        $routes = TransportRoute::with('vehicle')->withCount('students')->latest()->paginate(10);
        return view('admin.transport.index', compact('vehicles', 'routes'));
    }

    // --- Vehicle Management ---
    public function storeVehicle(Request $request)
    {
        $validated = $request->validate([
            'vehicle_number' => 'required|string|unique:school_vehicles,vehicle_number|max:20',
            'capacity' => 'required|integer|min:1',
            'driver_name' => 'required|string|max:100',
            'driver_license' => 'required|string|max:50',
            'driver_phone' => 'required|string|max:20',
            'status' => 'required|in:active,maintenance,retired',
        ]);

        Vehicle::create($validated);

        return redirect()->route('transport.index')->with('success', 'Vehicle added successfully.');
    }

    public function updateVehicle(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'vehicle_number' => 'required|string|max:20|unique:school_vehicles,vehicle_number,' . $vehicle->id,
            'capacity' => 'required|integer|min:1',
            'driver_name' => 'required|string|max:100',
            'driver_license' => 'required|string|max:50',
            'driver_phone' => 'required|string|max:20',
            'status' => 'required|in:active,maintenance,retired',
        ]);

        $vehicle->update($validated);

        return redirect()->route('transport.index')->with('success', 'Vehicle updated successfully.');
    }

    public function destroyVehicle(Vehicle $vehicle)
    {
        if ($vehicle->routes()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete vehicle assigned to active routes. Reassign or delete routes first.');
        }
        $vehicle->delete();
        return redirect()->route('transport.index')->with('success', 'Vehicle deleted.');
    }

    public function confirmDeleteVehicle(Vehicle $vehicle)
    {
        return view('admin.transport.vehicles.delete', compact('vehicle'));
    }

    public function editVehicle(Vehicle $vehicle)
    {
        return view('admin.transport.vehicles.edit', compact('vehicle'));
    }


    // --- Route Management ---
    public function storeRoute(Request $request)
    {
        $validated = $request->validate([
            'route_name' => 'required|string|max:100', // Changed from title
            'start_point' => 'required|string|max:100',
            'end_point' => 'required|string|max:100',
            'fare' => 'required|numeric|min:0',
            'vehicle_id' => 'nullable|exists:school_vehicles,id',
        ]);

        TransportRoute::create($validated);

        return redirect()->route('transport.index')->with('success', 'Route created successfully.');
    }

    public function updateRoute(Request $request, TransportRoute $transportRoute)
    {
        $validated = $request->validate([
            'route_name' => 'required|string|max:100', // Changed from title
            'start_point' => 'required|string|max:100',
            'end_point' => 'required|string|max:100',
            'fare' => 'required|numeric|min:0',
            'vehicle_id' => 'nullable|exists:school_vehicles,id',
        ]);

        $transportRoute->update($validated);

        return redirect()->route('transport.index')->with('success', 'Route updated successfully.');
    }

    public function destroyRoute(TransportRoute $transportRoute)
    {
        $transportRoute->delete();
        return redirect()->route('transport.index')->with('success', 'Route deleted.');
    }

    public function confirmDeleteRoute(TransportRoute $transportRoute)
    {
        return view('admin.transport.routes.delete', compact('transportRoute'));
    }

    public function editRoute(TransportRoute $transportRoute)
    {
        $vehicles = Vehicle::where('status', 'active')->get();
        return view('admin.transport.routes.edit', compact('transportRoute', 'vehicles'));
    }
}
