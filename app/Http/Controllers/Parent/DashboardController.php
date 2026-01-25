<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Notice;

class DashboardController extends Controller
{
    public function index()
    {
        $notices = Notice::whereIn('audience', ['all', 'parent'])
            ->where('is_active', true)
            ->latest()
            ->take(5)
            ->get();

        return view('parent.dashboard', compact('notices'));
    }
}
