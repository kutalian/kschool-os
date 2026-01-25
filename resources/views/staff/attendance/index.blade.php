<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Attendance Management</h1>
            <span class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Loop through classes where the user is a class teacher or subject teacher --}}
            @foreach($classes as $class)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition duration-200">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $class->name }}</h3>
                            <p class="text-gray-500">Section: {{ $class->section ?? 'A' }}</p>
                        </div>
                        <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                            <i class="fas fa-clipboard-check text-xl"></i>
                        </div>
                    </div>

                    <div class="mt-4 space-y-2">
                        <a href="{{ route('staff.attendance.create', ['class_id' => $class->id]) }}"
                            class="block w-full py-2 px-4 bg-purple-600 text-white font-semibold rounded-lg text-center hover:bg-purple-700 transition">
                            Take Attendance
                        </a>
                        <a href="{{ route('staff.attendance.report', ['class_id' => $class->id]) }}"
                            class="block w-full py-2 px-4 bg-white border border-gray-200 text-gray-700 font-semibold rounded-lg text-center hover:bg-gray-50 transition">
                            View Report
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-master-layout>