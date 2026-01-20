<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Staff;
use App\Models\StudentParent;
use App\Models\ClassRoom;
use App\Models\Attendance;
use App\Models\Payment;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashboardStatsService
{
    /**
     * Get basic count of entities.
     */
    public function getCounts(): array
    {
        return [
            'students' => Student::count(),
            'staff' => Staff::count(),
            'parents' => StudentParent::count(),
            'classes' => ClassRoom::count(),
        ];
    }

    /**
     * Get today's attendance statistics.
     */
    public function getAttendanceStats(): array
    {
        $today = now()->format('Y-m-d');
        // Use count() directly on query if possible, but here we need present/absent counts from the same set
        // A single query with aggregates is better than retrieving all models

        $stats = Attendance::where('date', $today)
            ->selectRaw('count(*) as total')
            ->selectRaw("count(case when status = 'Present' then 1 end) as present")
            ->selectRaw("count(case when status = 'Absent' then 1 end) as absent")
            ->first();

        $total = $stats->total ?? 0;
        $present = $stats->present ?? 0;
        $absent = $stats->absent ?? 0;

        return [
            'total' => $total,
            'present' => $present,
            'absent' => $absent,
            'percentage' => $total > 0 ? round(($present / $total) * 100, 1) : 0,
        ];
    }

    /**
     * Get recent student admissions.
     */
    public function getRecentStudents(int $limit = 5): Collection
    {
        return Student::with(['class_room']) // Eager load class_room to fix N+1
            ->latest()
            ->take($limit)
            ->get();
    }

    /**
     * Get financial summary for the current month.
     */
    public function getMonthlyFinance(): array
    {
        $currentMonth = Carbon::now()->startOfMonth();

        return [
            'collection' => Payment::where('payment_date', '>=', $currentMonth)->sum('amount'),
            'expenses' => Expense::where('date', '>=', $currentMonth)->sum('amount'),
        ];
    }

    /**
     * Get chart data for the last N months.
     */
    public function getChartData(int $months = 6): array
    {
        $labels = [];
        $revenueData = [];
        $expenseData = [];

        // Opt for a single query with grouping if data is large, but loop is fine for 6 items 
        // provided we don't do N queries inside the loop if we can avoid it.
        // For now, keeping the logic similar but potentially we could optimize further.
        // Let's stick to the loop for readability as per review recommendation (just moved to service),
        // but it's cleaner here.

        for ($i = $months - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->format('M');
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();

            $labels[] = $monthName;
            $revenueData[] = Payment::whereBetween('payment_date', [$startOfMonth, $endOfMonth])->sum('amount');
            $expenseData[] = Expense::whereBetween('date', [$startOfMonth, $endOfMonth])->sum('amount');
        }

        return [
            'labels' => $labels,
            'revenue' => $revenueData,
            'expenses' => $expenseData
        ];
    }
}
