<x-master-layout>
    <div class="flex items-center justify-center min-h-[80vh]">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 max-w-lg w-full text-center">

            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100 mb-6">
                <svg class="h-10 w-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-2">Delete Performance Review?</h2>
            <p class="text-gray-500 mb-6">Are you sure you want to remove this evaluation?</p>

            <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-400 uppercase tracking-wider font-semibold">Staff Member</div>
                        <div class="font-bold text-gray-800 text-lg">{{ $performanceReview->staff->name }}</div>
                        <div class="text-xs text-gray-500">{{ $performanceReview->staff->role_type }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-400 uppercase tracking-wider font-semibold">Rating</div>
                        <div class="text-lg font-bold text-yellow-500">
                            {{ $performanceReview->rating }}/5 <i class="fas fa-star text-xs"></i>
                        </div>
                        <div class="text-xs text-gray-500">{{ $performanceReview->review_date->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 border border-red-100 rounded-lg p-4 mb-8 text-left">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Warning:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>This action cannot be undone. The review data will be permanently removed.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex space-x-4">
                <a href="{{ route('performance-reviews.index') }}"
                    class="w-1/2 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Cancel
                </a>
                <form action="{{ route('performance-reviews.destroy', $performanceReview->id) }}" method="POST"
                    class="w-1/2">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-trash-alt mr-2"></i> Confirm Delete
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-master-layout>