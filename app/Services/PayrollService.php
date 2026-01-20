<?php

namespace App\Services;

use App\Models\Payroll;
use App\Models\Staff;
use App\Models\StaffAttendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PayrollService
{
    /**
     * Calculate payroll data for a specific staff member for a given month.
     * returns array with keys: basic_salary, deduction, allowance, net_salary, absent_days
     */
    public function calculatePayrollData(Staff $staff, string $month): array
    {
        // Parse Year and Month from "YYYY-MM"
        $date = Carbon::createFromFormat('Y-m', $month);
        $year = $date->year;
        $monthNum = $date->month;

        // Count Absent Days
        $absentDays = StaffAttendance::where('staff_id', $staff->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $monthNum)
            ->whereIn('status', ['Absent', 'Leave'])
            ->count();

        $basicSalary = $staff->basic_salary ?? 0;

        // Calculate Deduction: (Basic / 30) * Absent Days
        // Using 30 days as a standard month for simplification, or could use daysInMonth
        $daysInMonth = 30;
        $dailyRate = $basicSalary > 0 ? $basicSalary / $daysInMonth : 0;
        $deduction = $dailyRate * $absentDays;

        // Allowances (Placeholder for now, could be fetched from another table)
        $allowance = 0;

        $netSalary = $basicSalary - $deduction + $allowance;

        return [
            'basic_salary' => $basicSalary,
            'deduction' => round($deduction, 2),
            'allowance' => round($allowance, 2),
            'net_salary' => round($netSalary > 0 ? $netSalary : 0, 2),
            'absent_days' => $absentDays
        ];
    }

    /**
     * Generate or Update payroll record for a staff member.
     */
    public function generatePayroll(Staff $staff, string $month): Payroll
    {
        $data = $this->calculatePayrollData($staff, $month);

        return Payroll::updateOrCreate(
            ['staff_id' => $staff->id, 'month' => $month],
            [
                'basic_salary' => $data['basic_salary'],
                'deduction' => $data['deduction'],
                'allowance' => $data['allowance'],
                'net_salary' => $data['net_salary'],
                'status' => 'Pending',
                'payment_date' => now(), // Default to generation date, or null? Controller had now()
            ]
        );
    }

    /**
     * Generate payroll for all active staff for a month.
     * Returns count of generated records.
     */
    public function generateBulkPayroll(string $month): int
    {
        $staffMembers = Staff::where('is_active', true)->get();
        $count = 0;

        foreach ($staffMembers as $staff) {
            $this->generatePayroll($staff, $month);
            $count++;
        }

        return $count;
    }
}
