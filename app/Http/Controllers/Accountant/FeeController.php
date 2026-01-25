<?php

namespace App\Http\Controllers\Accountant;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeeType;
use App\Models\Student;
use App\Models\StudentFee;

class FeeController extends Controller
{
    public function index()
    {
        $feeTypes = FeeType::all();
        $recentInvoices = StudentFee::with(['student', 'feeType'])->latest()->take(10)->get();
        return view('accountant.fees.index', compact('feeTypes', 'recentInvoices'));
    }

    public function create()
    {
        return view('accountant.fees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'frequency' => 'required|in:One-Time,Monthly,Quarterly,Annually',
        ]);

        FeeType::create($validated);

        return redirect()->route('accountant.fees.index')->with('success', 'Fee Type created successfully.');
    }

    // Method to show Assign Fee form
    public function assign()
    {
        $students = Student::all(); // Ideally AJAX
        $feeTypes = FeeType::where('is_active', true)->get();
        return view('accountant.fees.assign', compact('students', 'feeTypes'));
    }

    // Method to store assigned fee
    public function storeAssign(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        $feeType = FeeType::find($request->fee_type_id);

        StudentFee::create([
            'student_id' => $request->student_id,
            'fee_type_id' => $feeType->id,
            'amount' => $feeType->amount, // Default to fee type amount
            'due_date' => $request->due_date,
            'status' => 'Unpaid',
            // 'academic_year' => ... (Could add if needed)
        ]);

        return redirect()->route('accountant.fees.index')->with('success', 'Fee assigned to student successfully.');
    }
}
