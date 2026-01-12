<x-master-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Staff Member</h1>
        <p class="text-gray-500">Update staff profile for {{ $staff->name }}</p>
    </div>

    <form action="{{ route('staff.update', $staff->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Personal Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Personal Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $staff->name) }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Email -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $staff->email) }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Phone -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $staff->phone) }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Gender -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Gender</label>
                    <select name="gender" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                        <option value="Male" {{ old('gender', $staff->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $staff->gender) == 'Female' ? 'selected' : '' }}>Female
                        </option>
                        <option value="Other" {{ old('gender', $staff->gender) == 'Other' ? 'selected' : '' }}>Other
                        </option>
                    </select>
                </div>
                <!-- DOB -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Date of Birth</label>
                    <input type="date" name="dob"
                        value="{{ old('dob', $staff->dob ? $staff->dob->format('Y-m-d') : '') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('dob') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Job Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Employment Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Employee ID -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Employee ID</label>
                    <input type="text" name="employee_id" value="{{ old('employee_id', $staff->employee_id) }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('employee_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Role -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                    <select name="role_type" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                        <option value="Teacher" {{ old('role_type', $staff->role_type) == 'Teacher' ? 'selected' : '' }}>
                            Teacher</option>
                        <option value="Admin" {{ old('role_type', $staff->role_type) == 'Admin' ? 'selected' : '' }}>Admin
                        </option>
                        <option value="Support" {{ old('role_type', $staff->role_type) == 'Support' ? 'selected' : '' }}>
                            Support Staff</option>
                        <option value="Management" {{ old('role_type', $staff->role_type) == 'Management' ? 'selected' : '' }}>Management</option>
                        <option value="Librarian" {{ old('role_type', $staff->role_type) == 'Librarian' ? 'selected' : '' }}>Librarian</option>
                        <option value="Security" {{ old('role_type', $staff->role_type) == 'Security' ? 'selected' : '' }}>Security</option>
                    </select>
                    @error('role_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Department -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Department</label>
                    <input type="text" name="department" value="{{ old('department', $staff->department) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition"
                        placeholder="e.g. Science">
                </div>
                <!-- Designation -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Designation</label>
                    <input type="text" name="designation" value="{{ old('designation', $staff->designation) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition"
                        placeholder="e.g. Senior Teacher">
                </div>
                <!-- Joining Date -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Joining Date</label>
                    <input type="date" name="joining_date"
                        value="{{ old('joining_date', $staff->joining_date ? $staff->joining_date->format('Y-m-d') : '') }}"
                        required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('joining_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Experience -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Experience (Years)</label>
                    <input type="number" name="experience_years"
                        value="{{ old('experience_years', $staff->experience_years) }}" required min="0"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <!-- Qualification -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Qualification</label>
                    <input type="text" name="qualification" value="{{ old('qualification', $staff->qualification) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>

                <!-- Active Status -->
                <div class="md:col-span-2">
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" name="is_active" value="1" {{ $staff->is_active ? 'checked' : '' }}
                            class="form-checkbox h-5 w-5 text-blue-600 rounded">
                        <span class="text-gray-700 font-medium">Account Active</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Payroll & Banking -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Payroll & Banking</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Salary -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Basic Salary</label>
                    <input type="number" name="basic_salary" value="{{ old('basic_salary', $staff->basic_salary) }}"
                        min="0" step="0.01"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <!-- Bank Name -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Bank Name</label>
                    <input type="text" name="bank_name" value="{{ old('bank_name', $staff->bank_name) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <!-- Account Number -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Account Number</label>
                    <input type="text" name="bank_account_no"
                        value="{{ old('bank_account_no', $staff->bank_account_no) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <!-- Bank Code -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Bank Code / IFSC</label>
                    <input type="text" name="bank_code" value="{{ old('bank_code', $staff->bank_code) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('staff.index') }}"
                class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition font-medium">Cancel</a>
            <button type="submit"
                class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium shadow-sm">Update
                Staff Member</button>
        </div>
    </form>
</x-master-layout>