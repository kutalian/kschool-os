<?php

namespace App\Services;

use App\Models\FeeType;
use App\Models\Student;
use App\Models\StudentFee;
use App\Models\Payment;
use App\Models\ClassRoom;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FeeService
{
    /**
     * Assign a fee type to all students in a class.
     */
    public function assignToClass(int $classId, int $feeTypeId, array $data): int
    {
        $feeType = FeeType::findOrFail($feeTypeId);
        // Assuming all students in class are valid targets. If needs active, check user->is_active
        $students = Student::where('class_id', $classId)->get();
        $count = 0;

        foreach ($students as $student) {
            $assigned = $this->assignFeeToStudent($student->id, $feeTypeId, $data);
            if ($assigned) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Assign a fee type to a specific student.
     * Returns the created StudentFee or null if already exists.
     */
    public function assignToStudent(int $studentId, int $feeTypeId, array $data): ?StudentFee
    {
        return $this->assignFeeToStudent($studentId, $feeTypeId, $data);
    }

    /**
     * Internal helper to handle the actual creation with duplication check.
     */
    protected function assignFeeToStudent(int $studentId, int $feeTypeId, array $data): ?StudentFee
    {
        $feeType = FeeType::find($feeTypeId);
        if (!$feeType)
            return null;

        // Check for duplicates
        $exists = StudentFee::where('student_id', $studentId)
            ->where('fee_type_id', $feeTypeId)
            ->where('academic_year', $data['academic_year'] ?? null)
            ->where('term', $data['term'] ?? null)
            ->exists();

        if ($exists) {
            return null;
        }

        return StudentFee::create([
            'student_id' => $studentId,
            'fee_type_id' => $feeTypeId,
            'amount' => $feeType->amount,
            'due_date' => $data['due_date'],
            'academic_year' => $data['academic_year'] ?? null,
            'term' => $data['term'] ?? null,
            'status' => 'Unpaid'
        ]);
    }

    /**
     * Get fees and payments for a specific student for collection view.
     */
    public function getStudentCollectionData(int $studentId): array
    {
        $fees = StudentFee::where('student_id', $studentId)
            ->whereIn('status', ['Unpaid', 'Partial'])
            ->with('feeType')
            ->get();

        $payments = Payment::whereHas('studentFee', function ($q) use ($studentId) {
            $q->where('student_id', $studentId);
        })->with(['studentFee.feeType'])->orderBy('payment_date', 'desc')->get();

        return compact('fees', 'payments');
    }

    /**
     * Record a payment for a student fee.
     * Throws exception if amount is invalid.
     */
    public function recordPayment(int $studentFeeId, array $data): Payment
    {
        $fee = StudentFee::findOrFail($studentFeeId);

        // Calculate remaining balance
        $remaining = $fee->amount - $fee->paid;

        if ($data['amount'] > $remaining) {
            throw new \Exception("Payment amount cannot exceed remaining balance of ₦" . number_format($remaining, 2));
        }

        return DB::transaction(function () use ($fee, $data) {
            // Record Payment
            $payment = Payment::create([
                'student_fee_id' => $fee->id,
                'amount' => $data['amount'],
                'payment_date' => now(),
                'payment_method' => $data['payment_method'],
                'received_by' => auth()->id(), // Assuming auth context is available or passed
                'remarks' => $data['remarks'] ?? null,
                'payment_proof' => $data['payment_proof'] ?? null,
                'status' => 'Approved'
            ]);

            // Update Fee Status
            $fee->paid += $data['amount'];
            if ($fee->paid >= $fee->amount) {
                $fee->status = 'Paid';
            } else {
                $fee->status = 'Partial';
            }
            $fee->save();

            return $payment;
        });
    }

    /**
     * Get data for fee reports with filtering and totals.
     */
    public function getReportData(array $filters): array
    {
        $query = StudentFee::query();

        // Filters
        if (!empty($filters['student_id'])) {
            $query->where('student_id', $filters['student_id']);
        } elseif (!empty($filters['class_id'])) {
            $query->whereHas('student', function ($q) use ($filters) {
                $q->where('class_id', $filters['class_id']);
            });
        }

        if (!empty($filters['fee_type_id'])) {
            $query->where('fee_type_id', $filters['fee_type_id']);
        }
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Clone query for totals
        $totalStats = (clone $query)->selectRaw('
            SUM(amount) as total_expected, 
            SUM(paid) as total_collected
        ')->first();

        $totalExpected = $totalStats->total_expected ?? 0;
        $totalCollected = $totalStats->total_collected ?? 0;
        $totalPending = $totalExpected - $totalCollected;

        // Get Paginated Records
        $studentFees = $query->with(['student.class_room', 'feeType'])
            ->orderBy('due_date', 'asc')
            ->paginate(15)
            ->withQueryString();

        return compact('studentFees', 'totalExpected', 'totalCollected', 'totalPending');
    }
}
