@php
    $initialAttendance = [];
    foreach ($classRoom->students as $student) {
        $initialAttendance[$student->id] = $existingAttendance[$student->id]->status ?? 'present';
    }
@endphp

<x-master-layout>
    <div class="fade-in" x-data="{ 
        attendance: {{ json_encode($initialAttendance) }},
        markAll(status) {
            for (let id in this.attendance) {
                this.attendance[id] = status;
            }
        }
    }">
        <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <a href="{{ route('staff.attendance.index') }}"
                    class="text-indigo-600 hover:text-indigo-700 transition mb-2 inline-flex items-center text-sm font-medium">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Classes
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Attendance: {{ $classRoom->name }}
                    ({{ $classRoom->section }})</h1>
                <p class="text-gray-500 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-indigo-400"></i>
                    {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}
                </p>
            </div>

            <div class="flex flex-wrap gap-2 items-center">
                <button type="button" @click="markAll('present')"
                    class="px-3 py-1.5 bg-green-50 text-green-700 border border-green-100 rounded-lg text-xs font-bold hover:bg-green-100 transition shadow-sm">
                    Mark All Present
                </button>
                <form method="GET" action="{{ route('staff.attendance.create') }}" class="flex gap-2">
                    <input type="hidden" name="class_id" value="{{ $classRoom->id }}">
                    <input type="date" name="date" value="{{ $date }}"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
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
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th
                                    class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-1/3">
                                    Student</th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                    Status</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($classRoom->students as $student)
                                @php
                                    $record = $existingAttendance[$student->id] ?? null;
                                    $remark = $record->remarks ?? '';
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 text-white flex items-center justify-center font-bold shadow-sm">
                                                {{ substr($student->first_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-gray-800">{{ $student->first_name }}
                                                    {{ $student->last_name }}</div>
                                                <div class="text-xs text-gray-400">Roll No:
                                                    {{ $student->roll_number ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">
                                            <!-- Present -->
                                            <div class="relative">
                                                <input type="radio" id="att-{{ $student->id }}-present"
                                                    name="attendance[{{ $student->id }}]" value="present" class="sr-only"
                                                    x-model="attendance[{{ $student->id }}]">
                                                <label @click="attendance[{{ $student->id }}] = 'present'"
                                                    :class="attendance[{{ $student->id }}] == 'present' ? 'bg-green-600 border-green-600 text-white shadow-md' : 'border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                    class="px-3 py-1.5 rounded-lg border text-xs font-bold cursor-pointer transition-all inline-block select-none capitalize">
                                                    present
                                                </label>
                                            </div>
                                            <!-- Absent -->
                                            <div class="relative">
                                                <input type="radio" id="att-{{ $student->id }}-absent"
                                                    name="attendance[{{ $student->id }}]" value="absent" class="sr-only"
                                                    x-model="attendance[{{ $student->id }}]">
                                                <label @click="attendance[{{ $student->id }}] = 'absent'"
                                                    :class="attendance[{{ $student->id }}] == 'absent' ? 'bg-red-600 border-red-600 text-white shadow-md' : 'border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                    class="px-3 py-1.5 rounded-lg border text-xs font-bold cursor-pointer transition-all inline-block select-none capitalize">
                                                    absent
                                                </label>
                                            </div>
                                            <!-- Late -->
                                            <div class="relative">
                                                <input type="radio" id="att-{{ $student->id }}-late"
                                                    name="attendance[{{ $student->id }}]" value="late" class="sr-only"
                                                    x-model="attendance[{{ $student->id }}]">
                                                <label @click="attendance[{{ $student->id }}] = 'late'"
                                                    :class="attendance[{{ $student->id }}] == 'late' ? 'bg-amber-500 border-amber-500 text-white shadow-md' : 'border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                    class="px-3 py-1.5 rounded-lg border text-xs font-bold cursor-pointer transition-all inline-block select-none capitalize">
                                                    late
                                                </label>
                                            </div>
                                            <!-- Excused -->
                                            <div class="relative">
                                                <input type="radio" id="att-{{ $student->id }}-excused"
                                                    name="attendance[{{ $student->id }}]" value="excused" class="sr-only"
                                                    x-model="attendance[{{ $student->id }}]">
                                                <label @click="attendance[{{ $student->id }}] = 'excused'"
                                                    :class="attendance[{{ $student->id }}] == 'excused' ? 'bg-blue-600 border-blue-600 text-white shadow-md' : 'border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                    class="px-3 py-1.5 rounded-lg border text-xs font-bold cursor-pointer transition-all inline-block select-none capitalize">
                                                    excused
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="remarks[{{ $student->id }}]" value="{{ $remark }}"
                                            placeholder="Add a remark..."
                                            class="w-full text-xs rounded-lg border-gray-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition placeholder-gray-300">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-end gap-3 pb-12">
                <a href="{{ route('staff.attendance.index') }}"
                    class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit"
                    class="bg-indigo-600 text-white px-8 py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition shadow-lg flex items-center gap-2">
                    <i class="fas fa-save text-sm"></i> Save Attendance
                </button>
            </div>
        </form>
    </div>
</x-master-layout>