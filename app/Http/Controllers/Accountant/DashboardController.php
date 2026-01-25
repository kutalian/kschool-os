<?php

namespace App\Http\Controllers\Accountant;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentFee;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCollections = Payment::sum('amount');
        $todaysCollections = Payment::whereDate('payment_date', today())->sum('amount');
        $pendingFees = StudentFee::whereIn('status', ['Unpaid', 'Partial'])->sum('amount') - StudentFee::whereIn('status', ['Unpaid', 'Partial'])->sum('paid');

        // Recent Payments
        $recentPayments = Payment::with(['studentFee.student'])
            ->orderBy('payment_date', 'desc')
            ->take(5)
            ->get();

        return view('accountant.dashboard', compact('totalCollections', 'todaysCollections', 'pendingFees', 'recentPayments'));
    }
}
