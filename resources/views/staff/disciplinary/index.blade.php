<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Disciplinary Records</h1>
                <p class="text-sm text-gray-500">Report and track student behavioral incidents</p>
            </div>
            <a href="{{ route('staff.disciplinary.create') }}"
                class="px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition shadow-lg flex items-center gap-2">
                <i class="fas fa-plus-circle text-sm"></i>
                Report New Incident
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Student</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Incident Type</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($records as $record)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800">{{ $record->student->user->name }}</div>
                                    <div class="text-xs text-gray-500">Roll: {{ $record->student->roll_number }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 font-medium">{{ $record->incident_type }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700">{{ $record->incident_date->format('M d, Y') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($record->handled_by)
                                        <span
                                            class="px-2 py-1 text-xs font-medium bg-green-100 text-green-600 rounded-full">Resolved</span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-600 rounded-full">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('staff.disciplinary.show', $record) }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium text-sm transition">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    No disciplinary records reported yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($records->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $records->links() }}
                </div>
            @endif
        </div>
    </div>
</x-master-layout>