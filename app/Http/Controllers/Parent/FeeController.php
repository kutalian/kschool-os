<?php

namespace App\Http\Controllers\Parent;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\StudentFee;

class FeeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $parent = $user->parent;

        if (!$parent) {
            abort(403, 'Parent profile not found.');
        }

        $children = $parent->students;

        return view('parent.fees.index', compact('children'));
    }

    public function show($studentId)
    {
        $user = Auth::user();
        $parent = $user->parent;

        if (!$parent) {
            abort(403, 'Parent profile not found.');
        }

        $student = Student::where('id', $studentId)->where('parent_id', $parent->id)->firstOrFail();

        $fees = StudentFee::where('student_id', $student->id)
            ->with(['feeType', 'payments'])
            ->orderBy('due_date', 'asc')
            ->get();

        return view('parent.fees.show', compact('student', 'fees'));
    }
}
