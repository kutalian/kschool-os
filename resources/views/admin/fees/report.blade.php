<x-master-layout>
    <div class="max-w-7xl mx-auto">
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Fee Report</h1>
                <p class="text-gray-500">Overview of collected and pending fees.</p>
            </div>

            <a href="{{ route('fees.index') }}"
                class="mt-4 md:mt-0 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition shadow-sm font-medium">
                <i class="fas fa-arrow-left mr-2"></i> Back to Fees
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <form action="{{ route('fees.report') }}" method="GET"
                class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">

                <!-- Student Search (Larger) -->
                <div class="col-span-12 md:col-span-4">
                    <label class="block text-gray-700 text-xs font-bold mb-2 uppercase tracking-wide">
                        <i class="fas fa-user-graduate mr-1 text-gray-400"></i> Student
                    </label>
                    <select name="student_id"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-sm py-2.5">
                        <option value="">Search by Student Name...</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }} ({{ $student->admission_no }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Class Filter -->
                <div class="col-span-12 md:col-span-2">
                    <label class="block text-gray-700 text-xs font-bold mb-2 uppercase tracking-wide">
                        <i class="fas fa-chalkboard mr-1 text-gray-400"></i> Class
                    </label>
                    <select name="class_id"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-sm py-2.5">
                        <option value="">All Classes</option>
                        @foreach($classRooms as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }} {{ $class->section }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Fee Type Filter -->
                <div class="col-span-12 md:col-span-2">
                    <label class="block text-gray-700 text-xs font-bold mb-2 uppercase tracking-wide">
                        <i class="fas fa-tag mr-1 text-gray-400"></i> Fee Type
                    </label>
                    <select name="fee_type_id"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-sm py-2.5">
                        <option value="">All Fee Types</option>
                        @foreach($feeTypes as $fee)
                            <option value="{{ $fee->id }}" {{ request('fee_type_id') == $fee->id ? 'selected' : '' }}>
                                {{ $fee->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="col-span-12 md:col-span-2">
                    <label class="block text-gray-700 text-xs font-bold mb-2 uppercase tracking-wide">
                        <i class="fas fa-info-circle mr-1 text-gray-400"></i> Status
                    </label>
                    <select name="status"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-sm py-2.5">
                        <option value="">All Statuses</option>
                        <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                        <option value="Partial" {{ request('status') == 'Partial' ? 'selected' : '' }}>Partially Paid
                        </option>
                        <option value="Unpaid" {{ request('status') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                    </select>
                </div>

                <!-- Filter Button -->
                <div class="col-span-12 md:col-span-2">
                    <button type="submit"
                        class="w-full px-4 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium shadow-sm text-sm flex items-center justify-center">
                        <i class="fas fa-filter mr-2"></i> Apply Filters
                    </button>
                </div>

        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-4">
                <i class="fas fa-file-invoice text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Expected</p>
                <h3 class="text-2xl font-bold text-gray-800">₦{{ number_format($totalExpected, 2) }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-4">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Collected</p>
                <h3 class="text-2xl font-bold text-gray-800">₦{{ number_format($totalCollected, 2) }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-red-600 mr-4">
                <i class="fas fa-exclamation-triangle text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Outstanding Balance</p>
                <h3 class="text-2xl font-bold text-gray-800">₦{{ number_format($totalPending, 2) }}</h3>
            </div>
        </div>
    </div>

    <!-- Detailed Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Fee Records</h3>
            <span class="text-xs text-gray-500">Showing {{ $studentFees->firstItem() ?? 0 }} -
                {{ $studentFees->lastItem() ?? 0 }} of {{ $studentFees->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">
                            Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">
                            Class</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">
                            Fee Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">
                            Due Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">
                            Expected</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">
                            Paid</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">
                            Balance</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase whitespace-nowrap">
                            Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($studentFees as $fee)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $fee->student->first_name }} {{ $fee->student->last_name }}
                                <div class="text-xs text-gray-500">{{ $fee->student->admission_no }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $fee->student->class_room->name ?? 'N/A' }}
                                {{ $fee->student->class_room->section ?? '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $fee->feeType->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($fee->due_date)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($fee->status === 'Paid')
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                                @elseif($fee->status === 'Partial')
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Partial</span>
                                @else
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Unpaid</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ₦{{ number_format($fee->amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">
                                ₦{{ number_format($fee->paid, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600">
                                ₦{{ number_format($fee->amount - $fee->paid, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('fees.collect', ['student_id' => $fee->student_id]) }}"
                                    class="text-blue-600 hover:text-blue-900">Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                                No records found matching current filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-200">
            {{ $studentFees->links() }}
        </div>
    </div>
    </div>
</x-master-layout>