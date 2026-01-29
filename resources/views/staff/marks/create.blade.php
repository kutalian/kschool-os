<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <a href="{{ route('staff.marks.index') }}"
                    class="text-indigo-600 hover:text-indigo-700 transition mb-2 inline-flex items-center text-sm font-medium">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Classes
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Marks Management</h1>
                <p class="text-gray-500">Entering results for {{ $classRoom->name }} ({{ $classRoom->section }})</p>
            </div>
        </div>

        {{-- Selection Form --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <form method="GET" action="{{ route('staff.marks.create') }}" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <input type="hidden" name="class_id" value="{{ $classRoom->id }}">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Academic Assessment</label>
                    <select name="exam_id" required onchange="this.form.submit()"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="">-- Choose Assessment --</option>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}" {{ (isset($examId) && $examId == $exam->id) ? 'selected' : '' }}>
                                [{{ ucfirst($exam->exam_type) }}] {{ $exam->name }} ({{ $exam->term }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Subject</label>
                    <select name="subject_id" required onchange="this.form.submit()"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="">-- Choose Subject --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ (isset($subjectId) && $subjectId == $subject->id) ? 'selected' : '' }}>
                                {{ $subject->name }} ({{ $subject->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-indigo-50 text-indigo-700 px-4 py-2 border border-indigo-100 rounded-lg hover:bg-indigo-100 transition font-bold text-sm">
                        <i class="fas fa-sync-alt mr-2"></i> Sync Student List
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

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                    <div
                        class="p-6 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50 flex justify-between items-center">
                        <div>
                            <span
                                class="px-2 py-1 text-[10px] font-bold uppercase tracking-wider rounded-md {{ $selectedExam->exam_type == 'test' ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700' }} mb-2 inline-block">
                                {{ $selectedExam->exam_type }}
                            </span>
                            <h2 class="font-bold text-gray-800 text-lg">
                                {{ $selectedExam->name }}: {{ $selectedSubject->name }}
                            </h2>
                        </div>
                        <div class="text-right">
                            <div class="text-xs text-gray-500 uppercase font-semibold">Total Possible</div>
                            <div class="text-xl font-black text-indigo-600">100</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Student</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-32">
                                        Score</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                        Outcome</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Feedback / Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100" x-data="{ marks: {} }">
                                @foreach($students as $student)
                                    @php
                                        $record = $existingMarks[$student->id] ?? null;
                                        $mark = $record->marks_obtained ?? '';
                                        $remark = $record->remarks ?? '';
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition" x-data="{ score: '{{ $mark }}' }">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs ring-2 ring-white shadow-sm">
                                                    {{ substr($student->first_name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="text-sm font-bold text-gray-800">{{ $student->first_name }}
                                                        {{ $student->last_name }}</div>
                                                    <div class="text-[10px] text-gray-400 font-medium">ROLL
                                                        #{{ $student->roll_number ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="relative">
                                                <input type="number" name="marks[{{ $student->id }}]" x-model="score" min="0"
                                                    max="100" step="0.01"
                                                    class="w-full text-sm font-bold rounded-lg border-gray-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 p-2 shadow-sm"
                                                    placeholder="0.0">
                                                <span
                                                    class="absolute right-3 top-2 text-[10px] text-gray-300 font-bold">/100</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <template x-if="score !== ''">
                                                <div>
                                                    <span x-show="score >= 35"
                                                        class="px-2 py-1 text-[10px] font-black bg-green-100 text-green-700 rounded-full border border-green-200 uppercase">Passed</span>
                                                    <span x-show="score < 35"
                                                        class="px-2 py-1 text-[10px] font-black bg-red-100 text-red-700 rounded-full border border-red-200 uppercase">Failed</span>
                                                </div>
                                            </template>
                                            <template x-if="score === ''">
                                                <span class="text-gray-300 font-black text-[10px] uppercase">Pending</span>
                                            </template>
                                        </td>
                                        <td class="px-6 py-4">
                                            <input type="text" name="remarks[{{ $student->id }}]" value="{{ $remark }}"
                                                placeholder="Student feedback..."
                                                class="w-full text-xs rounded-lg border-gray-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition placeholder-gray-300">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pb-12">
                    <a href="{{ route('staff.marks.index') }}"
                        class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-indigo-600 text-white px-10 py-3 rounded-xl font-black text-sm shadow-xl hover:bg-indigo-700 transition transform hover:scale-105 active:scale-95 flex items-center gap-2">
                        <i class="fas fa-check-circle"></i> Commit All Grades
                    </button>
                </div>
            </form>
        @else
            <div class="bg-indigo-50 rounded-2xl border border-indigo-100 p-12 text-center text-indigo-400">
                <i class="fas fa-graduation-cap text-6xl mb-4 opacity-20"></i>
                <p class="font-bold">Select an assessment and subject above to begin entry.</p>
            </div>
        @endif
    </div>
</x-master-layout>