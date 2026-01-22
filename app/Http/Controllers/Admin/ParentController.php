<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentParent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ParentController extends Controller
{
    public function index()
    {
        $parents = StudentParent::with(['user', 'students'])->latest()->paginate(10);
        return view('admin.parents.index', compact('parents'));
    }

    public function create()
    {
        return view('admin.parents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'primary_phone' => 'required|string|max:20',
            'address' => 'nullable|string',

            // Father Details
            'father_name' => 'nullable|string|max:100',
            'father_phone' => 'nullable|string|max:20',
            'father_occupation' => 'nullable|string|max:100',

            // Mother Details
            'mother_name' => 'nullable|string|max:100',
            'mother_phone' => 'nullable|string|max:20',
            'mother_occupation' => 'nullable|string|max:100',

            // Guardian Details
            'guardian_name' => 'nullable|string|max:100',
            'guardian_relation' => 'nullable|string|max:50',
            'guardian_phone' => 'nullable|string|max:20',
        ]);

        // Create User for Parent
        $user = User::create([
            'username' => 'parent.' . strtolower(Str::random(6)),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make('password'),
            'role' => 'parent',
        ]);

        // Create Parent Profile
        StudentParent::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'], // Assuming this maps to a generic phone or keeping for backward compat
            'primary_phone' => $validated['primary_phone'],
            'address' => $validated['address'],
            'father_name' => $validated['father_name'],
            'father_phone' => $validated['father_phone'],
            'father_occupation' => $validated['father_occupation'],
            'mother_name' => $validated['mother_name'],
            'mother_phone' => $validated['mother_phone'],
            'mother_occupation' => $validated['mother_occupation'],
            'guardian_name' => $validated['guardian_name'],
            'guardian_relation' => $validated['guardian_relation'],
            'guardian_phone' => $validated['guardian_phone'],
        ]);

        return redirect()->route('parents.index')->with('success', 'Parent added successfully.');
    }

    public function edit(StudentParent $parent)
    {
        return view('admin.parents.edit', compact('parent'));
    }

    public function update(Request $request, StudentParent $parent)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('users')->ignore($parent->user_id)],
            'phone' => 'nullable|string|max:20',
            'primary_phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'father_name' => 'nullable|string|max:100',
            'father_phone' => 'nullable|string|max:20',
            'father_occupation' => 'nullable|string|max:100',
            'mother_name' => 'nullable|string|max:100',
            'mother_phone' => 'nullable|string|max:20',
            'mother_occupation' => 'nullable|string|max:100',
            'guardian_name' => 'nullable|string|max:100',
            'guardian_relation' => 'nullable|string|max:50',
            'guardian_phone' => 'nullable|string|max:20',
        ]);

        if ($parent->user) {
            $parent->user->update([
                'name' => $validated['name'],
                'email' => $validated['email']
            ]);
        }

        $parent->update($validated);

        return redirect()->route('parents.index')->with('success', 'Parent updated successfully.');
    }

    public function show(StudentParent $parent)
    {
        $parent->load(['user', 'students.class_room']);
        return view('admin.parents.show', compact('parent'));
    }

    public function confirmDelete(StudentParent $parent)
    {
        // Check linked students
        $studentsCount = $parent->students()->count();

        return view('admin.parents.delete', compact('parent', 'studentsCount'));
    }

    public function destroy(StudentParent $parent)
    {
        // Check if has students
        if ($parent->students()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete parent with associated students.');
        }

        if ($parent->user) {
            $parent->user->delete();
        }
        $parent->delete();
        return redirect()->route('parents.index')->with('success', 'Parent deleted.');
    }
}
