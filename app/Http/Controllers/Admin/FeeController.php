<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeType;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\StudentFee;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Services\FeeService;

class FeeController extends Controller
{
    protected $feeService;

    public function __construct(FeeService $feeService)
    {
        $this->feeService = $feeService;
    }

    public function index()
    {
        $feeTypes = FeeType::where('is_active', true)->get();
        return view('admin.fees.index', compact('feeTypes'));
    }

    public function create()
    {
        return view('admin.fees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'frequency' => 'required|in:One-Time,Monthly,Quarterly,Annually',
            'description' => 'nullable|string',
        ]);

        FeeType::create($request->all());

        return redirect()->route('fees.index')->with('success', 'Fee Type created successfully.');
    }

    public function edit(FeeType $fee)
    {
        return view('admin.fees.edit', compact('fee'));
    }

    public function update(Request $request, FeeType $fee)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'frequency' => 'required|in:One-Time,Monthly,Quarterly,Annually',
            'description' => 'nullable|string',
        ]);

        $fee->update($request->all());

        return redirect()->route('fees.index')->with('success', 'Fee Type updated successfully.');
    }

    public function destroy(FeeType $fee)
    {
        $fee->delete();
        return redirect()->route('fees.index')->with('success', 'Fee Type deleted successfully.');
    }

    public function confirmDelete(FeeType $fee)
    {
        return view('admin.fees.delete', compact('fee'));
    }

    public function assign()
    {
        $feeTypes = FeeType::where('is_active', true)->get();
        $classes = ClassRoom::where('is_active', true)->get();
        // Fixed: Removed is_active check if column missing, or ensure it exists.
        // Assuming Student has is_active or we filter by user->is_active? 
        // For now, removing is_active check on Student model to match current schema
        $students = Student::orderBy('name')->get();
        return view('admin.fees.assign', compact('feeTypes', 'classes', 'students'));
    }

    public function storeAssignment(Request $request)
    {
        $request->validate([
            'fee_type_id' => 'required|exists:fee_types,id',
            'class_id' => 'nullable|exists:classes,id',
            'student_id' => 'nullable|exists:students,id',
            'due_date' => 'required|date',
            'academic_year' => 'nullable|string',
            'term' => 'nullable|string',
        ]);

        if (!$request->class_id && !$request->student_id) {
            return back()->withErrors(['message' => 'Please select either a Class or a specific Student.']);
        }

        $count = 0;
        $data = $request->only(['due_date', 'academic_year', 'term']);

        // Logic for Bulk Assignment (Class)
        if ($request->class_id) {
            $count = $this->feeService->assignToClass($request->class_id, $request->fee_type_id, $data);
        }
        // Logic for Individual Assignment
        elseif ($request->student_id) {
            $assigned = $this->feeService->assignToStudent($request->student_id, $request->fee_type_id, $data);
            if ($assigned)
                $count = 1;
        }

        return redirect()->route('fees.index')->with('success', "$count students invoiced successfully.");
    }

    public function collect(Request $request)
    {
        $students = Student::orderBy('name')->get();
        $selectedStudent = null;
        $fees = collect();
        $payments = collect();

        if ($request->student_id) {
            $selectedStudent = Student::findOrFail($request->student_id);
            $data = $this->feeService->getStudentCollectionData($request->student_id);
            $fees = $data['fees'];
            $payments = $data['payments'];
        }

        return view('admin.fees.collect', compact('students', 'selectedStudent', 'fees', 'payments'));
    }

    public function storePayment(Request $request)
    {
        $request->validate([
            'student_fee_id' => 'required|exists:student_fees,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
            'remarks' => 'nullable|string',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Handle File Upload
        $proofPath = null;
        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('payments', 'public');
        }

        $paymentData = $request->only(['amount', 'payment_method', 'remarks']) + ['payment_proof' => $proofPath];

        try {
            $payment = $this->feeService->recordPayment($request->student_fee_id, $paymentData);
            return redirect()->route('fees.collect', ['student_id' => $payment->studentFee->student_id])
                ->with('success', "Payment of ₦" . number_format($request->amount, 2) . " recorded successfully.");

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function receipt(Payment $payment)
    {
        $payment->load(['studentFee.student', 'studentFee.feeType', 'receiver']);
        return view('admin.fees.receipt', compact('payment'));
    }

    public function report(Request $request)
    {
        $classRooms = ClassRoom::where('is_active', true)->get();
        $feeTypes = FeeType::where('is_active', true)->get();
        $students = Student::orderBy('name')->get();

        $filters = $request->only(['student_id', 'class_id', 'fee_type_id', 'status']);
        $data = $this->feeService->getReportData($filters);

        return view('admin.fees.report', array_merge(compact('classRooms', 'feeTypes', 'students'), $data));
    }
}
