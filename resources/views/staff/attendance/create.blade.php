<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <a href="{{ route('staff.attendance.index') }}"
                    class="text-gray-500 hover:text-blue-600 transition mb-2 inline-block">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Classes
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Attendance: {{ $classRoom->name }} ({{ $classRoom->section }})
                </h1>
                <p class="text-gray-500">Date: {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</p>
            </div>
            <div>
                <form method="GET" action="{{ route('staff.attendance.create') }}" class="flex gap-2">
                    <input type="hidden" name="class_id" value="{{ $classRoom->id }}">
                    <input type="date" name="date" value="{{ $date }}"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        onchange="this.form.submit()">
                </form>
            </div>
        </div>

        <form method="POST" action="{{ route('staff.attendance.store') }}">
            @csrf
            <input type="hidden" name="class_id" value="{{ $classRoom->id }}">
            <input type="hidden" name="date" value="{{ $date }}">

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Student Name
                                </th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Remarks
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($classRoom->students as $student)
                                @php
                                    $status = $existingAttendance[$student->id]->status ?? 'present';
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold mr-3">
                                                {{ substr($student->first_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $student->first_name }}
                                                    {{ $student->last_name }}</div>
                                                <div class="text-xs text-gray-500">Roll No:
                                                    {{ $student->roll_number ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-4">
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="attendance[{{ $student->id }}]" value="present"
                                                    class="text-green-600 focus:ring-green-500" {{ $status == 'present' ? 'checked' : '' }}>
                                                <span class="text-sm text-gray-700">Present</span>
                                            </label>
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="attendance[{{ $student->id }}]" value="absent"
                                                    class="text-red-600 focus:ring-red-500" {{ $status == 'absent' ? 'checked' : '' }}>
                                                <span class="text-sm text-gray-700">Absent</span>
                                            </label>
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="attendance[{{ $student->id }}]" value="late"
                                                    class="text-yellow-600 focus:ring-yellow-500" {{ $status == 'late' ? 'checked' : '' }}>
                                                <span class="text-sm text-gray-700">Late</span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text" placeholder="Optional remark"
                                            class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition shadow-sm">
                    <i class="fas fa-save mr-2"></i> Save Attendance
                </button>
            </div>
        </form>
    </div>
</x-master-layout>
