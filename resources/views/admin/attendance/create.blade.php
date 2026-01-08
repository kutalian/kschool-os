<x-master-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Take Attendance</h1>
    </div>

    <!-- Selection Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <form action="{{ route('attendance.create') }}" method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-1/3">
                <label class="block text-gray-700 text-sm font-bold mb-2">Select Class</label>
                <select name="class_id" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
                    <option value="">-- Select Class --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ (isset($selectedClass) && $selectedClass->id == $class->id) ? 'selected' : '' }}>
                            {{ $class->name }} - {{ $class->section }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-1/3">
                <label class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                <input type="date" name="date" value="{{ $date }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
            </div>
            <div class="pb-1">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Fetch Students
                </button>
            </div>
        </form>
    </div>

    @if(isset($selectedClass) && count($students) > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">
                    Students in {{ $selectedClass->name }} - {{ $selectedClass->section }}
                    <span class="text-sm font-normal text-gray-500 ml-2">({{ $date }})</span>
                </h2>
                <div class="text-sm">
                    <button type="button" onclick="markAll('Present')" class="text-green-600 hover:underline mr-4">Mark All Present</button>
                    <button type="button" onclick="markAll('Absent')" class="text-red-600 hover:underline">Mark All Absent</button>
                </div>
            </div>
            
            <form action="{{ route('attendance.store') }}" method="POST">
                @csrf
                <input type="hidden" name="class_id" value="{{ $selectedClass->id }}">
                <input type="hidden" name="date" value="{{ $date }}">

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admission No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($students as $student)
                            @php
                                // Check if attendance already exists for this date
                                $existing = \App\Models\Attendance::where('student_id', $student->id)->where('date', $date)->first();
                                $status = $existing ? $existing->status : 'Present'; // Default to Present
                            @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->admission_no }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex space-x-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="Present" class="form-radio text-green-600" {{ $status == 'Present' ? 'checked' : '' }}>
                                            <span class="ml-2">Present</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="Absent" class="form-radio text-red-600" {{ $status == 'Absent' ? 'checked' : '' }}>
                                            <span class="ml-2">Absent</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="Late" class="form-radio text-yellow-600" {{ $status == 'Late' ? 'checked' : '' }}>
                                            <span class="ml-2">Late</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="Excused" class="form-radio text-blue-600" {{ $status == 'Excused' ? 'checked' : '' }}>
                                            <span class="ml-2">Excused</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-8 py-2.5 rounded-lg hover:bg-blue-700 transition font-medium shadow-sm">
                        Save Attendance
                    </button>
                </div>
            </form>
        </div>

        <script>
            function markAll(status) {
                const radios = document.querySelectorAll(`input[value="${status}"]`);
                radios.forEach(radio => radio.checked = true);
            }
        </script>
    @elseif(isset($selectedClass))
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        No students found in this class.
                    </p>
                </div>
            </div>
        </div>
    @endif
</x-master-layout>
