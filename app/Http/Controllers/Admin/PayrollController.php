<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Models\Staff;
use App\Models\StaffAttendance;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', date('Y-m'));

        $payrolls = Payroll::where('month', $month)
            ->with('staff')
            ->get();

        return view('admin.payroll.index', compact('payrolls', 'month'));
    }

    public function create()
    {
        return view('admin.payroll.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required',
        ]);

        $month = $request->month;
        $staffMembers = Staff::where('is_active', true)->get();

        // Parse Year and Month
        list($year, $monthNum) = explode('-', $month);

        foreach ($staffMembers as $staff) {
            // Count absences
            $absentDays = StaffAttendance::where('staff_id', $staff->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $monthNum)
                ->whereIn('status', ['Absent', 'Leave']) // Assuming Leave is unpaid
                ->count();

            // Calculate Deduction: (Basic / 30) * Absent Days
            $basicSalary = $staff->basic_salary ?? 0;
            $dailyRate = $basicSalary > 0 ? $basicSalary / 30 : 0;
            $deduction = $dailyRate * $absentDays;

            // Calculate Net
            $netSalary = $basicSalary - $deduction; // + Allowances if any, currently 0

            Payroll::updateOrCreate(
                ['staff_id' => $staff->id, 'month' => $month],
                [
                    'basic_salary' => $basicSalary,
                    'deduction' => round($deduction, 2),
                    'allowance' => 0,
                    'net_salary' => round($netSalary > 0 ? $netSalary : 0, 2),
                    'status' => 'Pending',
                    'payment_date' => now(),
                ]
            );
        }

        return redirect()->route('payroll.index', ['month' => $month])
            ->with('success', 'Payroll generated successfully for ' . $month);
    }

    public function show(Payroll $payroll)
    {
        $payroll->load('staff');
        return view('admin.payroll.show', compact('payroll'));
    }

    public function edit(Payroll $payroll)
    {
        $payroll->load('staff');
        return view('admin.payroll.edit', compact('payroll'));
    }

    public function update(Request $request, Payroll $payroll)
    {
        $validated = $request->validate([
            'basic_salary' => 'required|numeric|min:0',
            'allowance' => 'required|numeric|min:0',
            'deduction' => 'required|numeric|min:0',
            'status' => 'required|in:Paid,Pending',
        ]);

        // Recalculate Net Salary
        $netSalary = $validated['basic_salary'] + $validated['allowance'] - $validated['deduction'];

        $payroll->update([
            'basic_salary' => $validated['basic_salary'],
            'allowance' => $validated['allowance'],
            'deduction' => $validated['deduction'],
            'status' => $validated['status'],
            'net_salary' => $netSalary > 0 ? $netSalary : 0,
            'payment_date' => $validated['status'] === 'Paid' ? now() : $payroll->payment_date,
        ]);

        return redirect()->route('payroll.index', ['month' => $payroll->month])
            ->with('success', 'Payroll record updated successfully.');
    }

    public function print(Payroll $payroll)
    {
        $payroll->load('staff');
        return view('admin.payroll.print', compact('payroll'));
    }
}
