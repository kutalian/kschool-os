<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::with('user')->latest()->paginate(10);
        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Personal
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            // 'employee_id' removed from validation
            'gender' => 'required|in:Male,Female,Other',
            'dob' => 'nullable|date',

            // Job
            'role_type' => 'required|in:Teacher,Admin,Support,Management,Security,Nurse,Librarian,Other',
            'joining_date' => 'required|date',
            'department' => 'nullable|string|max:100',
            'designation' => 'nullable|string|max:100',
            'qualification' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'university' => 'nullable|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'employment_type' => 'required|in:Permanent,Contract,Part-Time,Temporary',

            // Financial
            'basic_salary' => 'nullable|numeric|min:0',
            'bank_name' => 'nullable|string|max:100',
            'bank_account_no' => 'nullable|string|max:50',
            'bank_code' => 'nullable|string|max:20',

            // Address & Emergency
            'current_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_number' => 'nullable|string|max:20',
        ]);

        // Auto-Generate Employee ID: EMP-{Year}-{Seq}
        $lastStaff = Staff::latest('id')->first();
        $seq = $lastStaff ? $lastStaff->id + 1 : 1;
        $employeeId = 'EMP' . date('Y') . str_pad($seq, 3, '0', STR_PAD_LEFT);

        // Generate Username for Staff (Use Employee ID)
        $username = $employeeId;

        // Create User for Staff
        $user = User::create([
            'username' => $username,
            'email' => $validated['email'],
            'password' => Hash::make('password'), // Default password
            'role' => $validated['role_type'] === 'Admin' ? 'admin' : 'staff',
        ]);

        // Create Staff Profile
        Staff::create([
            'user_id' => $user->id,
            'employee_id' => $employeeId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role_type' => $validated['role_type'],
            'dob' => $validated['dob'],
            'gender' => $validated['gender'],
            'joining_date' => $validated['joining_date'],
            'department' => $validated['department'],
            'designation' => $validated['designation'],
            'qualification' => $validated['qualification'],
            'specialization' => $validated['specialization'] ?? null,
            'university' => $validated['university'] ?? null,
            'experience_years' => $validated['experience_years'],
            'employment_type' => $validated['employment_type'],
            'basic_salary' => $validated['basic_salary'] ?? null,
            'bank_name' => $validated['bank_name'] ?? null,
            'bank_account_no' => $validated['bank_account_no'] ?? null,
            'bank_code' => $validated['bank_code'] ?? null,
            'current_address' => $validated['current_address'] ?? null,
            'permanent_address' => $validated['permanent_address'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'country' => $validated['country'],
            'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
            'emergency_contact_number' => $validated['emergency_contact_number'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff member added successfully.');
    }

    public function edit(Staff $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('users')->ignore($staff->user_id)],
            'phone' => 'required|string|max:20',
            'employee_id' => ['required', 'string', Rule::unique('staff')->ignore($staff->id)],
            'role_type' => 'required|in:Teacher,Admin,Support,Management,Security,Nurse,Librarian,Other',
            'gender' => 'required|in:Male,Female,Other',
            'dob' => 'nullable|date',
            'joining_date' => 'required|date',
            'department' => 'nullable|string|max:100',
            'designation' => 'nullable|string|max:100',
            'qualification' => 'nullable|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'employment_type' => 'required|in:Permanent,Contract,Part-Time,Temporary',

            // New Fields
            'specialization' => 'nullable|string|max:255',
            'university' => 'nullable|string|max:255',
            'basic_salary' => 'nullable|numeric|min:0',
            'bank_name' => 'nullable|string|max:100',
            'bank_account_no' => 'nullable|string|max:50',
            'bank_code' => 'nullable|string|max:20',
            'current_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_number' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        // Update User email if changed
        if ($staff->user && $staff->user->email !== $validated['email']) {
            $staff->user->update(['email' => $validated['email']]);
        }

        // Update Role if changed to/from Admin
        if ($staff->user) {
            $newRole = $validated['role_type'] === 'Admin' ? 'admin' : 'staff';
            if ($staff->user->role !== $newRole) {
                $staff->user->update(['role' => $newRole]);
            }
        }

        $staff->update($validated + ['is_active' => $request->has('is_active')]);

        return redirect()->route('staff.index')->with('success', 'Staff member updated successfully.');
    }

    public function show(Staff $staff)
    {
        $staff->load('user');

        // Fetch classes where this staff is the class teacher
        $assignedClasses = \App\Models\ClassRoom::where('class_teacher_id', $staff->id)->get();

        return view('admin.staff.show', compact('staff', 'assignedClasses'));
    }

    public function confirmDelete(Staff $staff)
    {
        // Check if teacher for any classes
        $classesCount = \App\Models\ClassRoom::where('class_teacher_id', $staff->id)->count();

        return view('admin.staff.delete', compact('staff', 'classesCount'));
    }

    public function destroy(Staff $staff)
    {
        if ($staff->user) {
            $staff->user->delete();
        }
        $staff->delete();
        return redirect()->back()->with('success', 'Staff member deleted.');
    }
}
