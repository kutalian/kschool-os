<x-master-layout>
    <div class="container mx-auto px-4 py-6">

        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex justify-between items-center">
            <div class="flex items-center">
                <div
                    class="h-20 w-20 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 text-3xl font-bold mr-6">
                    {{ substr($staff->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $staff->name }}</h1>
                    <p class="text-gray-500 mt-1">
                        <span class="mr-4"><i class="fas fa-id-badge mr-2"></i>{{ $staff->employee_id }}</span>
                        <span class="mr-4"><i
                                class="fas fa-briefcase mr-2"></i>{{ $staff->designation ?? $staff->role_type }}</span>
                        <span><i class="fas fa-building mr-2"></i>{{ $staff->department ?? 'General' }}</span>
                    </p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('staff.edit', $staff->id) }}"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-edit mr-2"></i> Edit Profile
                </a>
                <a href="{{ route('staff.index') }}"
                    class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Column: Personal & Contact Info -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Personal Details -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Personal Details</h3>
                    <div class="space-y-3">
                        <p class="text-sm"><span class="block text-gray-400 text-xs">Date of Birth</span>
                            {{ $staff->dob ? \Carbon\Carbon::parse($staff->dob)->format('d M, Y') : 'N/A' }}</p>
                        <p class="text-sm"><span class="block text-gray-400 text-xs">Gender</span>
                            {{ ucfirst($staff->gender) }}</p>
                        <p class="text-sm"><span class="block text-gray-400 text-xs">Joined On</span>
                            {{ \Carbon\Carbon::parse($staff->joining_date)->format('d M, Y') }}</p>
                        <p class="text-sm"><span class="block text-gray-400 text-xs">Employment Type</span>
                            {{ $staff->employment_type }}</p>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Contact Info</h3>
                    <div class="space-y-3">
                        <p class="text-sm"><span class="block text-gray-400 text-xs">Email</span> {{ $staff->email }}
                        </p>
                        <p class="text-sm"><span class="block text-gray-400 text-xs">Phone</span> {{ $staff->phone }}
                        </p>
                        <p class="text-sm"><span class="block text-gray-400 text-xs">Current Address</span>
                            {{ $staff->current_address ?? 'N/A' }}</p>
                        <p class="text-sm"><span class="block text-gray-400 text-xs">Permanent Address</span>
                            {{ $staff->permanent_address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Professional Details -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Qualification & Experience -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Professional Overview</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm mb-2"><span
                                    class="text-gray-400 text-xs uppercase tracking-wide">Qualification</span></p>
                            <p class="font-medium">{{ $staff->qualification ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm mb-2"><span
                                    class="text-gray-400 text-xs uppercase tracking-wide">University/College</span></p>
                            <p class="font-medium">{{ $staff->university ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm mb-2"><span
                                    class="text-gray-400 text-xs uppercase tracking-wide">Specialization</span></p>
                            <p class="font-medium">{{ $staff->specialization ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm mb-2"><span
                                    class="text-gray-400 text-xs uppercase tracking-wide">Experience</span></p>
                            <p class="font-medium text-green-600">{{ $staff->experience_years }} Years</p>
                        </div>
                    </div>
                </div>

                <!-- Financial Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-coins text-yellow-500 mr-2"></i> Financial Details
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase">Basic Salary</p>
                            <p class="text-xl font-bold text-gray-800">${{ number_format($staff->basic_salary, 2) }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase">Bank Name</p>
                            <p class="font-semibold text-gray-800">{{ $staff->bank_name ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase">Account No</p>
                            <p class="font-semibold text-gray-800 font-mono">{{ $staff->bank_account_no ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Assigned Classes -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Assigned Classes (Class Teacher)</h3>
                    @if($assignedClasses->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($assignedClasses as $class)
                                <div
                                    class="border rounded-lg p-4 hover:shadow-md transition text-center bg-blue-50 border-blue-100">
                                    <h4 class="text-xl font-bold text-blue-800">{{ $class->name }}</h4>
                                    <p class="text-sm text-blue-600">Section {{ $class->section }}</p>
                                    <a href="{{ route('classes.edit', $class->id) }}"
                                        class="mt-2 text-xs text-blue-500 hover:text-blue-700 underline block">View Class</a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6 text-gray-400">
                            <p class="italic">Not assigned as Class Teacher for any class.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-master-layout>