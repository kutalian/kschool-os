<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeType;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\StudentFee;
use App\Models\Payment;
use Illuminate\Http\Request;

class FeeController extends Controller
{
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
        // Fixed: Use 'name' instead of 'first_name' which doesn't exist on students table
        $students = Student::where('is_active', true)->orderBy('name')->get();
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

        $feeType = FeeType::findOrFail($request->fee_type_id);
        $count = 0;

        // Logic for Bulk Assignment (Class)
        if ($request->class_id) {
            $students = Student::where('class_id', $request->class_id)->where('is_active', true)->get();
            foreach ($students as $student) {
                // Check if already assigned
                $exists = StudentFee::where('student_id', $student->id)
                    ->where('fee_type_id', $feeType->id)
                    ->where('academic_year', $request->academic_year)
                    ->where('term', $request->term)
                    ->exists();

                if (!$exists) {
                    StudentFee::create([
                        'student_id' => $student->id,
                        'fee_type_id' => $feeType->id,
                        'amount' => $feeType->amount,
                        'due_date' => $request->due_date,
                        'academic_year' => $request->academic_year,
                        'term' => $request->term,
                        'status' => 'Unpaid'
                    ]);
                    $count++;
                }
            }
        }
        // Logic for Individual Assignment
        elseif ($request->student_id) {
            StudentFee::create([
                'student_id' => $request->student_id,
                'fee_type_id' => $feeType->id,
                'amount' => $feeType->amount,
                'due_date' => $request->due_date,
                'academic_year' => $request->academic_year,
                'term' => $request->term,
                'status' => 'Unpaid'
            ]);
            $count = 1;
        }

        return redirect()->route('fees.index')->with('success', "$count students invoiced successfully.");
    }

    public function collect(Request $request)
    {
        $students = Student::where('is_active', true)->orderBy('name')->get();
        $selectedStudent = null;
        $fees = collect();

        if ($request->student_id) {
            $selectedStudent = Student::findOrFail($request->student_id);
            $fees = StudentFee::where('student_id', $selectedStudent->id)
                ->whereIn('status', ['Unpaid', 'Partial'])
                ->with('feeType')
                ->get();

            $payments = Payment::whereHas('studentFee', function ($q) use ($selectedStudent) {
                $q->where('student_id', $selectedStudent->id);
            })->with(['studentFee.feeType'])->orderBy('payment_date', 'desc')->get();
        } else {
            $payments = collect();
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

        $fee = StudentFee::findOrFail($request->student_fee_id);

        // Calculate remaining balance
        $remaining = $fee->amount - $fee->paid;

        if ($request->amount > $remaining) {
            return back()->with('error', "Payment amount cannot exceed remaining balance of ₦" . number_format($remaining, 2));
        }

        // Handle File Upload
        $proofPath = null;
        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('payments', 'public');
        }

        // Record Payment
        Payment::create([
            'student_fee_id' => $fee->id,
            'amount' => $request->amount,
            'payment_date' => now(),
            'payment_method' => $request->payment_method,
            'received_by' => auth()->id(),
            'remarks' => $request->remarks,
            'payment_proof' => $proofPath,
            'status' => 'Approved'
        ]);

        // Update Fee Status
        $fee->paid += $request->amount;
        if ($fee->paid >= $fee->amount) {
            $fee->status = 'Paid';
        } else {
            $fee->status = 'Partial';
        }
        $fee->save();

        return redirect()->route('fees.collect', ['student_id' => $fee->student_id])
            ->with('success', "Payment of ₦" . number_format($request->amount, 2) . " recorded successfully.");
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
        $students = Student::where('is_active', true)->orderBy('name')->get();

        $query = StudentFee::query();

        // Filters
        if ($request->student_id) {
            $query->where('student_id', $request->student_id);
        } elseif ($request->class_id) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('class_id', $request->class_id);
            });
        }
        if ($request->fee_type_id) {
            $query->where('fee_type_id', $request->fee_type_id);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Clone query for totals to avoid overriding get() later if used
        $totalStats = (clone $query)->selectRaw('
            SUM(amount) as total_expected, 
            SUM(paid) as total_collected
        ')->first();

        $totalExpected = $totalStats->total_expected ?? 0;
        $totalCollected = $totalStats->total_collected ?? 0;
        $totalPending = $totalExpected - $totalCollected;

        // Get Paginated Records
        $studentFees = $query->with(['student.classRoom', 'feeType'])
            ->orderBy('due_date', 'asc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.fees.report', compact('classRooms', 'feeTypes', 'students', 'studentFees', 'totalExpected', 'totalCollected', 'totalPending'));
    }
}
