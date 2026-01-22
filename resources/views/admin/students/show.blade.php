<x-master-layout>
    <div class="container mx-auto px-4 py-6">

        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex justify-between items-center">
            <div class="flex items-center">
                <div
                    class="h-20 w-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-3xl font-bold mr-6">
                    {{ substr($student->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $student->name }}</h1>
                    <p class="text-gray-500 mt-1">
                        <span class="mr-4"><i class="fas fa-id-card mr-2"></i>{{ $student->admission_no }}</span>
                        <span class="mr-4"><i
                                class="fas fa-chalkboard mr-2"></i>{{ $student->class_room->name ?? 'N/A' }}</span>
                        <span><i
                                class="fas fa-user-tag mr-2"></i>{{ ucfirst($student->user->role ?? 'Student') }}</span>
                    </p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('students.edit', $student->id) }}"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-edit mr-2"></i> Edit Profile
                </a>
                <a href="{{ route('students.index') }}"
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
                            {{ $student->dob }}</p>
                        <p class="text-sm"><span class="block text-gray-400 text-xs">Gender</span>
                            {{ ucfirst($student->gender) }}</p>
                        <p class="text-sm"><span class="block text-gray-400 text-xs">Nationality</span>
                            {{ $student->nationality }}</p>
                        <p class="text-sm"><span class="block text-gray-400 text-xs">Blood Group</span>
                            {{ $student->blood_group ?? 'N/A' }}</p>
                        <p class="text-sm"><span class="block text-gray-400 text-xs">Religion</span>
                            {{ $student->religion ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Contact Info</h3>
                    <div class="space-y-3">
                        <p class="text-sm"><span class="block text-gray-400 text-xs">Email</span>
                            {{ $student->email ?? 'N/A' }}</p>
                        <p class="text-sm"><span class="block text-gray-400 text-xs">Phone</span>
                            {{ $student->phone ?? 'N/A' }}</p>
                        <p class="text-sm"><span class="block text-gray-400 text-xs">Address</span>
                            {{ $student->current_address ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Parent Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Guardian / Parent</h3>
                    @if($student->parent)
                        <div class="space-y-3">
                            <p class="text-sm"><span class="block text-gray-400 text-xs">Name</span>
                                {{ $student->parent->name }}</p>
                            <p class="text-sm"><span class="block text-gray-400 text-xs">Phone</span>
                                {{ $student->parent->phone }}</p>
                            <p class="text-sm"><span class="block text-gray-400 text-xs">Email</span>
                                {{ $student->parent->email }}</p>
                        </div>
                    @else
                        <p class="text-gray-500 text-sm italic">No parent info linked.</p>
                    @endif
                </div>
            </div>

            <!-- Right Column: Academic & Attendance -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Attendance Stats -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex justify-between items-center">
                        <span>Attendance Overview</span>
                        <span class="text-sm font-normal bg-blue-50 text-blue-600 py-1 px-3 rounded-full">Total Days:
                            {{ $totalDays }}</span>
                    </h3>

                    <div class="flex items-center space-x-6">
                        <!-- Circular Progress Placeholder (using text for now) -->
                        <div
                            class="relative h-24 w-24 rounded-full border-4 border-blue-100 flex items-center justify-center">
                            <div class="text-center">
                                <span class="block text-xl font-bold text-blue-600">{{ $attendancePercentage }}%</span>
                                <span class="text-xs text-gray-400">Present</span>
                            </div>
                        </div>

                        <div class="flex-1 grid grid-cols-2 gap-4">
                            <div class="bg-green-50 p-3 rounded-lg">
                                <span class="block text-2xl font-bold text-green-600">{{ $presentDays }}</span>
                                <span class="text-xs text-green-800">Days Present</span>
                            </div>
                            <div class="bg-red-50 p-3 rounded-lg">
                                <span
                                    class="block text-2xl font-bold text-red-600">{{ $totalDays - $presentDays }}</span>
                                <span class="text-xs text-red-800">Days Absent/Late</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exam Results -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Exam Results</h3>

                    @if($examResults->count() > 0)
                        <div class="space-y-6">
                            @foreach($examResults as $examName => $marks)
                                <div class="border rounded-lg overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-2 font-semibold text-gray-700 flex justify-between">
                                        <span>{{ $examName }}</span>
                                        <span
                                            class="text-sm font-normal text-gray-500">{{ $marks->first()->exam->start_date->format('M Y') }}</span>
                                    </div>
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                    Subject</th>
                                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">
                                                    Marks</th>
                                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">
                                                    Grade</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            @foreach($marks as $mark)
                                                <tr>
                                                    <td class="px-4 py-2 text-sm text-gray-900">
                                                        {{ $mark->subject->name ?? 'Unknown' }}
                                                    </td>
                                                    <td class="px-4 py-2 text-center text-sm font-bold text-gray-900">
                                                        {{ $mark->marks_obtained }} <span class="text-gray-400 font-normal">/
                                                            {{ $mark->total_marks }}</span>
                                                    </td>
                                                    <td class="px-4 py-2 text-center">
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                                    {{ $mark->grade === 'F' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                            {{ $mark->grade }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <i class="fas fa-file-alt text-4xl mb-3"></i>
                            <p>No exam results found for this student.</p>
                        </div>
                    @endif
                </div>

                <!-- Financial Overview -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex justify-between items-center">
                        <span>Financial Overview</span>
                        @php
                            $outstanding = $student->fees->where('status', '!=', 'paid')->sum('amount');
                            $collected = $student->fees->sum(function ($fee) {
                                return $fee->payments->sum('amount');
                            });
                        @endphp
                        <span
                            class="text-sm font-normal {{ $outstanding > 0 ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600' }} py-1 px-3 rounded-full">
                            Due: ${{ number_format($outstanding, 2) }}
                        </span>
                    </h3>

                    <div class="space-y-6">
                        <!-- Outstanding Bills -->
                        <div class="border rounded-lg overflow-hidden">
                            <div class="bg-red-50 px-4 py-2 font-semibold text-red-800 flex justify-between">
                                <span>Outstanding Bills</span>
                            </div>
                            @if($student->fees->where('status', '!=', 'paid')->count() > 0)
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fee
                                                Type</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">
                                                Due Date</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">
                                                Amount</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        @foreach($student->fees->where('status', '!=', 'paid') as $fee)
                                            <tr>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $fee->feeType->name ?? 'Fee' }}
                                                </td>
                                                <td class="px-4 py-2 text-center text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($fee->due_date)->format('M d, Y') }}</td>
                                                <td class="px-4 py-2 text-right text-sm font-bold text-gray-900">
                                                    ${{ number_format($fee->amount, 2) }}</td>
                                                <td class="px-4 py-2 text-center">
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        {{ ucfirst($fee->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="p-4 text-center text-gray-500 text-sm">No outstanding bills.</div>
                            @endif
                        </div>

                        <!-- Payment History -->
                        <div class="border rounded-lg overflow-hidden">
                            <div class="bg-blue-50 px-4 py-2 font-semibold text-blue-800 flex justify-between">
                                <span>Payment History</span>
                                <span
                                    class="text-xs font-normal bg-white text-blue-600 px-2 py-0.5 rounded shadow-sm">Total
                                    Paid: ${{ number_format($collected, 2) }}</span>
                            </div>
                            @php
                                $allPayments = $student->fees->flatMap(function ($fee) {
                                    return $fee->payments; })->sortByDesc('payment_date');
                            @endphp
                            @if($allPayments->count() > 0)
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date
                                            </th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fee
                                            </th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">
                                                Amount</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">
                                                Method</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        @foreach($allPayments as $payment)
                                            <tr>
                                                <td class="px-4 py-2 text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900">
                                                    {{ $payment->studentFee->feeType->name ?? 'Fee' }}</td>
                                                <td class="px-4 py-2 text-right text-sm font-bold text-green-600">
                                                    ${{ number_format($payment->amount, 2) }}</td>
                                                <td class="px-4 py-2 text-center text-sm text-gray-500 capitalize">
                                                    {{ $payment->payment_method }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="p-4 text-center text-gray-500 text-sm">No payment history found.</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-master-layout>