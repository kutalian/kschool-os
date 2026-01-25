<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\AdmissionEnquiry;
use App\Models\PhoneCallLog;

class DashboardController extends Controller
{

    public function index()
    {
        $todayVisitors = Visitor::where('created_at', '>=', today()->startOfDay())->count();
        $todayEnquiries = AdmissionEnquiry::where('created_at', '>=', today()->startOfDay())->count();
        $todayCalls = PhoneCallLog::where('created_at', '>=', today()->startOfDay())->count();

        $recentVisitors = Visitor::latest()->take(5)->get();

        return view('receptionist.dashboard', compact('todayVisitors', 'todayEnquiries', 'todayCalls', 'recentVisitors'));
    }
}
