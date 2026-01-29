<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Submissions</h1>
                <p class="text-sm text-gray-500">Grading for: <span
                        class="font-semibold text-gray-700">{{ $assignment->title }}</span></p>
            </div>
            <a href="{{ route('staff.assignments.index') }}"
                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
                <i class="fas fa-arrow-left text-sm"></i>
                Back to List
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Student</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Submitted At</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">File</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Marks</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($submissions as $submission)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                            {{ substr($submission->student->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800">{{ $submission->student->user->name }}
                                            </div>
                                            <div class="text-xs text-gray-500">Roll:
                                                {{ $submission->student->roll_number ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700">
                                        {{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y H:i') : 'Unknown' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($submission->file_path)
                                        <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank"
                                            class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-medium hover:bg-blue-100 transition">
                                            <i class="fas fa-download mr-1"></i> Download
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400">No File</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($submission->marks_obtained !== null)
                                        <span class="font-bold text-gray-800">{{ $submission->marks_obtained }}</span>
                                        <span class="text-gray-400">/ 100</span>
                                    @else
                                        <span
                                            class="text-xs text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full font-medium italic">Not
                                            Graded</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button
                                        onclick="openGradeModal({{ $submission->id }}, '{{ $submission->student->user->name }}', {{ $submission->marks_obtained ?? 'null' }}, '{{ addslashes($submission->remarks ?? '') }}')"
                                        class="text-blue-600 hover:text-blue-800 font-medium text-sm transition">
                                        {{ $submission->marks_obtained !== null ? 'Edit Grade' : 'Give Grade' }}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    No submissions yet for this assignment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Grade Modal -->
    <div id="grade-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Grade Submission</h3>
                <button onclick="closeGradeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="grade-form" method="POST">
                @csrf
                <div class="p-6 space-y-4">
                    <p class="text-sm text-gray-600">Grading for <span id="student-name"
                            class="font-semibold text-gray-800"></span></p>

                    <div>
                        <x-input-label for="marks_obtained" :value="__('Marks Obtained (out of 100)')" />
                        <x-text-input id="marks_obtained" name="marks_obtained" type="number" class="block mt-1 w-full"
                            step="0.1" required />
                    </div>

                    <div>
                        <x-input-label for="remarks" :value="__('Feedback / Remarks')" />
                        <textarea id="remarks" name="remarks" rows="3"
                            class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm"></textarea>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3">
                    <button type="button" onclick="closeGradeModal()"
                        class="px-4 py-2 text-gray-700 hover:text-gray-900 transition">Cancel</button>
                    <x-primary-button class="bg-blue-600 hover:bg-blue-700">Save Grade</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openGradeModal(id, name, marks, remarks) {
            const modal = document.getElementById('grade-modal');
            const form = document.getElementById('grade-form');
            const marksInput = document.getElementById('marks_obtained');
            const remarksInput = document.getElementById('remarks');
            const nameSpan = document.getElementById('student-name');

            form.action = `/staff/submissions/${id}/grade`;
            nameSpan.innerText = name;
            marksInput.value = marks !== null ? marks : '';
            remarksInput.value = remarks;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeGradeModal() {
            const modal = document.getElementById('grade-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-master-layout>