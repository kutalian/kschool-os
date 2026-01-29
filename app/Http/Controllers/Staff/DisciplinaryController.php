<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\DisciplinaryRecord;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisciplinaryController extends Controller
{
    public function index()
    {
        $records = DisciplinaryRecord::where('reported_by', Auth::id())
            ->with('student.user')
            ->latest()
            ->paginate(10);

        return view('staff.disciplinary.index', compact('records'));
    }

    public function create()
    {
        $students = Student::where('is_active', true)->with('user')->get();
        return view('staff.disciplinary.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'incident_date' => 'required|date',
            'incident_type' => 'required|string|max:100',
            'description' => 'required|string',
        ]);

        $data = $request->all();
        $data['reported_by'] = Auth::id();

        DisciplinaryRecord::create($data);

        return redirect()->route('staff.disciplinary.index')->with('success', 'Disciplinary incident reported successfully.');
    }

    public function show(DisciplinaryRecord $disciplinary)
    {
        if ($disciplinary->reported_by !== Auth::id()) {
            abort(403);
        }

        $disciplinary->load('student.user');
        return view('staff.disciplinary.show', compact('disciplinary'));
    }
}
