<x-master-layout>
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto space-y-6">
            <!-- Header -->
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <a href="{{ isset($book) ? route('library.issue.create', $book->id) : route('library.index') }}"
                        class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:text-blue-600 hover:border-blue-200 transition shadow-sm">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ isset($book) ? 'Book History' : 'Global Transaction History' }}</h1>
                        <p class="text-gray-500 text-sm">
                            {{ isset($book) ? 'Circulation record for "' . $book->title . '"' : 'All issue and return records across the library' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Book Details Summary (Only show if specific book) -->
            @if(isset($book))
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xl">
                        <i class="fas fa-book"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">{{ $book->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $book->author }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Current Status</div>
                    <div
                        class="text-lg font-bold {{ $book->available_copies > 0 ? 'text-green-600' : 'text-red-500' }}">
                        {{ $book->available_copies > 0 ? 'Available' : 'Out of Stock' }}
                    </div>
                </div>
            </div>
            @endif

            <!-- History Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                @if(!isset($book))
                                    <th class="p-5 font-semibold text-gray-600 text-sm">Book</th>
                                @endif
                                <th class="p-5 font-semibold text-gray-600 text-sm">User</th>
                                <th class="p-5 font-semibold text-gray-600 text-sm">Issued Date</th>
                                <th class="p-5 font-semibold text-gray-600 text-sm">Due Date</th>
                                <th class="p-5 font-semibold text-gray-600 text-sm">Return Date</th>
                                <th class="p-5 font-semibold text-gray-600 text-sm">Condition</th>
                                <th class="p-5 font-semibold text-gray-600 text-sm">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($history as $record)
                                <tr class="hover:bg-gray-50 transition">
                                    @if(!isset($book))
                                        <td class="p-5">
                                            <div class="font-bold text-gray-800">{{ $record->book->title ?? 'Unknown Book' }}</div>
                                            <div class="text-xs text-gray-500">{{ $record->book->author ?? '' }}</div>
                                        </td>
                                    @endif
                                    <td class="p-5">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold">
                                                {{ substr($record->user->username ?? 'U', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">
                                                    {{ $record->user->username ?? 'Unknown' }}</div>
                                                <div class="text-xs text-gray-500 capitalize">
                                                    {{ $record->user->role ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-5 text-sm text-gray-600">
                                        {{ $record->issue_date ? $record->issue_date->format('M d, Y') : '-' }}
                                    </td>
                                    <td class="p-5 text-sm text-gray-600">
                                        {{ $record->due_date ? $record->due_date->format('M d, Y') : '-' }}
                                    </td>
                                    <td class="p-5 text-sm text-gray-600">
                                        {{ $record->return_date ? $record->return_date->format('M d, Y') : '-' }}
                                    </td>
                                    <td class="p-5 text-sm">
                                        @if($record->return_condition)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $record->return_condition }}
                                            </span>
                                        @else
                                            <span class="text-gray-300">-</span>
                                        @endif
                                    </td>
                                    <td class="p-5">
                                        @if($record->status === 'issued')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                                Issued
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                                Returned
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ isset($book) ? '6' : '7' }}" class="p-10 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                                                <i class="fas fa-history text-gray-400 text-2xl"></i>
                                            </div>
                                            <p class="font-medium">No history records found</p>
                                            <p class="text-xs mt-1">{{ isset($book) ? "This book hasn't been issued yet." : "No books have been issued yet." }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination if needed later -->
                @if(method_exists($history, 'links'))
                    <div class="p-4 border-t border-gray-100">
                        {{ $history->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-master-layout>