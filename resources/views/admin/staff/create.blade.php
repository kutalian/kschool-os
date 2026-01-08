<x-master-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Add New Staff Member</h1>
        <p class="text-gray-500">Create a new staff profile including teachers and support staff.</p>
    </div>

    <form action="{{ route('staff.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- 1. Personal Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Personal Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Full Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email <span
                            class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Phone <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Gender <span
                            class="text-red-500">*</span></label>
                    <select name="gender" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
            </div>
        </div>

        <!-- 2. Address & Emergency -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Address & Emergency</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">City</label>
                    <input type="text" name="city" value="{{ old('city') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">State</label>
                    <input type="text" name="state" value="{{ old('state') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Country <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="country" value="{{ old('country', 'Nigeria') }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div class="md:col-span-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Current Address</label>
                    <textarea name="current_address" rows="1"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">{{ old('current_address') }}</textarea>
                </div>
                <div class="md:col-span-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Permanent Address</label>
                    <textarea name="permanent_address" rows="1"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">{{ old('permanent_address') }}</textarea>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Emergency Contact Name</label>
                    <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Emergency Contact Number</label>
                    <input type="text" name="emergency_contact_number" value="{{ old('emergency_contact_number') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
            </div>
        </div>

        <!-- 3. Job & Qualification -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Job & Qualification</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Role <span
                            class="text-red-500">*</span></label>
                    <select name="role_type" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                        <option value="Teacher" {{ old('role_type') == 'Teacher' ? 'selected' : '' }}>Teacher</option>
                        <option value="Admin" {{ old('role_type') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Support" {{ old('role_type') == 'Support' ? 'selected' : '' }}>Support</option>
                        <option value="Management" {{ old('role_type') == 'Management' ? 'selected' : '' }}>Management
                        </option>
                        <option value="Security" {{ old('role_type') == 'Security' ? 'selected' : '' }}>Security</option>
                        <option value="Nurse" {{ old('role_type') == 'Nurse' ? 'selected' : '' }}>Nurse</option>
                        <option value="Librarian" {{ old('role_type') == 'Librarian' ? 'selected' : '' }}>Librarian
                        </option>
                        <option value="Other" {{ old('role_type') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Department</label>
                    <input type="text" name="department" value="{{ old('department') }}" placeholder="e.g. Science"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Designation</label>
                    <input type="text" name="designation" value="{{ old('designation') }}"
                        placeholder="e.g. Senior Teacher"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Employment Type <span
                            class="text-red-500">*</span></label>
                    <select name="employment_type" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                        <option value="Permanent" {{ old('employment_type') == 'Permanent' ? 'selected' : '' }}>Permanent
                        </option>
                        <option value="Contract" {{ old('employment_type') == 'Contract' ? 'selected' : '' }}>Contract
                        </option>
                        <option value="Part-Time" {{ old('employment_type') == 'Part-Time' ? 'selected' : '' }}>Part-Time
                        </option>
                        <option value="Temporary" {{ old('employment_type') == 'Temporary' ? 'selected' : '' }}>Temporary
                        </option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Joining Date <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="joining_date" value="{{ old('joining_date') }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Experience (Years) <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="experience_years" value="{{ old('experience_years', 0) }}" required
                        min="0"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Qualification</label>
                    <input type="text" name="qualification" value="{{ old('qualification') }}"
                        placeholder="e.g. B.Ed, MSc"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">University</label>
                    <input type="text" name="university" value="{{ old('university') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Specialization</label>
                    <input type="text" name="specialization" value="{{ old('specialization') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
            </div>
        </div>

        <!-- 4. Payroll & Banking -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Payroll & Banking</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Basic Salary</label>
                    <input type="number" name="basic_salary" value="{{ old('basic_salary') }}" min="0" step="0.01"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Bank Name</label>
                    <input type="text" name="bank_name" value="{{ old('bank_name') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Account Number</label>
                    <input type="text" name="bank_account_no" value="{{ old('bank_account_no') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Bank Code / IFSC</label>
                    <input type="text" name="bank_code" value="{{ old('bank_code') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('staff.index') }}"
                class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition font-medium">Cancel</a>
            <button type="submit"
                class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium shadow-sm">Save
                Staff</button>
        </div>
    </form>
</x-master-layout>