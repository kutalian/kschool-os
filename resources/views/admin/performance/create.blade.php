<x-master-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">New Performance Review</h1>
            <p class="text-gray-500">Evaluate a staff member's performance</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('performance-reviews.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Staff & Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Staff Member <span
                                class="text-red-500">*</span></label>
                        <select name="staff_id" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                            <option value="">Select Staff...</option>
                            @foreach($staff as $member)
                                <option value="{{ $member->id }}">{{ $member->name }} ({{ $member->role_type }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Review Date <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="review_date" value="{{ date('Y-m-d') }}" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    </div>
                </div>

                <!-- Rating -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Overall Rating (1-5) <span
                            class="text-red-500">*</span></label>
                    <div class="flex gap-4">
                        @for($i = 1; $i <= 5; $i++)
                            <label
                                class="cursor-pointer flex items-center space-x-2 border p-3 rounded-lg hover:bg-gray-50 transition peer-checked:bg-blue-50 peer-checked:border-blue-500">
                                <input type="radio" name="rating" value="{{ $i }}"
                                    class="w-4 h-4 text-blue-600 focus:ring-blue-500" required>
                                <span class="text-gray-700 font-medium">{{ $i }} <i
                                        class="fas fa-star text-yellow-400 text-xs"></i></span>
                            </label>
                        @endfor
                    </div>
                </div>

                <!-- Comments -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Feedback & Comments</label>
                    <textarea name="comments" rows="5"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition"
                        placeholder="Enter detailed feedback here..."></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('performance-reviews.index') }}"
                        class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition font-medium">Cancel</a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium shadow-sm">
                        Save Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>