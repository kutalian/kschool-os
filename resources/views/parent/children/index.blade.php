<x-master-layout>
    <div class="fade-in">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">My Children</h1>
        </div>

        @if($children->isEmpty())
            <div class="bg-white rounded-xl shadow-sm p-8 text-center border border-gray-100">
                <div class="text-gray-300 mb-4">
                    <i class="fas fa-child text-6xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">No Children Linked</h3>
                <p class="text-gray-500">No student profiles are currently linked to your account.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($children as $child)
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div
                                    class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-2xl mr-4 border-2 border-white shadow-sm">
                                    {{ substr($child->first_name, 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $child->first_name }} {{ $child->last_name }}
                                    </h3>
                                    <p class="text-sm text-gray-500">Admission No: {{ $child->admission_no }}</p>
                                </div>
                            </div>

                            <div class="space-y-2 mb-6">
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-8 flex justify-center"><i class="fas fa-school text-gray-400"></i></div>
                                    <span class="font-medium mr-2">Class:</span>
                                    <span>{{ $child->class_room->name ?? 'N/A' }}
                                        ({{ $child->class_room->section ?? '' }})</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-8 flex justify-center"><i class="fas fa-id-badge text-gray-400"></i></div>
                                    <span class="font-medium mr-2">Roll No:</span>
                                    <span>{{ $child->roll_no ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('parent.attendance.show', $child->id) }}"
                                    class="block text-center py-2 px-3 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold transition border border-gray-200">
                                    <i class="fas fa-calendar-check mb-1 block text-lg text-green-500"></i> Attendance
                                </a>
                                <a href="{{ route('parent.progress.show', $child->id) }}"
                                    class="block text-center py-2 px-3 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold transition border border-gray-200">
                                    <i class="fas fa-star mb-1 block text-lg text-yellow-500"></i> Progress
                                </a>
                                <a href="{{ route('parent.fees.show', $child->id) }}"
                                    class="block text-center py-2 px-3 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold transition border border-gray-200">
                                    <i class="fas fa-file-invoice-dollar mb-1 block text-lg text-blue-500"></i> Fees
                                </a>
                                <a href="#"
                                    class="block text-center py-2 px-3 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold transition border border-gray-200">
                                    <i class="fas fa-clock mb-1 block text-lg text-purple-500"></i> Timetable
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-master-layout>