<x-master-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Schedule Parent-Teacher Meeting</h1>
            <a href="{{ route('parent-teacher-meetings.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('parent-teacher-meetings.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Student</label>
                        <select name="student_id" id="student_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" data-parent-id="{{ $student->parent_id }}">
                                    {{ $student->first_name }} {{ $student->last_name }}
                                    ({{ $student->admission_no }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Parent</label>
                        <select name="parent_id" id="parent_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                            <option value="">Select Parent</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}">
                                    @if($parent->father_name || $parent->mother_name)
                                        {{ $parent->father_name }} {{ $parent->mother_name ? '/ ' . $parent->mother_name : '' }}
                                    @else
                                        {{ $parent->name }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-1">Teacher</label>
                        <select name="teacher_id" id="teacher_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                            <option value="">Select Teacher</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="meeting_date" class="block text-sm font-medium text-gray-700 mb-1">Date &
                            Time</label>
                        <input type="datetime-local" name="meeting_date" id="meeting_date"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                    </div>

                    <div>
                        <label for="duration_minutes" class="block text-sm font-medium text-gray-700 mb-1">Duration
                            (Minutes)</label>
                        <input type="number" name="duration_minutes" id="duration_minutes" value="30"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <input type="text" name="location" id="location"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="col-span-2">
                        <label for="purpose" class="block text-sm font-medium text-gray-700 mb-1">Purpose/Agenda</label>
                        <textarea name="purpose" id="purpose" rows="3"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        Schedule Meeting
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const studentSelect = document.getElementById('student_id');
            const parentSelect = document.getElementById('parent_id');

            if (studentSelect && parentSelect) {
                studentSelect.addEventListener('change', function () {
                    const selectedOption = this.options[this.selectedIndex];
                    const parentId = selectedOption.getAttribute('data-parent-id');

                    if (parentId) {
                        parentSelect.value = parentId;
                    } else {
                        parentSelect.value = "";
                    }
                });
            }
        });
    </script>
</x-master-layout>