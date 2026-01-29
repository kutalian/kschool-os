<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">My Library History</h1>
                <p class="text-gray-500 text-sm">Track books you have borrowed and upcoming return dates</p>
            </div>
            <a href="{{ route('staff.library.available') }}" 
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-semibold transition shadow-sm flex items-center">
                <i class="fas fa-search-plus mr-2"></i> Browse Available Books
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Book Details</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Issue Date</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Due Date</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Return Date</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($bookIssues as $issue)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800">{{ $issue->book->title }}</div>
                                    <div class="text-xs text-gray-500">{{ $issue->book->author }} (ISBN: {{ $issue->book->isbn }})</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $issue->issue_date ? (is_string($issue->issue_date) ? $issue->issue_date : $issue->issue_date->format('M d, Y')) : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm {{ $issue->isOverdue ? 'text-red-600 font-bold' : 'text-gray-700' }}">
                                    {{ $issue->due_date ? (is_string($issue->due_date) ? $issue->due_date : $issue->due_date->format('M d, Y')) : 'N/A' }}
                                    @if($issue->isOverdue)
                                        <span class="block text-[10px] uppercase tracking-tighter">Overdue</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $issue->return_date ? (is_string($issue->return_date) ? $issue->return_date : $issue->return_date->format('M d, Y')) : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusClasses = [
                                            'requested' => 'bg-amber-100 text-amber-700',
                                            'issued' => 'bg-blue-100 text-blue-700',
                                            'returned' => 'bg-green-100 text-green-700',
                                            'lost' => 'bg-red-100 text-red-700',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-bold rounded-full uppercase tracking-wider {{ $statusClasses[$issue->status] ?? 'bg-gray-100' }}">
                                        {{ $issue->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center gap-2">
                                        <i class="fas fa-book-open text-3xl opacity-20"></i>
                                        <p>You haven't borrowed any books yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($bookIssues->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $bookIssues->links() }}
                </div>
            @endif
        </div>
    </div>
</x-master-layout>
