<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Models\Staff;
use App\Services\PayrollService;

class PayrollController extends Controller
{
    protected PayrollService $payrollService;

    public function __construct(PayrollService $payrollService)
    {
        $this->payrollService = $payrollService;
    }

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

        // Use Service for Bulk Generation
        // This keeps the controller clean and the logic reusable
        $count = $this->payrollService->generateBulkPayroll($month);

        return redirect()->route('payroll.index', ['month' => $month])
            ->with('success', "Payroll generated successfully for {$count} staff members for {$month}");
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
