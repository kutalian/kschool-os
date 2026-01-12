<x-master-layout>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Performance Reviews</h1>
            <p class="text-gray-500">Track and manage staff performance evaluations</p>
        </div>
        <a href="{{ route('performance-reviews.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i> Add Review
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 font-semibold text-gray-600">Date</th>
                    <th class="px-6 py-4 font-semibold text-gray-600">Staff Member</th>
                    <th class="px-6 py-4 font-semibold text-gray-600">Rating</th>
                    <th class="px-6 py-4 font-semibold text-gray-600">Reviewer</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($reviews as $review)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-600">{{ $review->review_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-800">{{ $review->staff->name }}</div>
                            <div class="text-xs text-gray-500">{{ $review->staff->role_type }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star text-gray-300"></i>
                                    @endif
                                @endfor
                                <span class="ml-2 text-gray-600 text-sm font-medium">{{ $review->rating }}/5</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $review->reviewer->name ?? 'Unknown' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('performance-reviews.show', $review->id) }}"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium mr-3">View</a>
                            <a href="{{ route('performance-reviews.delete', $review->id) }}"
                                class="text-red-600 hover:text-red-800 text-sm font-medium">Delete</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-clipboard-list text-4xl mb-3 text-gray-300"></i>
                            <p>No performance reviews found.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-gray-100">
            {{ $reviews->links() }}
        </div>
    </div>
</x-master-layout>