<?php

namespace App\Http\Controllers\Student;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentFee;

class FeeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            abort(403, 'Student profile not found.');
        }

        $fees = StudentFee::where('student_id', $student->id)
            ->with(['feeType', 'payments'])
            ->orderBy('due_date', 'asc')
            ->get();

        return view('student.fees.index', compact('student', 'fees'));
    }
}
