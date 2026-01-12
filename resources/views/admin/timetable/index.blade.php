<x-master-layout>
    <div class="max-w-4xl mx-auto py-12" x-data="{ tab: 'class' }">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">

            <!-- Tabs Header -->
            <div class="flex justify-center mb-8 border-b border-gray-100">
                <button @click="tab = 'class'"
                    :class="tab === 'class' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500 hover:text-gray-700'"
                    class="pb-4 px-6 font-semibold text-lg transition-colors focus:outline-none">
                    Class Timetable
                </button>
                <button @click="tab = 'exam'"
                    :class="tab === 'exam' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-500 hover:text-gray-700'"
                    class="pb-4 px-6 font-semibold text-lg transition-colors focus:outline-none ml-4">
                    Exam Timetable
                </button>
            </div>

            <!-- Class Timetable Tab -->
            <div x-show="tab === 'class'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100">
                <div class="mb-6">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-50 mb-4">
                        <i class="fas fa-calendar-alt text-2xl text-blue-600"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">Class Timetable</h1>
                    <p class="text-gray-500">Select a class to view or manage its weekly schedule.</p>
                </div>

                <form action="{{ route('timetable.manage') }}" method="GET" class="max-w-md mx-auto">
                    <div class="mb-6 text-left">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Select Class</label>
                        <div class="relative">
                            <select name="class_id" required
                                class="w-full pl-4 pr-10 py-3 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition appearance-none bg-white">
                                <option value="">-- Choose Class --</option>
                                @foreach($classRooms as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }} {{ $class->section }}</option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                        Manage Class Timetable
                    </button>
                </form>
            </div>

            <!-- Exam Timetable Tab -->
            <div x-show="tab === 'exam'" style="display: none;" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100">
                <div class="mb-6">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-indigo-50 mb-4">
                        <i class="fas fa-clock text-2xl text-indigo-600"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">Exam Timetable</h1>
                    <p class="text-gray-500">Select an Exam and Class to manage the schedule.</p>
                </div>

                <form action="{{ route('exam-schedule.manage') }}" method="GET"
                    class="max-w-md mx-auto text-left space-y-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Select Exam</label>
                        <div class="relative">
                            <select name="exam_id" required
                                class="w-full pl-4 pr-10 py-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition appearance-none bg-white">
                                <option value="">-- Choose Exam --</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>

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
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <button type="submit" style="background-color: #4f46e5; color: #ffffff;"
                        class="w-full px-6 py-3 rounded-lg hover:opacity-90 transition font-medium shadow-md flex items-center justify-center gap-2">
                        <i class="fas fa-cogs"></i> Manage Exam Timetable
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-master-layout>