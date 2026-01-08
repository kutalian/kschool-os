<x-master-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Enter Marks</h1>
        <p class="text-gray-500">Select an Exam and Subject to start entering marks.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl">
        <form action="{{ route('marks.manage') }}" method="GET" class="space-y-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Select Exam</label>
                <select name="exam_id"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition"
                    required>
                    <option value="">-- Choose Exam --</option>
                    @foreach($exams as $exam)
                        <option value="{{ $exam->id }}">
                            {{ $exam->name }} ({{ $exam->class_room->name }} - {{ $exam->class_room->section }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Select Subject</label>
                <select name="subject_id"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition"
                    required>
                    <option value="">-- Choose Subject --</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">
                            {{ $subject->name }} ({{ $subject->code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 transition font-medium shadow-sm">
                    Proceed to Enter Marks
                </button>
            </div>
        </form>
    </div>
</x-master-layout>