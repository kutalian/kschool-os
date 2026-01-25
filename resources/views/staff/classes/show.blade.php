<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <a href="{{ route('staff.classes.index') }}"
                    class="text-gray-500 hover:text-blue-600 transition mb-2 inline-block">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Classes
                </a>
                <h1 class="text-2xl font-bold text-gray-800">{{ $classRoom->name }} ({{ $classRoom->section }})</h1>
                <p class="text-gray-500">Total Students: {{ $classRoom->students->count() }}</p>
            </div>
            <div class="flex gap-2">
                <button
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-semibold transition shadow-sm">
                    <i class="fas fa-clipboard-check mr-2"></i> Attendance
                </button>
                <button
                    class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg font-semibold transition shadow-sm">
                    <i class="fas fa-download mr-1"></i> Export List
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Admission No
                            </th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Student Name
                            </th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Roll No</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Parent</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($classRoom->students as $student)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $student->admission_no }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold mr-3">
                                            {{ substr($student->first_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $student->first_name }}
                                                {{ $student->last_name }}
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $student->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $student->roll_number ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <div>{{ $student->parent->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-400">{{ $student->parent->phone ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-gray-400 hover:text-blue-600 transition mx-1 tooltip tooltip-left"
                                        data-tip="View Profile">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-user-graduate text-4xl mb-3 text-gray-300"></i>
                                    <p>No students found in this class.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-master-layout>