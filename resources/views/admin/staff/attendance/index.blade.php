<x-master-layout>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Staff Attendance</h1>
            <p class="text-gray-500">Manage daily attendance for staff members.</p>
        </div>
        <a href="{{ route('staff-attendance.create', ['date' => $date]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i> Mark Attendance
        </a>
    </div>

    <!-- Date Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" action="{{ route('staff-attendance.index') }}" class="flex items-end gap-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Select Date</label>
                <input type="date" name="date" value="{{ $date }}" 
                    class="rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition"
                    onchange="this.form.submit()">
            </div>
            <div class="pb-1">
                <button type="submit" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Attendance Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="p-4 font-semibold text-gray-600 text-sm">Staff Name</th>
                    <th class="p-4 font-semibold text-gray-600 text-sm">Role</th>
                    <th class="p-4 font-semibold text-gray-600 text-sm">Status</th>
                    <th class="p-4 font-semibold text-gray-600 text-sm">Remarks</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($attendance as $record)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4">
                            <div class="font-bold text-gray-800">{{ $record->staff->name }}</div>
                            <div class="text-xs text-gray-500">{{ $record->staff->employee_id }}</div>
                        </td>
                        <td class="p-4">
                            <span class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full text-xs font-semibold">
                                {{ $record->staff->role_type }}
                            </span>
                        </td>
                        <td class="p-4">
                            @php
                                $statusColors = [
                                    'Present' => 'bg-green-100 text-green-700',
                                    'Absent' => 'bg-red-100 text-red-700',
                                    'Late' => 'bg-yellow-100 text-yellow-700',
                                    'Half Day' => 'bg-orange-100 text-orange-700',
                                    'Leave' => 'bg-blue-100 text-blue-700',
                                ];
                            @endphp
                            <span class="{{ $statusColors[$record->status] ?? 'bg-gray-100 text-gray-700' }} px-2.5 py-1 rounded-full text-xs font-semibold">
                                {{ $record->status }}
                            </span>
                        </td>
                        <td class="p-4 text-gray-500 text-sm">
                            {{ $record->remarks ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-500">
                            No attendance records found for this date.
                            <br>
                            <a href="{{ route('staff-attendance.create', ['date' => $date]) }}" class="text-blue-600 font-medium hover:underline mt-2 inline-block">
                                Mark Attendance Now
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-master-layout>
