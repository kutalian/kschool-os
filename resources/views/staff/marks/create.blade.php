<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <a href="{{ route('staff.marks.index') }}"
                    class="text-gray-500 hover:text-blue-600 transition mb-2 inline-block">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Classes
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Details: {{ $classRoom->name }} ({{ $classRoom->section }})
                </h1>
            </div>
        </div>

        {{-- Selection Form --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <form method="GET" action="{{ route('staff.marks.create') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="hidden" name="class_id" value="{{ $classRoom->id }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Exam</label>
                    <select name="exam_id"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                        required onchange="this.form.submit()">
                        <option value="">-- Choose Exam --</option>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}" {{ (isset($examId) && $examId == $exam->id) ? 'selected' : '' }}>
                                {{ $exam->name }} ({{ $exam->term }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Subject</label>
                    <select name="subject_id"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                        required onchange="this.form.submit()">
                        <option value="">-- Choose Subject --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}"
                                {{ (isset($subjectId) && $subjectId == $subject->id) ? 'selected' : '' }}>
                                {{ $subject->name }} ({{ $subject->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-gray-100 text-gray-700 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-200 transition">
                        Load Students
                    </button>
                </div>
            </form>
        </div>

        @if(isset($students) && isset($selectedExam) && isset($selectedSubject))
            <form method="POST" action="{{ route('staff.marks.store') }}">
                @csrf
                <input type="hidden" name="class_id" value="{{ $classRoom->id }}">
                <input type="hidden" name="exam_id" value="{{ $selectedExam->id }}">
                <input type="hidden" name="subject_id" value="{{ $selectedSubject->id }}">

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-pink-50 flex justify-between items-center">
                        <h2 class="font-bold text-pink-800">
                            {{ $selectedExam->name }} - {{ $selectedSubject->name }}
                        </h2>
                        <span class="text-xs text-pink-600 bg-white px-2 py-1 rounded border border-pink-200">
                            Max Marks: 100
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Student Name
                                    </th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider w-40">
                                        Marks Obtained</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Pass/Fail
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($students as $student)
                                    @php
                                        $mark = $existingMarks[$student->id]->marks_obtained ?? '';
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $student->first_name }}
                                                {{ $student->last_name }}</div>
                                            <div class="text-xs text-gray-500">Roll: {{ $student->roll_number ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <input type="number" name="marks[{{ $student->id }}]" value="{{ $mark }}"
                                                min="0" max="100" step="0.01"
                                                class="w-full rounded-md border-gray-300 focus:border-pink-500 focus:ring-pink-500"
                                                placeholder="0-100">
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($mark !== '')
                                                @if($mark >= 35)
                                                    <span class="text-green-600 font-bold text-xs bg-green-100 px-2 py-1 rounded">PASS</span>
                                                @else
                                                    <span class="text-red-600 font-bold text-xs bg-red-100 px-2 py-1 rounded">FAIL</span>
                                                @endif
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="bg-pink-600 text-white px-8 py-3 rounded-lg font-bold shadow-lg hover:bg-pink-700 transition transform hover:-translate-y-0.5">
                        <i class="fas fa-save mr-2"></i> Save Marks
                    </button>
                </div>
            </form>
        @endif
    </div>
</x-master-layout>
