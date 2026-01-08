<x-master-layout>
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ route('marks.create') }}" class="hover:text-blue-600">Marks</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span>Entry</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">{{ $exam->name }}</h1>
        <p class="text-gray-600">
            <strong>Class:</strong> {{ $exam->class_room->name }}-{{ $exam->class_room->section }} |
            <strong>Subject:</strong> {{ $subject->name }}
        </p>
    </div>

    <form action="{{ route('marks.store') }}" method="POST">
        @csrf
        <input type="hidden" name="exam_id" value="{{ $exam->id }}">
        <input type="hidden" name="subject_id" value="{{ $subject->id }}">

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                            Admission No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Student Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">
                            Marks Obtained (Out of 100)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($students as $student)
                        @php
                            $currentMark = $existingMarks[$student->id]->marks_obtained ?? '';
                        @endphp
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->admission_no }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="number" step="0.01" min="0" max="100" name="marks[{{ $student->id }}]"
                                    value="{{ $currentMark }}"
                                    class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition"
                                    placeholder="0.00">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('marks.create') }}"
                class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition font-medium">Cancel</a>
            <button type="submit"
                class="bg-green-600 text-white px-8 py-2.5 rounded-lg hover:bg-green-700 transition font-medium shadow-sm">
                Save Marks
            </button>
        </div>
    </form>
</x-master-layout>