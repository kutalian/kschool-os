<?php

namespace App\Http\Controllers\Accountant;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentFee;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['studentFee.student', 'studentFee.feeType'])->latest('payment_date')->paginate(15);
        return view('accountant.payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $invoice = null;
        if ($request->has('invoice_id')) {
            $invoice = StudentFee::with(['student', 'feeType'])->findOrFail($request->invoice_id);
        }

        // If not accessed via invoice, maybe show a search form? 
        // For now, let's assume entry via invoice link or manual search implementation later.
        // We'll list pending invoices if no ID provided, or just redirect.
        if (!$invoice) {
            return redirect()->route('accountant.fees.index')->with('error', 'Please select an invoice to pay.');
        }

        return view('accountant.payments.create', compact('invoice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_fee_id' => 'required|exists:student_fees,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            'payment_date' => 'required|date',
            'transaction_id' => 'nullable|string',
        ]);

        $invoice = StudentFee::findOrFail($request->student_fee_id);

        // Calculate new paid amount
        $newPaid = $invoice->paid + $request->amount;

        if ($newPaid > $invoice->amount) {
            return back()->with('error', 'Payment amount exceeds remaining balance.');
        }

        // Create Payment
        Payment::create([
            'student_fee_id' => $invoice->id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'status' => 'Completed',
            // 'received_by' => auth()->id(), // If we want to track who collected it
        ]);

        // Update Invoice Status
        $invoice->paid = $newPaid;
        if ($newPaid >= $invoice->amount) {
            $invoice->status = 'Paid';
        } else {
            $invoice->status = 'Partial';
        }
        $invoice->save();

        return redirect()->route('accountant.payments.index')->with('success', 'Payment recorded successfully.');
    }
}
