<x-master-layout>
    <div class="max-w-2xl mx-auto mt-10">
        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-red-700 mb-2">Confirm Deletion</h2>
            <p class="text-red-700 font-medium mb-6">Are you sure you want to delete this grade? This action cannot be
                undone.</p>

            <div class="bg-white p-4 rounded-lg shadow-sm border border-red-100 mb-6">
                <div class="flex items-center space-x-3 mb-2">
                    <span class="px-3 py-1 rounded-full text-sm font-bold"
                        style="background-color: {{ $grade->color_code ?? '#e2e8f0' }}; color: #1a202c;">
                        {{ $grade->grade }}
                    </span>
                    <span class="text-gray-600 font-medium">
                        {{ $grade->min_marks }}% - {{ $grade->max_marks }}%
                    </span>
                </div>
                <p class="text-gray-500 text-sm">{{ $grade->description }}</p>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('grades.index') }}"
                    class="px-5 py-2.5 rounded-lg border border-red-200 text-red-700 hover:bg-red-100 transition font-medium">Cancel</a>
                <form action="{{ route('grades.destroy', $grade->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-red-600 text-white hover:bg-red-700 transition font-medium shadow-sm">Delete
                        Permanently</button>
                </form>
            </div>
        </div>
    </div>
</x-master-layout>