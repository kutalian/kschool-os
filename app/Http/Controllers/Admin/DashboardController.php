<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardStatsService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected DashboardStatsService $statsService;

    public function __construct(DashboardStatsService $statsService)
    {
        $this->statsService = $statsService;
    }

    public function index(): View
    {
        $stats = $this->statsService->getCounts();
        $attendanceStats = $this->statsService->getAttendanceStats();
        $recentStudents = $this->statsService->getRecentStudents();
        $finance = $this->statsService->getMonthlyFinance();
        $chartData = $this->statsService->getChartData();

        return view('admin.dashboard', [
            'stats' => $stats,
            'attendanceStats' => $attendanceStats,
            'recentStudents' => $recentStudents,
            'monthlyCollection' => $finance['collection'],
            'monthlyExpenses' => $finance['expenses'],
            'chartData' => $chartData,
        ]);
    }
}
