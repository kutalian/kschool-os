<x-master-layout>
    <div class="fade-in">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Attendance</h1>
            <p class="text-gray-500">Select a child to view attendance records</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($children as $child)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <div class="p-6 text-center">
                        <div
                            class="h-20 w-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-3xl mx-auto mb-4 border-4 border-white shadow-sm">
                            {{ substr($child->first_name, 0, 1) }}
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $child->first_name }} {{ $child->last_name }}
                        </h3>
                        <p class="text-sm text-gray-500 mb-4">Class: {{ $child->class_room->name ?? 'N/A' }}</p>

                        <a href="{{ route('parent.attendance.show', $child->id) }}"
                            class="block w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                            View Attendance
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-master-layout>