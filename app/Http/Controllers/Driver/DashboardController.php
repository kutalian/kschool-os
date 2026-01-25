<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vehicle;
use App\Models\TransportRoute;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Assuming relationship: User -> Driver (Staff/Driver Model) -> Vehicle
        // Logic might need adjustment based on how 'Driver' is stored. 
        // Based on previous file exploration, there is a 'Driver' folder but no specific 'Driver' model, 
        // likely 'Staff' with role 'driver'.

        $vehicle = Vehicle::where('user_id', $user->id)->first();
        $routes = TransportRoute::all(); // Placeholder, ideally specific to vehicle

        return view('driver.dashboard', compact('vehicle', 'routes'));
    }
}
