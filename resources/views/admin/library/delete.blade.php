<x-master-layout>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="p-8 text-center">
                <!-- Icon -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-6">
                    <i class="fas fa-exclamation-triangle text-2xl text-yellow-600"></i>
                </div>

                <!-- Title -->
                @if($activeIssues > 0)
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Cannot Delete Book</h2>
                    <p class="text-gray-500 mb-8">This book has currently issued copies and cannot be deleted.</p>
                @else
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Delete Book?</h2>
                    <p class="text-gray-500 mb-8">Are you sure you want to delete this book?</p>
                @endif

                <!-- Book Card -->
                <div class="bg-gray-50 rounded-xl p-4 mb-6 text-left border border-gray-200">
                    <div class="flex items-start gap-4">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover"
                                class="w-12 h-16 object-cover rounded shadow-sm flex-shrink-0">
                        @else
                            <div
                                class="w-12 h-16 bg-gray-200 rounded flex items-center justify-center text-gray-400 flex-shrink-0">
                                <i class="fas fa-book"></i>
                            </div>
                        @endif
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $book->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $book->author }}</p>
                            <div class="mt-1 text-xs text-gray-400">ISBN: {{ $book->isbn ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Related Records Warning -->
                @if($totalHistory > 0)
                    <div class="bg-yellow-50 rounded-lg p-4 mb-6 text-left border border-yellow-100">
                        <div class="flex items-center justify-between text-yellow-800 font-medium mb-1">
                            <span><i class="fas fa-history mr-2"></i> Circulation History</span>
                            <span
                                class="bg-yellow-200 text-yellow-900 py-0.5 px-2 rounded-full text-xs font-bold">{{ $totalHistory }}</span>
                        </div>
                        <p class="text-xs text-yellow-700 mt-1 pl-6">Past issue/return records found.</p>
                    </div>
                @endif

                @if($activeIssues > 0)
                    <!-- Active Issues Blocker -->
                    <div class="bg-red-50 rounded-lg p-4 mb-8 text-left border border-red-100">
                        <div class="flex items-center justify-between text-red-800 font-medium mb-1">
                            <span><i class="fas fa-hand-holding-open mr-2"></i> Active Issues</span>
                            <span
                                class="bg-red-200 text-red-900 py-0.5 px-2 rounded-full text-xs font-bold">{{ $activeIssues }}</span>
                        </div>
                        <p class="text-xs text-red-700 mt-1 pl-6">You must return all copies before deleting.</p>
                    </div>
                @elseif($totalHistory > 0)
                    <!-- Last Warning -->
                    <div class="bg-red-50 rounded-lg p-4 mb-8 text-left border border-red-100 text-sm text-red-700">
                        <p><i class="fas fa-exclamation-triangle mr-1"></i> <strong>Warning:</strong> Deleting this book
                            will also permanently remove all its history records. This action cannot be undone.</p>
                    </div>
                @endif

                <!-- Actions -->
                <div class="flex gap-3">
                    <a href="{{ route('library.index') }}"
                        class="flex-1 bg-white border border-gray-300 text-gray-700 py-2.5 rounded-xl font-medium hover:bg-gray-50 transition shadow-sm">
                        Cancel
                    </a>

                    @if($activeIssues == 0)
                        <form action="{{ route('library.book.destroy', $book->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full bg-red-600 text-white py-2.5 rounded-xl font-medium hover:bg-red-700 transition shadow-lg shadow-red-500/30">
                                Delete All
                            </button>
                        </form>
                    @else
                        <button disabled
                            class="flex-1 bg-gray-300 text-white py-2.5 rounded-xl font-medium cursor-not-allowed">
                            Delete Disabled
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-master-layout>