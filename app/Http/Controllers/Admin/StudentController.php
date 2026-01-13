<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\User;
use App\Models\TransportRoute; // Added Import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        // Eager load transportRoute
        $students = Student::with(['class_room', 'parent', 'user', 'transportRoute'])->latest()->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $classes = ClassRoom::where('is_active', true)->get();
        $parents = StudentParent::select('id', 'name', 'phone', 'email')->get();
        $transportRoutes = TransportRoute::all(); // Fetch Routes
        return view('admin.students.create', compact('classes', 'parents', 'transportRoutes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Student Info
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'nullable|email|unique:users,email',
            'class_id' => 'required|exists:classes,id',
            'transport_route_id' => 'nullable|exists:school_transport_routes,id', // Updated table name
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'blood_group' => 'nullable|string|max:10',
            'nationality' => 'required|string|max:100',
            'religion' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:50',
            'roll_no' => 'nullable|string|max:50',

            // Contact & Address
            'phone' => 'nullable|string|max:20',
            'current_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',

            // Emergency Contact
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_number' => 'nullable|string|max:20',

            // Medical Info
            'allergies' => 'nullable|string',
            'medications' => 'nullable|string',

            // Previous School
            'prev_school_name' => 'nullable|string|max:255',
            'prev_school_tc_no' => 'nullable|string|max:100',

            // Parent Info
            'parent_choice' => 'required|in:new,existing',
            'parent_id' => 'required_if:parent_choice,existing|nullable|exists:parents,id',
            'parent_name' => 'required_if:parent_choice,new|nullable|string|max:100',
            'parent_email' => 'required_if:parent_choice,new|nullable|email|unique:users,email',
            'parent_phone' => 'required_if:parent_choice,new|nullable|string|max:20',
        ]);

        // Auto-Generate Admission No: ST-{YEAR}-{SEQ}
        $year = date('Y');
        $lastStudent = Student::latest('id')->first();
        $sequence = $lastStudent ? $lastStudent->id + 1 : 1;
        $admissionNo = 'ST' . $year . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        $username = $admissionNo;

        // Create Student User
        $studentUser = User::create([
            'username' => $username,
            'email' => $validated['email'] ?? null,
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        // Handle Parent
        if ($request->parent_choice === 'new') {
            // Create Parent User
            $parentUser = User::create([
                'username' => 'P' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
                'email' => $validated['parent_email'],
                'password' => Hash::make('password'),
                'role' => 'parent',
            ]);

            $parent = StudentParent::create([
                'user_id' => $parentUser->id,
                'name' => $validated['parent_name'],
                'email' => $validated['parent_email'],
                'phone' => $validated['parent_phone'],
            ]);
            $parentId = $parent->id;
        } else {
            $parentId = $validated['parent_id'];
        }

        // Create Student Profile
        Student::create([
            'user_id' => $studentUser->id,
            'admission_no' => $admissionNo,
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'] ?? null,
            'class_id' => $validated['class_id'],
            'parent_id' => $parentId,
            'transport_route_id' => $validated['transport_route_id'] ?? null, // Added
            'dob' => $validated['dob'],
            'gender' => $validated['gender'],
            'blood_group' => $validated['blood_group'] ?? null,
            'nationality' => $validated['nationality'],
            'religion' => $validated['religion'] ?? null,
            'category' => $validated['category'] ?? null,
            'roll_no' => $validated['roll_no'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'current_address' => $validated['current_address'] ?? null,
            'permanent_address' => $validated['permanent_address'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'country' => $validated['country'],
            'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
            'emergency_contact_number' => $validated['emergency_contact_number'] ?? null,
            'allergies' => $validated['allergies'] ?? null,
            'medications' => $validated['medications'] ?? null,
            'prev_school_name' => $validated['prev_school_name'] ?? null,
            'prev_school_tc_no' => $validated['prev_school_tc_no'] ?? null,
            'admission_date' => now(),
            'is_active' => true,
        ]);

        return redirect()->route('students.index')->with('success', "Student admitted successfully. Login ID: $username");
    }

    public function edit(Student $student)
    {
        $classes = ClassRoom::all();
        $parents = StudentParent::select('id', 'name', 'phone', 'email')->get();
        $transportRoutes = TransportRoute::all(); // Fetch Routes
        return view('admin.students.edit', compact('student', 'classes', 'parents', 'transportRoutes'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => ['nullable', 'email', Rule::unique('users')->ignore($student->user_id)],
            'class_id' => 'required|exists:classes,id',
            'transport_route_id' => 'nullable|exists:school_transport_routes,id', // Updated table name
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'blood_group' => 'nullable|string|max:10',
            'nationality' => 'required|string|max:100',
            'religion' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:50',
            'roll_no' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'current_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_number' => 'nullable|string|max:20',
            'allergies' => 'nullable|string',
            'medications' => 'nullable|string',
            'prev_school_name' => 'nullable|string|max:255',
            'prev_school_tc_no' => 'nullable|string|max:100',
            'parent_id' => 'nullable|exists:parents,id',
        ]);

        // Update User 
        if ($student->user) {
            $student->user->update([
                'email' => $validated['email'] ?? null,
            ]);
        }

        $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];
        unset($validated['first_name'], $validated['last_name']);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function show(Student $student)
    {
        $student->load(['class_room', 'parent', 'user', 'attendance', 'marks.exam', 'marks.subject']);

        $totalDays = $student->attendance->count();
        $presentDays = $student->attendance->where('status', 'Present')->count();
        $attendancePercentage = $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 1) : 0;

        $examResults = $student->marks->groupBy(function ($mark) {
            return $mark->exam->name;
        });

        return view('admin.students.show', compact('student', 'totalDays', 'presentDays', 'attendancePercentage', 'examResults'));
    }

    public function confirmDelete(Student $student)
    {
        $attendanceCount = \App\Models\Attendance::where('student_id', $student->id)->count();
        return view('admin.students.delete', compact('student', 'attendanceCount'));
    }

    public function destroy(Student $student)
    {
        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($student) {
                $student->attendance()->delete();
                if ($student->user) {
                    $student->user->delete();
                }
                if ($student->exists) {
                    $student->delete();
                }
            });

            return redirect()->route('students.index')->with('success', 'Student and all related records deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('students.index')->with('error', 'Failed to delete student: ' . $e->getMessage());
        }
    }
}
