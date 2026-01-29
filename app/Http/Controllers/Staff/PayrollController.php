<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{
    public function index()
    {
        $staff = Staff::where('user_id', Auth::id())->firstOrFail();

        $payrollHistory = Payroll::where('staff_id', $staff->id)
            ->latest('month')
            ->paginate(12);

        return view('staff.payroll.index', compact('payrollHistory'));
    }

    public function show(Payroll $payroll)
    {
        $staff = Staff::where('user_id', Auth::id())->firstOrFail();

        if ($payroll->staff_id !== $staff->id) {
            abort(403);
        }

        return view('staff.payroll.show', compact('payroll', 'staff'));
    }
}
