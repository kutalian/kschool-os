<x-master-layout>
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Add New Grade</h1>
            <p class="text-gray-500">Define a new grading range</p>
        </div>

        <form action="{{ route('grades.store') }}" method="POST"
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Grade Name -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Grade Name</label>
                    <input type="text" name="grade" value="{{ old('grade') }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition"
                        placeholder="e.g. A, B+, Distinction">
                    @error('grade') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Grade Point -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Grade Point</label>
                    <input type="number" step="0.1" name="grade_point" value="{{ old('grade_point') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition"
                        placeholder="e.g. 4.0, 3.5">
                    @error('grade_point') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Marks Range -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Min Marks (%)</label>
                    <input type="number" name="min_marks" value="{{ old('min_marks') }}" required min="0" max="100"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('min_marks') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Max Marks (%)</label>
                    <input type="number" name="max_marks" value="{{ old('max_marks') }}" required min="0" max="100"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('max_marks') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Remarks -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Remarks / Description</label>
                    <input type="text" name="description" value="{{ old('description') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition"
                        placeholder="e.g. Excellent, Very Good">
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Color Code -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Badge Color</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="color_code" value="{{ old('color_code', '#4fd1c5') }}"
                            class="h-10 w-20 rounded border-gray-300 cursor-pointer">
                        <span class="text-xs text-gray-500">Pick a color for the grade badge</span>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('grades.index') }}"
                    class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition font-medium">Cancel</a>
                <button type="submit"
                    class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium shadow-sm">Save
                    Grade</button>
            </div>
        </form>
    </div>
</x-master-layout>