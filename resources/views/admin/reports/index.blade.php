<x-master-layout>
    @php
        /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Exam[] $exams */
        /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\ClassRoom[] $classes */
        /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Student[] $students */
        /** @var \App\Models\ClassRoom|null $selectedClass */
        /** @var \App\Models\Exam|null $selectedExam */
    @endphp

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Generate Report Cards</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <form action="{{ route('reports.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-1/3">
                <label class="block text-gray-700 text-sm font-bold mb-2">Select Exam</label>
                <select name="exam_id"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm"
                    required>
                    <option value="">-- Select Exam --</option>
                    @foreach($exams as $exam)
                        <option value="{{ $exam->id }}" {{ (isset($selectedExam) && $selectedExam->id == $exam->id) ? 'selected' : '' }}>
                            {{ $exam->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-1/3">
                <label class="block text-gray-700 text-sm font-bold mb-2">Select Class</label>
                <select name="class_id"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm"
                    required>
                    <option value="">-- Select Class --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ (isset($selectedClass) && $selectedClass->id == $class->id) ? 'selected' : '' }}>
                            {{ $class->name }} - {{ $class->section }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="pb-1">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Fetch Students
                </button>
            </div>
        </form>
    </div>

    @if(isset($students) && count($students) > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800">
                    Students in {{ $selectedClass->name }} - {{ $selectedClass->section }}
                </h2>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admission
                            No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($students as $student)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->admission_no }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('reports.print', ['studentId' => $student->id, 'examId' => $selectedExam->id]) }}"
                                    target="_blank" class="text-blue-600 hover:text-blue-900 font-medium">
                                    <i class="fas fa-print mr-1"></i> View Report Card
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif(isset($selectedClass))
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">No students found.</p>
                </div>
            </div>
        </div>
    @endif
</x-master-layout>