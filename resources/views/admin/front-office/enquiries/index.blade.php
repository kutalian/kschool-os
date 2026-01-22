<x-master-layout>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Admission Enquiries</h1>
            <p class="text-gray-500 text-sm">Track student admission leads and follow-ups</p>
        </div>
        <a href="{{ route('admission-enquiries.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Enquiry
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <div class="text-gray-500 text-xs uppercase font-semibold">Pending Enquiries</div>
            <div class="text-2xl font-bold text-gray-800 mt-1">
                {{ \App\Models\AdmissionEnquiry::where('status', 'Pending')->count() }}</div>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <div class="text-gray-500 text-xs uppercase font-semibold">Today's Follow-ups</div>
            <div class="text-2xl font-bold text-gray-800 mt-1">
                {{ \App\Models\AdmissionEnquiry::whereDate('next_follow_up', today())->count() }}</div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-sm uppercase">
                        <th class="p-4 font-semibold border-b">Name</th>
                        <th class="p-4 font-semibold border-b">Contact</th>
                        <th class="p-4 font-semibold border-b">Class</th>
                        <th class="p-4 font-semibold border-b">Enquiry Date</th>
                        <th class="p-4 font-semibold border-b">Next Follow Up</th>
                        <th class="p-4 font-semibold border-b">Status</th>
                        <th class="p-4 font-semibold border-b text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($enquiries as $enquiry)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4">
                                <div class="font-medium text-gray-800">{{ $enquiry->name }}</div>
                            </td>
                            <td class="p-4">
                                <div class="text-sm text-gray-800">{{ $enquiry->phone }}</div>
                                <div class="text-xs text-gray-500">{{ $enquiry->email }}</div>
                            </td>
                            <td class="p-4 text-gray-600 font-medium">{{ $enquiry->class_applying_for ?? '-' }}</td>
                            <td class="p-4 text-gray-600 text-sm">
                                {{ $enquiry->date->format('d M, Y') }}
                            </td>
                            <td class="p-4 text-gray-600 text-sm">
                                @if($enquiry->next_follow_up)
                                    <span class="{{ $enquiry->next_follow_up->isToday() ? 'text-red-500 font-bold' : '' }}">
                                        {{ $enquiry->next_follow_up->format('d M, Y') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                        @if($enquiry->status == 'Pending') bg-yellow-100 text-yellow-700
                                        @elseif($enquiry->status == 'Admitted') bg-green-100 text-green-700
                                        @elseif($enquiry->status == 'Rejected') bg-red-100 text-red-700
                                        @else bg-blue-50 text-blue-700 @endif">
                                    {{ $enquiry->status }}
                                </span>
                            </td>
                            <td class="p-4 text-right flex justify-end gap-2">
                                <a href="{{ route('admission-enquiries.edit', $enquiry) }}"
                                    class="text-blue-600 hover:bg-blue-50 p-2 rounded-lg transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </a>
                                <form action="{{ route('admission-enquiries.destroy', $enquiry) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:bg-red-50 p-2 rounded-lg transition"
                                        title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-400">
                                No enquiries found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $enquiries->links() }}
        </div>
    </div>
</x-master-layout>