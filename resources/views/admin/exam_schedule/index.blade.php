<x-master-layout>
    <div class="max-w-4xl mx-auto py-12">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
            <div class="mb-6">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-indigo-50 mb-4">
                    <i class="fas fa-clock text-2xl text-indigo-600"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Exam Timetable</h1>
                <p class="text-gray-500">Select an Exam and Class to manage the schedule.</p>
            </div>

            <form action="{{ route('exam-schedule.manage') }}" method="GET"
                class="max-w-lg mx-auto space-y-4 text-left">

                <!-- Exam/Term Selection -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Select Exam / Term</label>
                    <div class="relative">
                        <select name="exam_id" required
                            class="w-full pl-4 pr-10 py-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition appearance-none bg-white">
                            <option value="">-- Choose Exam --</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}">{{ $exam->name }}
                                    ({{ \Carbon\Carbon::parse($exam->start_date)->format('M Y') }})</option>
                            @endforeach
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Class Selection -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Select Class</label>
                    <div class="relative">
                        <select name="class_id" required
                            class="w-full pl-4 pr-10 py-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition appearance-none bg-white">
                            <option value="">-- Choose Class --</option>
                            @foreach($classRooms as $class)
                                <option value="{{ $class->id }}">{{ $class->name }} {{ $class->section }}</option>
                            @endforeach
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <button type="submit" style="background-color: #4f46e5; color: #ffffff;"
                    class="w-full px-6 py-3 rounded-lg hover:opacity-90 transition font-medium shadow-md flex items-center justify-center gap-2">
                    <i class="fas fa-cogs"></i> Manage Schedule
                </button>
            </form>
        </div>
    </div>
</x-master-layout>