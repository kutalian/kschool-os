<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Leave Applications</h1>
                <p class="text-sm text-gray-500">Request time off and track approval status</p>
            </div>
            <a href="{{ route('staff.leave.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center gap-2">
                <i class="fas fa-paper-plane text-sm"></i>
                Apply for Leave
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Duration</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Days</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($applications as $leave)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800">{{ $leave->leave_type }}</div>
                                    <div class="text-xs text-gray-500 truncate max-w-xs">{{ Str::limit($leave->reason, 50) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700">@if($leave->from_date) {{ $leave->from_date->format('M d, Y') }} @else N/A @endif - @if($leave->to_date) {{ $leave->to_date->format('M d, Y') }} @else N/A @endif</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-800">{{ $leave->days }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusClasses = [
                                            'Pending' => 'bg-yellow-100 text-yellow-700',
                                            'Approved' => 'bg-green-100 text-green-700',
                                            'Rejected' => 'bg-red-100 text-red-700',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-bold rounded-full uppercase tracking-wider {{ $statusClasses[$leave->status] ?? 'bg-gray-100' }}">
                                        {{ $leave->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('staff.leave.show', $leave) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm transition">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    No leave applications found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($applications->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $applications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-master-layout>
