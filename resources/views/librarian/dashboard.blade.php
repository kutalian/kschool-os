<x-master-layout>
    <div class="fade-in">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Library Dashboard</h1>
        
        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
                <div class="rounded-full bg-blue-100 p-4 mr-4 text-blue-600">
                    <i class="fas fa-book text-2xl"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-medium">Total Books</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $totalBooks }}</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
                <div class="rounded-full bg-yellow-100 p-4 mr-4 text-yellow-600">
                    <i class="fas fa-book-reader text-2xl"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-medium">Books Issued</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $issuedBooks }}</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
                <div class="rounded-full bg-red-100 p-4 mr-4 text-red-600">
                    <i class="fas fa-exclamation-circle text-2xl"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-medium">Overdue Books</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $overdueBooks }}</div>
                </div>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Recent Issues</h3>
                <a href="{{ route('librarian.issue.create') }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">Issue New Book &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Book</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Issued To</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date Issued</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Due Date</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentIssues as $issue)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $issue->book->title }}</div>
                                    <div class="text-xs text-gray-500">{{ $issue->book->isbn ?? 'No ISBN' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $issue->student->first_name ?? $issue->user->name ?? 'Unknown' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($issue->issue_date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($issue->due_date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($issue->status == 'issued')
                                        @if(\Carbon\Carbon::parse($issue->due_date)->isPast())
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Overdue</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Issued</span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($issue->status) }}</span>
                                <td class="px-6 py-4 text-sm text-right">
                                    @if($issue->status == 'issued')
                                        <form action="{{ route('librarian.issue.return', $issue->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Mark this book as returned?');">
                                            @csrf
                                            <button type="submit" class="text-blue-600 hover:text-blue-900 font-semibold text-xs border border-blue-200 bg-blue-50 px-3 py-1 rounded hover:bg-blue-100 transition">
                                                Return
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500 italic">No recent book issues found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-master-layout>
