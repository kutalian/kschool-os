<x-master-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mark Staff Attendance</h1>
        <p class="text-gray-500">Record daily attendance for staff.</p>
    </div>

    <form action="{{ route('staff-attendance.store') }}" method="POST">
        @csrf

        <!-- Date Selection -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6 flex items-end gap-4">
            <div class="w-full md:w-1/4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                <input type="date" name="date" value="{{ $date }}" required
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition"
                    onchange="window.location.href='{{ route('staff-attendance.create') }}?date=' + this.value">
            </div>
        </div>

        <!-- Staff List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="p-4 font-semibold text-gray-600 text-sm">Staff Member</th>
                        <th class="p-4 font-semibold text-gray-600 text-sm">Role</th>
                        <th class="p-4 font-semibold text-gray-600 text-sm text-center">Status</th>
                        <th class="p-4 font-semibold text-gray-600 text-sm">Remarks</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($staff as $member)
                        @php
                            $existing = $existingAttendance[$member->id] ?? null;
                            $status = $existing ? $existing->status : 'Present'; // Default to Present
                            $remark = $existing ? $existing->remarks : '';
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4">
                                <div class="font-bold text-gray-800">{{ $member->name }}</div>
                                <div class="text-sm text-gray-500">{{ $member->employee_id }}</div>
                            </td>
                            <td class="p-4">
                                <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded text-xs">
                                    {{ $member->role_type }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="flex justify-center gap-2" x-data="{ currentStatus: '{{ $status }}' }">
                                    @foreach(['Present', 'Absent', 'Late', 'Half Day', 'Leave'] as $opt)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="attendance[{{ $member->id }}]" value="{{ $opt }}"
                                                x-model="currentStatus" class="sr-only">
                                            <span
                                                class="px-3 py-1.5 rounded-lg text-sm border inline-block transition font-medium"
                                                :class="{
                                                                'bg-green-100 text-green-700 border-green-200 shadow-sm': currentStatus === 'Present' && '{{ $opt }}' === 'Present',
                                                                'bg-red-100 text-red-700 border-red-200 shadow-sm': currentStatus === 'Absent' && '{{ $opt }}' === 'Absent',
                                                                'bg-yellow-100 text-yellow-700 border-yellow-200 shadow-sm': currentStatus === 'Late' && '{{ $opt }}' === 'Late',
                                                                'bg-orange-100 text-orange-700 border-orange-200 shadow-sm': currentStatus === 'Half Day' && '{{ $opt }}' === 'Half Day',
                                                                'bg-blue-100 text-blue-700 border-blue-200 shadow-sm': currentStatus === 'Leave' && '{{ $opt }}' === 'Leave',
                                                                'bg-white text-gray-700 border-gray-200 hover:bg-gray-50': currentStatus !== '{{ $opt }}'
                                                            }">
                                                {{ $opt }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </td>
                            <td class="p-4">
                                <input type="text" name="remarks[{{ $member->id }}]" value="{{ $remark }}"
                                    class="w-full rounded border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Optional remark">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end gap-3 pb-8">
            <a href="{{ route('staff-attendance.index', ['date' => $date]) }}"
                class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition font-medium">Cancel</a>
            <button type="submit"
                class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium shadow-sm">
                Save Attendance
            </button>
        </div>
    </form>
</x-master-layout>