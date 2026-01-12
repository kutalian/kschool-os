<x-master-layout>
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Review Details</h1>
                <p class="text-gray-500">Performance evaluation for {{ $performanceReview->staff->name }}</p>
            </div>
            <a href="{{ route('performance-reviews.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <div>
                    <div class="text-sm text-gray-500 uppercase tracking-wide font-semibold">Staff Member</div>
                    <div class="text-xl font-bold text-gray-800">{{ $performanceReview->staff->name }}</div>
                    <div class="text-sm text-gray-600">{{ $performanceReview->staff->role_type }}</div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500 uppercase tracking-wide font-semibold">Review Date</div>
                    <div class="text-lg font-medium text-gray-800">
                        {{ $performanceReview->review_date->format('F d, Y') }}
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8">
                <!-- Rating -->
                <div class="mb-8 text-center">
                    <div class="inline-block px-6 py-3 bg-blue-50 rounded-full border border-blue-100">
                        <span class="text-gray-600 font-medium mr-2">Overall Rating:</span>
                        <div class="inline-flex items-center text-2xl text-yellow-400">
                            <span class="font-bold text-gray-800 mr-2">{{ $performanceReview->rating }}/5</span>
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $performanceReview->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star text-gray-300"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Comments -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Feedback & Comments</h3>
                    <div
                        class="bg-gray-50 p-6 rounded-lg border border-gray-100 text-gray-700 leading-relaxed whitespace-pre-wrap">
                        {{ $performanceReview->comments ?: 'No written feedback provided.' }}
                    </div>
                </div>

                <!-- Reviewer -->
                <div class="flex items-center justify-end text-sm text-gray-500 mt-8 pt-6 border-t border-gray-100">
                    <i class="fas fa-user-check mr-2"></i> Reviewed by
                    {{ $performanceReview->reviewer->name ?? 'Unknown' }}
                </div>
            </div>

            <div class="bg-gray-50 p-4 border-t border-gray-100 flex justify-end">
                <a href="{{ route('performance-reviews.delete', $performanceReview->id) }}"
                    class="text-red-600 hover:text-red-800 font-medium px-4 py-2">Delete Review</a>
            </div>
        </div>
    </div>
</x-master-layout>