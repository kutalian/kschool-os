<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Application Details</h1>
                <p class="text-sm text-gray-500">Review your leave request #{{ $leave->id }}</p>
            </div>
            <a href="{{ route('staff.leave.index') }}"
                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                Back to List
            </a>
        </div>

        <div class="max-w-3xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 space-y-8">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $leave->leave_type }}</h3>
                            <p class="text-gray-500">@if($leave->from_date) {{ $leave->from_date->format('M d, Y') }}
                            @else N/A @endif - @if($leave->to_date) {{ $leave->to_date->format('M d, Y') }} @else
                                N/A @endif ({{ $leave->days }} days)</p>
                        </div>
                        <div class="text-right">
                            @php
                                $statusClasses = [
                                    'Pending' => 'bg-yellow-100 text-yellow-700',
                                    'Approved' => 'bg-green-100 text-green-700',
                                    'Rejected' => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <span
                                class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wider {{ $statusClasses[$leave->status] ?? 'bg-gray-100' }}">
                                {{ $leave->status }}
                            </span>
                            <p class="text-xs text-gray-400 mt-2 italic">Applied on
                                {{ $leave->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-2">Reason</p>
                        <div class="bg-gray-50 rounded-lg p-4 text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $leave->reason }}
                        </div>
                    </div>

                    @if($leave->attachment)
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-2">Attachment</p>
                            <a href="{{ asset('storage/' . $leave->attachment) }}" target="_blank"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition border border-indigo-100 font-medium">
                                <i class="fas fa-file-download"></i>
                                View Attached Document
                            </a>
                        </div>
                    @endif

                    @if($leave->status !== 'Pending')
                        <div class="pt-6 border-t border-gray-100">
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-2">Admin Remarks</p>
                            <div class="bg-gray-50 rounded-lg p-4 text-gray-700 italic">
                                {{ $leave->approval_remarks ?: 'No remarks provided.' }}
                            </div>
                            @if($leave->approved_at)
                                <p class="text-xs text-gray-400 mt-2">Processed on @if(is_string($leave->approved_at))
                                {{ $leave->approved_at }} @else {{ $leave->approved_at->format('M d, Y H:i') }} @endif</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-master-layout>