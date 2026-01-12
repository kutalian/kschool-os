<x-master-layout>
    <div class="max-w-2xl mx-auto mt-10">
        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-red-700 mb-2">Confirm Deletion</h2>
            <p class="text-red-700 font-medium mb-6">Are you sure you want to delete this fee type? This action cannot
                be undone.</p>

            <div class="bg-white p-4 rounded-lg shadow-sm border border-red-100 mb-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-bold text-gray-800">{{ $fee->name }}</span>
                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">{{ $fee->frequency }}</span>
                </div>
                <div class="text-2xl font-bold text-gray-900 mb-2">₦{{ number_format($fee->amount, 2) }}</div>
                <p class="text-gray-500 text-sm">{{ $fee->description }}</p>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('fees.index') }}"
                    class="px-5 py-2.5 rounded-lg border border-red-200 text-red-700 hover:bg-red-100 transition font-medium">Cancel</a>
                <form action="{{ route('fees.destroy', $fee->id) }}" method="POST" class="inline">
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